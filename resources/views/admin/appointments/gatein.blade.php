@extends('layouts.admin')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Appointment Details
                </div>

                <div class="card-body pb-0">
                    <div style="row -border-top:1px solid #000;">
                        <table class="col-md-12" style="line-height: 1.5;">
                            <tr>
                                <td>
                                    <div style="text-align: left;font-size: 24px;color: #666;">
                                        <img src="{{ asset('images/AGL_LOGO.jfif') }}" width="200">
                                    </div>
                                </td>
                                <td style="text-align:right;">
                                    <div class="fs-4 fw-bold" style="font-size: 24px;font-weight: bold;color: #666;">
                                        ADMISSION</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <table class="table table-sm table-striped table-bordered" style="line-height: 1.5;">
                        <tr>
                            <td><b>Time:</b> {{ $appointment->appointment_date }}</td>
                            <td style="text-align:right;"><b>Yard:</b>{{ @$appointment->yard->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Driver:</b> {{ $appointment->driver_name }}</td>
                            <td style="text-align:right;">
                                <b>Purpose: </b>
                                {{ @config('appointment.purpose')[$appointment->purpose] }}
                                {{ $appointment->type == ' ' ? ', ' . config('appointment.type')[$appointment->type] : ' ' }}
                            </td>
                        </tr>
                        <tr>
                            <td><b>Driver Contact:</b> {{ $appointment->contact_details }}</td>
                            <td style="text-align:right;" class="text-uppercase"><b>File No:
                                </b>{{ $appointment->file_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Container No:</b> {{ $appointment->contact_details }}</td>
                            <td style="text-align:right;"><b></b></td>
                        </tr>

                        <tr>
                            <td><b>Hauler:</b> {{ @$appointment->hauler->name }}</td>
                            <td style="text-align:right;"></td>
                        </tr>
                    </table>

                    <div></div>
                    <div style="border-bottom:1px solid #000;">
                        <p class="bg-infod bg-opacity-50 border-dark px-2 py-4"
                            style="background: #0000004a;color:#f2f2f2;font-size: 18px; font-weight: bold;">Please allow
                            truck <span style="color: #1e3e66">{{ $appointment->truck_details }}</span>
                            {{ $action }}</p>
                        <table class="table table-sm table-stripedd" style="line-height: 2;">
                            <thead>
                                <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                                    <td style="border:1px solid #cccccc;width:530px;">Cargo Description</td>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td style = "border:1px solid #cccccc;width:530px">{{ $appointment->comments }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                        </table>
                    </div>
                    <br />
                </div>
                <form action="{{ route('admin.appointments.admit') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;"
                    class="mt-0 px-3">
                    {{-- <div class="card-header">
                    </div> --}}
                    <div class="card-body pt-0 px-1">
                        <div class="row">                           
                            <div class="col-md-12 border-bottoms">
                                <span class="fw-bold fs-5">Document Checklist</span> 
                                <hr>
                            </div>
                            <div class="col-md-6">
                              @forelse($docs as $doc)
                               <div class="form-group row">
                                <div class="col-sm-2">
                                    <label for="" class="form-label">{{ $doc->label}}</label>                                    
                                </div>
                                <div class="col-md-10">
                                    <input type="hidden" name="documents[{{ $doc->id }}][id]" value="{{ $doc->id }}">
                                    <input type="text" class="form-control" name="documents[{{ $doc->id }}][value]" placeholder="{{ $doc->label }}">
                                </div>
                               </div>
                              @empty 
                              <div class="alert alert-info">
                                <span class="fs-6">No documents required for this checkin</span>
                              </div>
                              @endforelse
                            </div>
                            <div class="col-md-12 mt-2">
                                @can('appointment_admit')
                                    @if ($appointment->status == 'security_approved')
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id" value="{{ $appointment->id }}">
                                        <input type="submit" class="btn btn-dark" value="{{ trans('global.admit') }}">
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
    </div>
@endsection
