<?php

namespace App\Http\Controllers\Admin;

use App\department;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroydepartmentRequest;
use App\Http\Requests\StoredepartmentRequest;
use App\Http\Requests\UpdatedepartmentRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = department::query()->select(sprintf('%s.*', (new department)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'department_show';
                $editGate      = 'department_edit';
                $deleteGate    = 'department_delete';
                $crudRoutePart = 'departments';

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

        return view('admin.departments.index');
    }

    public function create()
    {
        abort_if(Gate::denies('department_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $department = department::create($request->all());

        return redirect()->route('admin.department.index');
    }

    public function edit(department $department)
    {
        abort_if(Gate::denies('department_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, department $department)
    {
        $department->update($request->all());

        return redirect()->route('admin.department.index');
    }

    public function show(department $department)
    {
        abort_if(Gate::denies('department_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.departments.show', compact('department'));
    }

    public function destroy(department $department)
    {
        abort_if(Gate::denies('department_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        department::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
