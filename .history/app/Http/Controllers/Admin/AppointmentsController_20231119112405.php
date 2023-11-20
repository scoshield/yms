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

            GatePass::updateOrCreate(['appointment_id' => $appointment->id],[
                'ref' => Str::uuid()->toString(),
                'appointment_id' => $appointment->id,
                'created_by' => Auth::id()
            ]);
        });
        
        return redirect()->route('admin.appointments.printpass');;
    }

    public function printPass(Request $request){
        abort_if(Gate::denies('appointment_printpass'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $uuid = Str::uuid()->toString();
        dd($uuid);
        dd($request);
    }

    public function massDestroy(MassDestroyAppointmentRequest $request)
    {
        Appointment::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
