<?php

namespace App\Http\Controllers\Admin;

use App\LoadingBay;
use App\Http\Controllers\Controller;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoadingBayController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = LoadingBay::query()->select(sprintf('%s.*', (new LoadingBay)->table))->whereNull('finished_at');
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'loadingbay_show';
                $editGate      = 'loadingbay_edit';
                $deleteGate    = 'loadingbay_delete';
                $loadingbayStartGate    = 'loadingbay_start';
                $loadingbayFinishGate    = 'loadingbay_finish';
                $crudRoutePart = 'loadingbay';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'loadingbayStartGate',
                    'loadingbayFinishGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });

            $table->editColumn('type', function ($row) {
                //return $row->type ? ucwords($row->type) : "";
                return $row->type ? config('appointment.purpose')[$row->type] : "";
            });

            $table->editColumn('status', function ($row) {
                //return $row->status ? ucwords(str_replace('_',' ', $row->status)) : "";
                return $row->status ? config('appointment.loading_bay_status')[$row->status] : "";
            });

            $table->editColumn('appointment', function ($row) {
                return $row->appointment ? $row->appointment->driver_name . ' (' . $row->appointment->truck_details . ')' : "";
            });

            $table->editColumn('duration', function ($row) {
                $duration = "";

                if ($row->started_at && $row->finished_at) {
                    $datetime1 = new \DateTime($row->started_at);
                    $datetime2 = new \DateTime($row->finished_at);
                    $interval = $datetime1->diff($datetime2);

                    $dys = substr("0{$interval->format('%d')}", -2);
                    $hrs = substr("0{$interval->format('%h')}", -2);
                    $mns = substr("0{$interval->format('%i')}", -2);
                    return $dys . ":" . $hrs . ":" . $mns;
                }

                return $duration;
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.loadingbay.index');
    }

    public function create()
    {
        abort_if(Gate::denies('loadingbay_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loadingbay.create');
    }

    public function store(Request $request)
    {
        $loadingbay = LoadingBay::create($request->all());

        return redirect()->route('admin.loadingbay.index');
    }

    public function edit(LoadingBay $loadingbay)
    {
        abort_if(Gate::denies('loadingbay_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loadingbay.edit', compact('loadingbay'));
    }

    public function update(Request $request, LoadingBay $loadingbay)
    {
        $loadingbay->update($request->all());

        return redirect()->route('admin.loadingbay.index');
    }

    public function show(LoadingBay $loadingbay)
    {
        abort_if(Gate::denies('loadingbay_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.loadingbay.show', compact('loadingbay'));
    }


    public function startLoading($id)
    {
        abort_if(Gate::denies('loadingbay_start'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($loadingbay);
        $loadingbay = LoadingBay::findOrFail($id);
        return view('admin.loadingbay.start', compact('loadingbay'));
    }


    public function endLoading($id)
    {
        abort_if(Gate::denies('loadingbay_finish'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // dd($loadingbay);
        $loadingbay = LoadingBay::findOrFail($id);
        return view('admin.loadingbay.end', compact('loadingbay'));
    }

    public function destroy(LoadingBay $loadingbay)
    {
        abort_if(Gate::denies('loadingbay_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $loadingbay->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        LoadingBay::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function start(Request $request)
    {
        abort_if(Gate::denies('loadingbay_start'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'startImage' => ['required', 'image']
        ]);

        if($validator->fails())
        {
            return back()->with(['message' => 'Truck image required.']);
        }

        $path = $request->file('startImage')->store('entries');
        $file = basename($path);

        DB::beginTransaction();

        try {
            $loadingBay = LoadingBay::find($request->id);
            $loadingBay->update([
                'started_at' => date('Y-m-d H:i:s'),
                'status' => 'started_' . $loadingBay->type,
                'start_image_url' => $file
            ]);

            $appointment = $loadingBay->appointment;
            $appointment->update(['status' => 'started_' . $loadingBay->type]);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception('Something went wrong. ' . $exception->getMessage());
        }

        DB::commit();

        return back()->with(['message' => 'Truck loading details captured.']);
    }

    public function finish(Request $request)
    {
        abort_if(Gate::denies('loadingbay_finish'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $validator = Validator::make($request->all(), [
            'finishImage' => ['required', 'image']
        ]);

        if($validator->fails())
        {
            return back()->with(['message' => 'Truck image required.']);
        }

        $path = $request->file('finishImage')->store('outros');
        $file = basename($path);
        // dd($file);
        // DB::transaction(function () use ($request) {
        DB::beginTransaction();
        try {
            $loadingBay = LoadingBay::find($request->id);
            $loadingBay->update([
                'finished_at' => date('Y-m-d H:i:s'),
                'status' => 'finished_' . $loadingBay->type,
                'finish_image_url' => $file
            ]);

            $appointment = $loadingBay->appointment;
            $appointment->update(['status' => 'finished_' . $loadingBay->type]);
            $appointment->update(['process_done' => 1]);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception('Something went wrong. '.$exception->getMessage());            
        }

        DB::commit();           
        // });

        return back()->with(['message' => 'Truck timer logged.']);
    }
}
