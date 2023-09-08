@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.inventory_item.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.inventory_items.update', [$inventory_item->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">{{ trans('cruds.inventory_item.fields.name') }}</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($inventory_item) ? $inventory_item->name : '') }}">
                    @if ($errors->has('name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.inventory_item.fields.name_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="phone">{{ trans('cruds.inventory_item.fields.phone') }}</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ old('phone', isset($inventory_item) ? $inventory_item->phone : '') }}">
                    @if ($errors->has('phone'))
                        <em class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.inventory_item.fields.phone_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">{{ trans('cruds.inventory_item.fields.email') }}</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($inventory_item) ? $inventory_item->email : '') }}">
                    @if ($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.inventory_item.fields.email_helper') }}
                    </p>
                </div>
                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
