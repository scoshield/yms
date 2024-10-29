<?php

namespace App\Http\Controllers\Admin;


// use Gate;
use App\Service;
use App\Yard;
use App\GatePass;
use App\Client;
use App\Hauler;
use App\Employee;
use App\LoadingBay;
use App\InventoryItem;
use App\Appointment;
use App\AppointmentDocument;
use App\Document;
use App\Events\AppointmentApproved;
use App\Http\Controllers\Controller;
use App\Events\AppointmentCreatedEvent;
use App\Http\Requests\MassDestroyAppointmentRequest;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Elibyy\TCPDF\Facades\TCPDF;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppointmentsController extends Controller
{
    public function index(Request $request)
    {
        //dd($request->user()->can('grant_hod_approval'));
        //dd(Auth::user());
        if ($request->ajax()) {
            $query = Appointment::with(['hauler', 'creator', 'yard', 'gate_pass'])
                ->select(sprintf('%s.*', (new Appointment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'appointment_show';
                $editGate      = 'appointment_edit';
                $deleteGate    = 'appointment_delete';
                $admitAppointmentGate = 'appointment_admit';
                $hodAppointmentGate = 'grant_hod_approval';
                $securityAppointmentGate = 'grant_security_approval';
                $printPassAppointmentGate = 'appointment_printpass';
                $appointmentGateout = 'appointment_gateout';
                $crudRoutePart = 'appointments';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'hodAppointmentGate',
                    'securityAppointmentGate',
                    'admitAppointmentGate',
                    'printPassAppointmentGate',
                    'crudRoutePart',
                    'appointmentGateout',
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

            $table->editColumn('appointment', function ($row) {
                return $row->driver_name . ' (' . $row->truck_details . ')';
            });

            $table->addColumn('creator_name', function ($row) {
                return $row->creator ? $row->creator->name : '';
            });

            $table->editColumn('purpose', function ($row) {
                return $row->purpose ? config('appointment.purpose')[$row->purpose] : "";
            });

            $table->editColumn('type', function ($row) {
                return $row->type ? config('appointment.type')[$row->type] : "";
            });

            $table->editColumn('comments', function ($row) {
                return $row->comments ? $row->comments : "";
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? config('appointment.status')[$row->status] : "";
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
        $inventory_items = InventoryItem::all()->pluck('ref', 'id')->prepend(trans('global.pleaseSelect'), '');
        $purposes = config('app.purpose_of_visit');

        return view('admin.appointments.create', compact('haulers', 'yards', 'purposes', 'inventory_items'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $request->merge([
            //'yard_id' => Auth::user()->yard_id,
            'creator_id' => Auth::id()
        ]);

        // dd($request->all());

        $appointment = Appointment::create($request->all());
        $appointment->services()->sync($request->input('services', []));

        if (isset($request->checking_out_inventory_item_id)) {
            $inventory_item = InventoryItem::find($request->checking_out_inventory_item_id);
            $inventory_item->status = 'checked_out';
            $inventory_item->checked_out = true;
            $inventory_item->update();
            dd($inventory_item);
            return redirect()->route('admin.inventory_items.index');
        }

        // if
        // $supervisors = User::whereHas()
        //notify users
       event(new AppointmentCreatedEvent($appointment));

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
        $inventory_items = InventoryItem::all()->pluck('ref', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.appointments.edit', compact('haulers', 'yards', 'purposes', 'appointment', 'inventory_items'));
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
        $action = 'exit/enter';

        return view('admin.appointments.show', compact('appointment', 'action'));
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

        // dd($request);
        // $validator = Validator::make($request->all(), [
        //     'gateinImage' => ['required', 'image']
        // ]);

        // if($validator->fails())
        // {
        //     return back()->with(['message' => 'Truck image required.']);
        // }

        // $gatePass = null;
        // $path = $request->file('gateinImage')->store('entries');
        // $file = basename($path);
       
        DB::beginTransaction();

        try {
            $appointment = Appointment::find($request->id);
            $appointment->update(['status' => 'admitted']);
            $appointment->update(['admitted_at' => date('Y-m-d H:i:s')]);
            $appointment->update(['admitted_by' => Auth::id()]);
            // $appointment->update(['gatein_image_url' => $file]);

            $purpose = $appointment->purpose;
            $double = false;

            if($appointment->purpose == 'offloading_and_loading')
            {
                $purpose = 'offloading';
                $double = true;
            }
            LoadingBay::create([
                'ref' => Str::uuid()->toString(),
                'appointment_id' => $appointment->id,
                'type' => $purpose
            ]);
            // Create a loading request - 
            if($double)
            {
                LoadingBay::create([
                    'ref' => Str::uuid()->toString(),
                    'appointment_id' => $appointment->id,
                    'type' => 'loading'
                ]);
            }
            // save any attached documents
            foreach($request->documents as $doc)
            {
                $appDoc = AppointmentDocument::updateOrCreate([
                    'appointment_id' => $appointment->id,
                    'value' => $doc['value'],
                    'document_id' => $doc['id']
                ], ['user_id' => Auth::id()]);
            }
            // generate gatepass;
            $this->generatePass($appointment);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception('Something went wrong. '.$exception->getMessage());
            
        }
        DB::commit();
        return back()->with(['message' => 'Truck admitted to the facility']);
    }

    public function downloadFile($filename)
    {
        return Storage::download('/entries/'.$filename);
    }


    public function gateout(Request $request)
    {
        abort_if(Gate::denies('appointment_gateout'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gatePass = null;
        DB::transaction(function () use ($request) {
            $appointment = Appointment::find($request->id);
            $appointment->update(['status' => 'gateout']);
            $appointment->update(['gateout' => date('Y-m-d H:i:s')]);
            $appointment->update(['gateout_by' => Auth::id()]);

            // LoadingBay::create([
            //     'ref' => Str::uuid()->toString(),
            //     'appointment_id' => $appointment->id,
            //     'type' => $appointment->purpose
            // ]);

            // $this->generatePass($appointment);
        });

        return back();
    }

    public function gateoutTruck(Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_gateout'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$appointment->load('client', 'employee', 'services');
        $action = 'exit/enter';

        return view('admin.appointments.gateout', compact('appointment', 'action'));
    }

    public function gateinTruck(Request $request, Appointment $appointment)
    {
        abort_if(Gate::denies('appointment_gateout'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$appointment->load('client', 'employee', 'services');
        $action = 'exit/enter';
        $docs = Document::all();
        // dd($appointment);

        return view('admin.appointments.gatein', compact('appointment', 'action', 'docs'));
    }

    public function approve(Request $request)
    {
        if (!$request->user()->can('grant_hod_approval') || !$request->user()->can('grant_security_approval')) {
            abort(403);
        }

        $appointment = Appointment::find($request->id);
        $appointment->update(['status' => $request->approval_type . '_approved']);
        $appointment->update([$request->approval_type . '_approved_at' => date('Y-m-d H:i:s')]);
        $appointment->update([$request->approval_type . '_approved_by' => Auth::id()]);
        //event(new AppointmentApproved($appointment));
        return back();
    }

    public function approveAtLevel(Request $request)
    {
        if (!$request->user()->can('grant_hod_approval') || !$request->user()->can('grant_security_approval')) {
            abort(403);
        }

        //$ref = sha1($appointment->id) . $tag . sha1($level);
        $tag = "693fbc24-23ad-40a2-8fc3-9f1f05e4dc32";
        $ref = explode($tag, $request->ref);

        $id = $ref[0];
        $level = $ref[1] ?? '';

        $appointment_row = DB::select('select id from appointments where sha1(id) = ?', [$id]);
        $appointment_id = $appointment_row[0]->id ?? 1;
        $appointment = Appointment::find($appointment_id);

        $approval_type = 'hod';
        if ($level == sha1(2)) {
            $approval_type = 'security';
        }

        $appointment->update(['status' => $approval_type . '_approved']);
        $appointment->update([$approval_type . '_approved_at' => date('Y-m-d H:i:s')]);
        $appointment->update([$approval_type . '_approved_by' => Auth::id()]);
//        event(new AppointmentApproved($appointment));
        return redirect()->route('admin.appointments.index');
    }

    private function generatePass($appointment)
    {
        return GatePass::updateOrCreate(['appointment_id' => $appointment->id], [
            'ref' => Str::uuid()->toString(),
            'appointment_id' => $appointment->id,
            'created_by' => Auth::id()
        ]);
    }

    public function printPass(Request $request)
    {
        abort_if(Gate::denies('appointment_printpass'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $appointment = Appointment::find($request->appointment_id);
        $gatePass = GatePass::where('ref', $request->ref)->first();

        if (empty($request->ref) || is_null($request->ref)) {
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

        // set style for barcode
        $style = array(
            // 'border' => 2,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );

        $fileName = $appointment->truck_details . ' ' . $appointment->created_at . '.pdf';

        $qrCode = base64_encode(QrCode::format('svg')->size(256)->generate($gatePass->ref));

        $pdf = new TCPDF(
            PDF_PAGE_ORIENTATION,
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );

        //$logo_path = public_path('/images/AGL_LOGO.jfif');
        $pdf::SetCreator('YardMS');
        $pdf::SetAuthor('Your Company');
        $pdf::SetTitle('GatePass');

        $pdf::setPrintHeader(false);
        $pdf::setPrintFooter(false);

        $pdf::AddPage();

        $pdf::SetFont('helvetica', '', 10);

        $data = [
            'title' => 'Generate PDF using Laravel TCPDF - ItSolutionStuff.com!',
            'gatePass' => $gatePass,
            'appointment' => $appointment,
            'qrCode' => $qrCode,
            'action' => $action
        ];

        $html = view()->make('admin.appointments.gatepass', $data)->render();

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::write2DBarcode($appointment->codeRef(), 'PDF417', 155, 100, 0, 30, $style, 'N');
        //$pdf::Text(80, 85, $appointment->codeRef());

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
