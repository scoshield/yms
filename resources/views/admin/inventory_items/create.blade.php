@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.inventory_item.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route('admin.inventory_items.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('category') ? 'has-error' : '' }}">
                        <label for="category">{{ trans('cruds.inventory_item.fields.category') }} *</label>
                        <select name="category" id="category" class="form-control select2" required>
                            @foreach (config('inventory.categories') as $id => $category)
                                <option value="{{ $id }}"
                                    {{ (isset($inventory_item) && $inventory_item->category ? $inventory_item->category : old('category')) == $id ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('category_id') }}
                            </em>
                        @endif
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('ref') ? 'has-error' : '' }}">
                        <label for="ref">{{ trans('cruds.inventory_item.fields.ref') }}</label>
                        <input type="text" id="ref" name="ref" class="form-control"
                            value="{{ old('ref', isset($inventory_item) ? $inventory_item->ref : '') }}">
                        @if ($errors->has('ref'))
                            <em class="invalid-feedback"> {{ $errors->first('ref') }} </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.ref_helper') }}
                        </p>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('yard_id') ? 'has-error' : '' }}">
                        <label for="yard">{{ trans('cruds.appointment.fields.yard') }}*</label>
                        <select name="yard_id" id="yard" class="form-control select2" required>
                            @foreach ($yards as $id => $yard)
                                <option value="{{ $id }}"
                                    {{ (isset($appointment) && $appointment->yard ? $appointment->yard->id : old('yard_id')) == $id ? 'selected' : '' }}>
                                    {{ $yard }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('yard_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('yard_id') }}
                            </em>
                        @endif
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('department_id') ? 'has-error' : '' }}">
                        <label for="department">{{ trans('cruds.inventory_item.fields.department') }}</label>
                        <select name="department_id" id="department" class="form-control select2" required>
                            @foreach ($departments as $id => $department)
                                <option value="{{ $id }}"
                                    {{ (isset($appointment) && $appointment->department ? $appointment->department->id : old('department_id')) == $id ? 'selected' : '' }}>
                                    {{ $department }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('department_id'))
                            <em class="invalid-feedback">
                                {{ $errors->first('department_id') }}
                            </em>
                        @endif
                    </div>
                </div>


                <div class="row" style="background-color: lightgray">
                    <div class="form-group col-md-3 {{ $errors->has('um_number') ? 'has-error' : '' }}">
                        <label for="um_number">{{ trans('cruds.inventory_item.fields.um_number') }}</label>
                        <input type="text" id="um_number" name="um_number" class="form-control"
                            value="{{ old('um_number', isset($inventory_item) ? $inventory_item->um_number : '') }}">
                        @if ($errors->has('um_number'))
                            <em class="invalid-feedback">
                                {{ $errors->first('um_number') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.um_number_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-3 {{ $errors->has('size') ? 'has-error' : '' }}">
                        <label for="size">{{ trans('cruds.inventory_item.fields.size') }}</label>
                        <input type="text" id="size" name="size" class="form-control"
                            value="{{ old('size', isset($inventory_item) ? $inventory_item->size : '') }}">
                        @if ($errors->has('size'))
                            <em class="invalid-feedback">
                                {{ $errors->first('size') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.size_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-3 {{ $errors->has('year_manufactured') ? 'has-error' : '' }}">
                        <label for="year_manufactured">{{ trans('cruds.inventory_item.fields.year_manufactured') }}</label>
                        <input type="text" id="year_manufactured" name="year_manufactured" class="form-control"
                            value="{{ old('year_manufactured', isset($inventory_item) ? $inventory_item->year_manufactured : '') }}">
                        @if ($errors->has('year_manufactured'))
                            <em class="invalid-feedback">
                                {{ $errors->first('year_manufactured') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.year_manufactured_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-3 {{ $errors->has('rtn_port') ? 'has-error' : '' }}">
                        <label for="rtn_port">{{ trans('cruds.inventory_item.fields.rtn_port') }}</label>
                        <input type="text" id="rtn_port" name="rtn_port" class="form-control"
                            value="{{ old('rtn_port', isset($inventory_item) ? $inventory_item->rtn_port : '') }}">
                        @if ($errors->has('rtn_port'))
                            <em class="invalid-feedback">
                                {{ $errors->first('rtn_port') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.rtn_port_helper') }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 {{ $errors->has('status') ? 'has-error' : '' }}">
                        <label for="status">{{ trans('cruds.inventory_item.fields.status') }}</label>
                        <input type="text" id="status" name="status" class="form-control"
                            value="{{ old('status', isset($inventory_item) ? $inventory_item->status : '') }}">
                        @if ($errors->has('status'))
                            <em class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.status_helper') }}
                        </p>
                    </div>

                    <div class="form-group col-md-6 {{ $errors->has('structural_status') ? 'has-error' : '' }}">
                        <label for="structural_status">{{ trans('cruds.inventory_item.fields.structural_status') }}</label>
                        <input type="text" id="structural_status" name="structural_status" class="form-control"
                            value="{{ old('structural_status', isset($inventory_item) ? $inventory_item->structural_status : '') }}">
                        @if ($errors->has('structural_status'))
                            <em class="invalid-feedback">
                                {{ $errors->first('structural_status') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.inventory_item.fields.structural_status_helper') }}
                        </p>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('inspected') ? 'has-error' : '' }}">
                    <label for="inspected">{{ trans('cruds.inventory_item.fields.general_condition') }}</label>
                    <div class="row">
                        <div class="form-group form-check col-md-3 ml-3">
                            <input class="form-check-input" type="checkbox" id="inspected" name="inspected"
                                value="1" {{ old('inspected', isset($inventory_item) ? 'checked' : '') }}>
                            <label class="form-check-label" for="inspected">
                                Inspected
                            </label>

                            @if ($errors->has('inspected'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('inspected') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.inventory_item.fields.inspection_status_helper') }}
                            </p>
                        </div>

                        <div class="form-group form-check col-md-3 ml-3">
                            <input class="form-check-input" type="checkbox" id="refurbished" name="refurbished"
                                value="1" {{ old('refurbished', isset($inventory_item) ? 'checked' : '') }}>
                            <label class="form-check-label" for="refurbished">
                                Refurfished
                            </label>

                            @if ($errors->has('refurbished'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('refurbished') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.inventory_item.fields.refurbished_helper') }}
                            </p>
                        </div>

                        <div class="form-group form-check col-md-3 ml-3">
                            <input class="form-check-input" type="checkbox" id="cnumbers_visible"
                                name="cnumbers_visible" value="1"
                                {{ old('cnumbers_visible', isset($inventory_item) ? 'checked' : '') }}>
                            <label class="form-check-label" for="cnumbers_visible">
                                CN Numbers Visible
                            </label>

                            @if ($errors->has('cnumbers_visible'))
                                <em class="invalid-feedback">
                                    {{ $errors->first('cnumbers_visible') }}
                                </em>
                            @endif
                            <p class="helper-block">
                                {{ trans('cruds.inventory_item.fields.cnumbers_visible_helper') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                    <label for="type">{{ trans('cruds.inventory_item.fields.type') }}</label>
                    <input type="text" id="type" name="type" class="form-control"
                        value="{{ old('type', isset($inventory_item) ? $inventory_item->type : '') }}">
                    @if ($errors->has('type'))
                        <em class="invalid-feedback">
                            {{ $errors->first('type') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.inventory_item.fields.type_helper') }}
                    </p>
                </div>

                <div class="form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
                    <label for="remarks">{{ trans('cruds.inventory_item.fields.remarks') }}</label>
                    <textarea rows="2" id="remarks" name="remarks" class="form-control ">{{ old('remarks', isset($inventory_item) ? $inventory_item->remarks : '') }}</textarea>
                    @if ($errors->has('remarks'))
                        <em class="invalid-feedback">
                            {{ $errors->first('remarks') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.inventory_item.fields.remarks_helper') }}
                    </p>
                </div>


                <div>
                    <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                </div>
            </form>


        </div>
    </div>
@endsection
