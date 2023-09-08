<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\InventoryItem;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInventoryItemRequest;
use App\Http\Requests\StoreInventoryItemRequest;
use App\Http\Requests\UpdateInventoryItemRequest;
use App\Yard;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = InventoryItem::query()
                ->with(['yard', 'creator', 'department'])
                ->select(sprintf('%s.*', (new InventoryItem)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'inventory_item_show';
                $editGate      = 'inventory_item_edit';
                $deleteGate    = 'inventory_item_delete';
                $crudRoutePart = 'inventory_items';

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

            $table->editColumn('ref', function ($row) {
                return $row->ref ? $row->ref : "";
            });

            $table->editColumn('category', function ($row) {
                return $row->category ? ucfirst($row->category) : "";
            });

            $table->editColumn('size', function ($row) {
                return $row->size ? $row->size : "";
            });

            $table->addColumn('yard_name', function ($row) {
                return $row->yard ? $row->yard->name : '';
            });

            $table->addColumn('department_name', function ($row) {
                return $row->department ? $row->department->name : '';
            });

            $table->addColumn('creator_name', function ($row) {
                return $row->creator ? $row->creator->name : '';
            });

            $table->editColumn('um_number', function ($row) {
                return $row->um_number ? $row->um_number : "";
            });

            $table->editColumn('rtn_port', function ($row) {
                return $row->rtn_port ? $row->rtn_port : "";
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : "";
            });

            $table->editColumn('structural_status', function ($row) {
                return $row->structural_status ? $row->structural_status : "";
            });

            $table->editColumn('inspected', function ($row) {
                return $row->inspected ? "Y" : "N";
            });

            $table->editColumn('refurbished', function ($row) {
                return $row->refurbished ? "Y" : "N";
            });

            $table->editColumn('cnumbers_visible', function ($row) {
                return $row->cnumbers_visible ? "Y" : "N";
            });

            $table->editColumn('year_manufactured', function ($row) {
                return $row->year_manufactured ? $row->year_manufactured : "";
            });

            $table->editColumn('type', function ($row) {
                return $row->type ? $row->type : "";
            });

            $table->editColumn('remarks', function ($row) {
                return $row->remarks ? $row->remarks : "";
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.inventory_items.index');
    }

    public function create()
    {
        abort_if(Gate::denies('inventory_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $yards = Yard::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.inventory_items.create', compact('yards', 'departments'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'creator_id' => Auth::id()
        ]);

        $inventory_item = InventoryItem::create($request->all());

        return redirect()->route('admin.inventory_items.index');
    }

    public function edit(InventoryItem $inventory_item)
    {
        abort_if(Gate::denies('inventory_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $yards = Yard::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.inventory_items.edit', compact('inventory_item', 'yards', 'departments'));
    }

    public function update(Request $request, InventoryItem $inventory_item)
    {
        $inventory_item->update($request->all());

        return redirect()->route('admin.inventory_items.index');
    }

    public function show(InventoryItem $inventory_item)
    {
        abort_if(Gate::denies('inventory_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.inventory_items.show', compact('inventory_item'));
    }

    public function destroy(InventoryItem $inventory_item)
    {
        abort_if(Gate::denies('inventory_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inventory_item->delete();

        return back();
    }

    public function massDestroy(Request $request)
    {
        InventoryItem::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
