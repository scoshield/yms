<?php

namespace App\Http\Controllers\Admin;

use App\Hauler;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyHaulerRequest;
use App\Http\Requests\StoreHaulerRequest;
use App\Http\Requests\UpdateHaulerRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class HaulerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Hauler::query()->select(sprintf('%s.*', (new Hauler)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'hauler_show';
                $editGate      = 'hauler_edit';
                $deleteGate    = 'hauler_delete';
                $crudRoutePart = 'haulers';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : "";
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.haulers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('hauler_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.haulers.create');
    }

    public function store(Request $request)
    {
        $hauler = Hauler::create($request->all());

        return redirect()->route('admin.haulers.index');
    }

    public function edit(Hauler $hauler)
    {
        abort_if(Gate::denies('hauler_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.haulers.edit', compact('hauler'));
    }

    public function update(Request $request, Hauler $hauler)
    {
        $hauler->update($request->all());

        return redirect()->route('admin.haulers.index');
    }

    public function show(Hauler $hauler)
    {
        abort_if(Gate::denies('hauler_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.haulers.show', compact('hauler'));
    }

    public function destroy(Hauler $hauler)
    {
        abort_if(Gate::denies('hauler_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $hauler->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Hauler::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
