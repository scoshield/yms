@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.hauler.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.haulers.update', [$hauler->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.hauler.fields.name') }}</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($hauler) ? $hauler->name : '') }}">
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.hauler.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">{{ trans('cruds.hauler.fields.phone') }}</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ old('phone', isset($hauler) ? $hauler->phone : '') }}">
                    @if ($errors->has('phone'))
                        <em class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.hauler.fields.phone_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.hauler.fields.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($hauler) ? $hauler->email : '') }}">
                    @if ($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.hauler.fields.email_helper') }}
                    </p>
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
