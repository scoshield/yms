@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.loadingbay.title') }}
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <table class="table table-sm table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.loadingbay.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $loadingbay->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Type
                                    </th>
                                    <td>
                                        {{ $loadingbay->type }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Appointment Date & Time
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->appointment_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Truck Details
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->truck_details }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Driver Details
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->driver_name }},
                                        {{ $loadingbay->appointment->contact_details }},
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        File Number
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->file_number }}

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Container Number
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->container_number }}

                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Yard
                                    </th>
                                    <td>
                                        {{ $loadingbay->appointment->yard->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    <td>
                                        {{ $loadingbay->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Comments</th>
                                    <td>{{ $loadingbay->appointment->comments }}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        {{-- <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                            {{ trans('global.back_to_list') }}
                        </a> --}}
                    </div>

                    <nav class="mb-3">
                        <div class="nav nav-tabs">
                        </div>
                    </nav>
                    <div class="tab-content">

                    </div>
                </div>
                <form action="{{ route('admin.loadingbay.start') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;"
                    class="mt-2">
                    <div class="card-body pt-0">
                        <div class="row">                           
                            <div class="col-md-12">
                                <label for="environment" class="form-label">Capture Truck</label><br/>
                                <input type="file" class="form-controll" id="environment" name="startImage"
                                    accept="image/*">
                            </div>
                            <div class="col-md-12 mt-2">
                                @if ($loadingbay->start_image_url)
                                    <span class="fw-bold fs-6">Truck Image</span>
                                    <img src="{{ asset( '/entries/'.$loadingbay->start_image_url ) }}" alt="{{ $loadingbay->truck_details }}" class="img-thumbnail">
                                @endif
                            </div>
                            <div class="col-md-12 mt-2">
                                @can('loadingbay_start')
                                    @if ($loadingbay->status == 'waiting')
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id" value="{{ $loadingbay->id }}">
                                        <input type="submit" class="btn btn-dark" value="{{ trans('global.start') .' '. $loadingbay->type }}">
                                    @endif
                                @endcan
                                <a style="" class="btn btn-default" href="{{ url()->previous() }}">
                                    {{ trans('global.back_to_list') }}
                                </a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
