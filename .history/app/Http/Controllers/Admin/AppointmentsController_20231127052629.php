<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\Client;
use App\Employee;
use App\Hauler;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\LoadingBay;
use App\Service;
use App\Yard;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\GatePass;
use Illuminate\Support\Str;
use Elibyy\TCPDF\Facades\TCPDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Appointment::with(['hauler', 'creator', 'yard','gate_pass'])
                ->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $admitAppointmentGate = 'appointment_admit';
                $printPassAppointmentGate = 'appointment_printpass';
                $crudRoutePart = 'appointments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'admitAppointmentGate',
                    'printPassAppointmentGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->addColumn('hauler_name', function ($row) {
                return $row->hauler ? $row->hauler->name : '';
            });

            $table->addColumn('yard_name', function ($row) {
                return $row->yard ? $row->yard->name : '';
            });

            $table->addColumn('creator_name', function ($row) {
                return $row->creator ? $row->creator->name : '';
            });

            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? $row->purpose : "";
            });

            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : "";
            });

            // $table->editColumn('services', function ($row) {
            //     $labels = [];

            //     foreach ($row->services as $service) {
            //         $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $service->name);
            //     }

            //     return implode(' ', $labels);
            // });

            $table->rawColumns(['actions', 'placeholder', 'yard', 'hauler', 'creator']);

            return $table->make(true);
        }

        return view('admin.appointments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('appointment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $services = Service::all()->pluck('name', 'id');

        $haulers = Hauler::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $yards = Yard::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $purposes = config('app.purpose_of_visit');

        return view('admin.appointments.create', compact('haulers', 'yards', 'purposes'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $request->merge([
            //'yard_id' => Auth::user()->yard_id,
            'creator_id' => Auth::id()
        ]);

        $appointment = Appointment::create($request->all());
        $appointment->services()->sync($request->input('services', []));
        return redirect()->route('admin.appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $clients = Client::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = Employee::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $services = Service::all()->pluck('name', 'id');

        $haulers = Hauler::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $yards = Yard::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $purposes = config('app.purpose_of_visit');
        $appointment->load('hauler', 'yard', 'creator');

        return view('admin.appointments.edit', compact('haulers', 'yards', 'purposes', 'appointment'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->all());
        $appointment->services()->sync($request->input('services', []));

        return redirect()->route('admin.appointments.index');
    }

    public function show(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$appointment->load('client', 'employee', 'services');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function destroy(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointment->delete();

        return back();
    }

    public function admit(Request $request)
    {
        abort_if(Gate::denies('appointment_admit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        $gatePass = null;
        DB::transaction(function() use ($request) {
            $appointment = Appointment::find($request->id);
            $appointment->update(['status' => 'admitted']);
            $appointment->update(['admitted_at' => date('Y-m-d H:i:s')]);
            $appointment->update(['admitted_by' => Auth::id()]);
            
            LoadingBay::create([
                'ref' => Str::uuid()->toString(),
                'appointment_id' => $appointment->id,
                'type' => $appointment->purpose
            ]);

            $this->generatePass($appointment);
        });
        
        return back();
    }

    private function generatePass($appointment){
        return GatePass::updateOrCreate(['appointment_id' => $appointment->id],[
            'ref' => Str::uuid()->toString(),
            'appointment_id' => $appointment->id,
            'created_by' => Auth::id()
        ]);
    }

    public function printPass(Request $request){
        abort_if(Gate::denies('appointment_printpass'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $appointment = Appointment::find($request->appointment_id);
        $gatePass = GatePass::where('ref',$request->ref)->first();

        if(empty($request->ref) || is_null($request->ref)){
            $gatePass = $this->generatePass($appointment);
        }

        $action = 'exit/enter';
        // if(in_array($appointment->purpose,['loading'])){
        //     $action = 'enter';
        // }

        // 'loading' => 'Loading',
        // 'offloading' => 'Off loading',
        // 'offloading_and_loading' => 'Off loading & loading',
        // 'pick_empty' => 'Pick Empty',
        // 'drop_empty' => 'Drop Empty',
        // 'strip' => 'Stip',
        // 'cross_stuff' => 'Cross Stuff',
       
        $fileName = $appointment->truck_details.' '.$appointment->created_at;

        $qrCode = base64_encode(QrCode::format('svg')->size(256)->generate($gatePass->ref));

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        //$logo_path = public_path('/images/AGL_LOGO.jfif');
        $pdf::SetCreator('YardMS');
        $pdf::SetAuthor('Your Company');
        $pdf::SetTitle('Invoice');

        $pdf::setPrintHeader(false);
        $pdf::setPrintFooter(false);

        $pdf::AddPage();

        $pdf::SetFont('helvetica', '', 12);

        $data = [
            'title' => 'Generate PDF using Laravel TCPDF - ItSolutionStuff.com!',
            'gatePass' => $gatePass,
            'appointment' => $appointment,
            'qrCode'=>$qrCode,
            'action'=>$action
        ];

        $html = view()->make('admin.appointments.gatepass', $data)->render();

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::Output($fileName, 'I');

        //$pdf::writeHTML($html, true, false, true, false, '');
        //$pdf::Output(public_path($filename), 'F');
        //return response()->download(public_path($filename));
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
