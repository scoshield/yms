@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.inventory_item.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.inventory_item.fields.id') }}
                            </th>
                            <td>
                                {{ $inventory_item->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.inventory_item.fields.name') }}
                            </th>
                            <td>
                                {{ $inventory_item->name }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.inventory_item.fields.phone') }}
                            </th>
                            <td>
                                {{ $inventory_item->phone }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.inventory_item.fields.email') }}
                            </th>
                            <td>
                                {{ $inventory_item->email }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <nav class="mb-3">
                <div class="nav nav-tabs">

                </div>
            </nav>
            <div class="tab-content">

            </div>
        </div>
    </div>
@endsection
