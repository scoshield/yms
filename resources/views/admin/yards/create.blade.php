@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.yard.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.yards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.yard.fields.name') }}</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($yard) ? $yard->name : '') }}">
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.yard.fields.name_helper') }}
                    </p>
                </div>

                <div class="form-group {{ $errors->has('physical_location') ? 'has-error' : '' }}">
                    <label for="physical_location">{{ trans('cruds.yard.fields.physical_location') }}</label>
                    <input type="text" id="physical_location" name="physical_location" class="form-control" value="{{ old('physical_location', isset($yard) ? $yard->physical_location : '') }}">
                    @if ($errors->has('physical_location'))
                        <em class="invalid-feedback">
                            {{ $errors->first('physical_location') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.yard.fields.physical_location_helper') }}
                    </p>
                </div>

                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">{{ trans('cruds.yard.fields.phone') }}</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ old('phone', isset($yard) ? $yard->phone : '') }}">
                    @if ($errors->has('phone'))
                        <em class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.yard.fields.phone_helper') }}
                    </p>
                </div>
                
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.yard.fields.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($yard) ? $yard->email : '') }}">
                    @if ($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.yard.fields.email_helper') }}
                    </p>
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
