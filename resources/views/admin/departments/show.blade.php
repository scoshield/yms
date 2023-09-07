@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.department.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.department.fields.id') }}
                            </th>
                            <td> {{ $department->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.department.fields.name') }}</th>
                            <td>{{ $department->name }}</td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.department.fields.phone') }}
                            </th>
                            <td>
                                {{ $department->phone }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.department.fields.email') }}
                            </th>
                            <td>
                                {{ $department->email }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            <nav class="mb-3">
                <div class="nav nav-tabs"></div>
            </nav>

            <div class="tab-content"></div>
        </div>
    </div>
@endsection
