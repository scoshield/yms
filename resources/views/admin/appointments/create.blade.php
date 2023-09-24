@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.appointment.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.appointments.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('hauler_id') ? 'has-error' : '' }}">
                        <label for="hauler">{{ trans('cruds.appointment.fields.hauler') }}*</label>
                        <select name="hauler_id" id="hauler" class="form-control select2" required>
                            @foreach ($haulers as $id => $hauler)
                                <option value="{{ $id }}"
                                    {{ (isset($appointment) && $appointment->hauler ? $appointment->hauler->id : old('hauler_id')) == $id ? 'selected' : '' }}>
                                    {{ $hauler }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('hauler_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('hauler_id') }}
                            </em>
                        @endif
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('purpose') ? 'has-error' : '' }}">
                        <label for="purpose">{{ trans('cruds.appointment.fields.purpose') }}*</label>
                        <select name="purpose" id="purpose" class="form-control select2" required>
                            @foreach ($purposes as $id => $purpose)
                                <option value="{{ $id }}"
                                    {{ (isset($appointment) && $appointment->purpose ? $appointment->purpose->id : old('purpose')) == $id ? 'selected' : '' }}>
                                    {{ $purpose }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('purpose_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('purpose_id') }}
                            </em>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('yard_id') ? 'has-error' : '' }}">
                    <label for="yard">{{ trans('cruds.appointment.fields.yard') }} *</label>
                    <select name="yard_id" id="yard" class="form-control select2">
                        @foreach ($yards as $id => $yard)
                            <option value="{{ $id }}"
                                {{ (isset($appointment) && $appointment->yard ? $appointment->yard->id : old('employee_id')) == $id ? 'selected' : '' }}>
                                {{ $yard }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('yard_id'))
                        <em class="invalid-feedback">
                            {{ $errors->first('yard_id') }}
                        </em>
                    @endif
                </div>

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('appointment_date') ? 'has-error' : '' }}">
                        <label for="appointment_date">
                            {{ trans('cruds.appointment.fields.date') }} *
                        </label>
                        <input type="text" id="appointment_date" name="appointment_date" class="form-control datetime"
                            value="{{ old('appointment_date', isset($appointment) ? $appointment->appointment_date : '') }}" required>
                        @if ($errors->has('appointment_date'))
                            <em class="invalid-feedback">
                                {{ $errors->first('appointment_date') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.date_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('file_number') ? 'has-error' : '' }}">
                        <label for="file_number">{{ trans('cruds.appointment.fields.file_number') }}</label>
                        <input type="text" id="file_number" name="file_number" class="form-control"
                            value="{{ old('file_number', isset($appointment) ? $appointment->file_number : '') }}">
                        @if ($errors->has('file_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('file_number') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.file_number_helper') }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('container_number') ? 'has-error' : '' }}">
                        <label for="container_number">{{ trans('cruds.appointment.fields.container_number') }}</label>
                        <input type="text" id="container_number" name="container_number" class="form-control"
                            value="{{ old('container_number', isset($appointment) ? $appointment->container_number : '') }}">
                        @if ($errors->has('container_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('container_number') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.container_number_helper') }}
                        </p>
                    </div>

                     <div class="form-group col-md-6 {{ $errors->has('driver_name') ? 'has-error' : '' }}">
                        <label for="driver_name">{{ trans('cruds.appointment.fields.driver_name') }}</label>
                        <input type="text" id="driver_name" name="driver_name" class="form-control"
                            value="{{ old('driver_name', isset($appointment) ? $appointment->driver_name : '') }}">
                        @if ($errors->has('driver_name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('driver_name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.driver_name_helper') }}
                        </p>
                    </div>
                </div>

                {{-- <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                    <label for="price">{{ trans('cruds.appointment.fields.price') }}</label>
                    <input type="number" id="price" name="price" class="form-control"
                        value="{{ old('price', isset($appointment) ? $appointment->price : '') }}" step="0.01">
                    @if ($errors->has('price'))
                        <em class="invalid-feedback">
                            {{ $errors->first('price') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.price_helper') }}
                    </p>
                </div> --}}

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('contact_details') ? 'has-error' : '' }}">
                        <label for="contact_details">{{ trans('cruds.appointment.fields.contact_details') }}</label>
                        <input type="text" id="contact_details" name="contact_details" class="form-control"
                            value="{{ old('contact_details', isset($appointment) ? $appointment->contact_details : '') }}">
                        @if ($errors->has('contact_details'))
                            <em class="invalid-feedback">
                                {{ $errors->first('contact_details') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.contact_details_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('truck_details') ? 'has-error' : '' }}">
                        <label for="truck_details">{{ trans('cruds.appointment.fields.truck_details') }}</label>
                        <input type="text" id="truck_details" name="truck_details" class="form-control"
                            value="{{ old('truck_details', isset($appointment) ? $appointment->truck_details : '') }}">

                        @if ($errors->has('truck_details'))
                            <em class="invalid-feedback">
                                {{ $errors->first('truck_details') }}
                            </em>
                        @endif

                        <p class="helper-block">
                            {{ trans('cruds.appointment.fields.track_details_helper') }}
                        </p>
                    </div>

                </div>


                <div class="form-group {{ $errors->has('comments') ? 'has-error' : '' }}">
                    <label for="comments">{{ trans('cruds.appointment.fields.comments') }}</label>
                    <textarea id="comments" name="comments" class="form-control ">{{ old('comments', isset($appointment) ? $appointment->comments : '') }}</textarea>
                    @if ($errors->has('comments'))
                        <em class="invalid-feedback">
                            {{ $errors->first('comments') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.comments_helper') }}
                    </p>
                </div>

                {{-- <div class="form-group {{ $errors->has('services') ? 'has-error' : '' }}">
                    <label for="services">{{ trans('cruds.appointment.fields.services') }}
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span></label>
                    <select name="services[]" id="services" class="form-control select2" multiple="multiple">
                        @foreach ($services as $id => $services)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('services', [])) || (isset($appointment) && $appointment->services->contains($id)) ? 'selected' : '' }}>
                                {{ $services }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('services'))
                        <em class="invalid-feedback">
                            {{ $errors->first('services') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.appointment.fields.services_helper') }}
                    </p>
                </div> --}}

                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
