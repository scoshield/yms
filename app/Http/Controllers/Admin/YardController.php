<?php

namespace App\Http\Controllers\Admin;

use App\Yard;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyYardRequest;
use App\Http\Requests\StoreYardRequest;
use App\Http\Requests\UpdateYardRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class YardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Yard::query()->select(sprintf('%s.*', (new Yard)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'yard_show';
                $editGate      = 'yard_edit';
                $deleteGate    = 'yard_delete';
                $crudRoutePart = 'yards';

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

        return view('admin.yards.index');
    }

    public function create()
    {
        abort_if(Gate::denies('yard_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.yards.create');
    }

    public function store(Request $request)
    {
        $yard = Yard::create($request->all());

        return redirect()->route('admin.yards.index');
    }

    public function edit(Yard $yard)
    {
        abort_if(Gate::denies('yard_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.yards.edit', compact('yard'));
    }

    public function update(Request $request, Yard $yard)
    {
        $yard->update($request->all());

        return redirect()->route('admin.yards.index');
    }

    public function show(Yard $yard)
    {
        abort_if(Gate::denies('yard_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.yards.show', compact('yard'));
    }

    public function destroy(Yard $yard)
    {
        abort_if(Gate::denies('yard_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yard->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        Yard::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
