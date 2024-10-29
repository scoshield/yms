@extends('layouts.admin')
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Appointment Details
                </div>

                <div class="card-body">
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
                                        GATEPASS</div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- <div style="text-align: left;border-top:1px solid #000;">
                        <div style="font-size: 18px;color: #666;">GATEPASS</div>
                    </div> --}}

                    <table class="table table-sm table-striped table-bordered" style="line-height: 1.5;">
                        <tr>
                            <td><b>Time:</b> {{ $appointment->appointment_date }}</td>

                            <td style="text-align:right;"><b>Yard:</b>{{ $appointment->yard->name }}</td>
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
                            <td style="text-align:right;"><b>File No: </b>{{ $appointment->file_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Container No:</b> {{ $appointment->contact_details }}</td>
                            <td style="text-align:right;"><b></b></td>
                        </tr>

                        <tr>
                            <td><b>Hauler:</b> {{ $appointment->hauler->name }}</td>
                            <td style="text-align:right;"></td>
                        </tr>
                    </table>

                    <div></div>
                    <div style="-border-bottom:1px solid #000;">
                        <p class="bg-infod bg-opacity-50 border-dark px-2 py-4"
                            style="background: #0000004a;color:#f2f2f2;font-size: 18px; font-weight: bold;">Please allow
                            truck <span style="color: #1e3e66">{{ $appointment->truck_details }}</span>
                            {{ $action }}</p>
                        {{-- <p><b>Purpose of Visit:</b> {{ config('app.purpose_of_visit')[$appointment->purpose] }}</p> --}}
                        <table class="table table-sm table-stripedd" style="line-height: 2;">
                            <thead>
                                <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                                    <td style="border:1px solid #cccccc;width:530px;">Cargo Description</td>
                                    {{-- <td style = "text-align:right;border:1px solid #cccccc;width:85px">Price ($)</td>
                                    <td style = "text-align:right;border:1px solid #cccccc;width:75px;">Quantity</td>
                                    <td style = "text-align:right;border:1px solid #cccccc;">Subtotal ($)</td> --}}
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td style = "border:1px solid #cccccc;width:530px">{{ $appointment->comments }}</td>
                                    {{-- <td>H.O.D Approval:</td>
                                    <td>Security Approval:</td>
                                    <td></td> --}}
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                        </table>
                        {{-- <img src="data:image/svg;base64,  {{ $qrCode }}" width="100" style="margin-top:10px; right:0"> --}}

                    </div>

                    <table class="w-100 table-sm table-striped table-bordered p-0">
                        @if ($appointment->admitted_at)
                            <tr>
                                <td ><span class="fw-bold" style="font-weight: bold">Gate In:</span></td>
                                <td>{{ $appointment->admission->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->admitted_at) }}</td>
                                <td>
                                    @if ($appointment->gatein_image_url)
                                    <img src="{{ asset( '/entries/'.$appointment->gatein_image_url ) }}" alt="{{ $appointment->truck_details }}" class="img-thumbnail" style="width: 32px;">
                                    <a href="{{ route('admin.appointments.download', $appointment->gatein_image_url) }}"><i class="fas fa-download ms-2"></i></a>
                                @endif
                                </td>
                            </tr>
                        @endif
                        @php $time = 0; $time2= 0; @endphp
                        @if ($appointment->offloading)
                           
                            <tr>
                                <td><span class="fw-bold" style="font-weight: bold">OFFLOADING</span></td>
                                <td>Start</td>
                                <td>{{ $appointment->offloading->starter->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->offloading->started_at) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span class="fw-bold">End:</span></td>
                                <td>{{ $appointment->offloading->finisher->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->offloading->finished_at) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><span style="font-weight: bold; float: right;">T.A.T</span></td>@php $time =+ (int)dateDifference($appointment->offloading->finished_at, $appointment->offloading->started_at); @endphp
                                <td><span style="font-weight: bold; font-size: 14px;">{{ $time }}</span>
                                </td>
                            </tr>
                        @endif

                        @if ($appointment->loading)
                            <tr>
                                <td><span class="fw-bold" style="font-weight: bold">LOADING</span></td>
                                <td>Start</td>
                                <td>{{ $appointment->loading->starter->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->loading->started_at) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><span class="fw-bold">End:</span></td>
                                <td>{{ $appointment->loading->finisher->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->loading->finished_at) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3"><span style="font-weight: bold; float: right;">T.A.T</span></td>@php $time2 =+ (int)dateDifference($appointment->loading->finished_at, $appointment->loading->started_at); @endphp
                                <td><span style="font-weight: bold; font-size: 14px;">{{ $time2 }}</span>
                                </td>
                            </tr>
                        @endif

                        @if ($appointment->admitted_at)
                            <tr>
                                <td colspan="2"><span class="fw-bold" style="font-weight: bold">Gate Out:</span></td>
                                <td>{{ $appointment->admission->name ?? '' }}</td>
                                <td>{{ formatDate($appointment->admitted_at) }}</td>
                            </tr>
                        @endif
                    </table>
                    <table class="table table-sm table-bordered mt-4">
                        <thead>
                            <tr>
                                <th>GLOBAL T.A.T</th>
                                <th><span style="font-weight: bold; font-size: 14px;">{{$time + $time2}}</span>
                                </th>
                            </tr>
                        </thead>
                    </table>

                    <table class="w-75 table-sm table-striped table-bordered mt-4">
                        <tr>
                            <td><span style="font-weight: bold">Appointment By:</span></td>
                            <td>{{ $appointment->creator->name ?? '' }}</td>
                            <td><span class="fw-bold" style="font-weight: bold">Time: </span>
                                {{ formatDate($appointment->hod_approved_at) }}</td>
                        </tr>
                        @if ($appointment->hod_approved_by)
                            <tr>
                                <td><span class="fw-bold" style="font-weight: bold">H.O.D Approval:</span></td>
                                <td>{{ $appointment->hod_approver->name }}</td>
                                <td><span class="fw-bold" style="font-weight: bold">Time: </span>
                                    {{ formatDate($appointment->hod_approved_at) }}</td>
                            </tr>
                        @endif

                        @if ($appointment->security_approved_by)
                            <tr>
                                <td><span style="font-weight: bold">Security Approval:</span></td>
                                <td>{{ $appointment->security_approver->name }}</td>
                                <td><span class="fw-bold" style="font-weight: bold">Time:
                                    </span>{{ formatDate($appointment->security_approved_at) }}</td>
                            </tr>
                        @endif
                    </table>


                    <br />
                </div>

                <div class="card-body">
                    <div class="mb-2">
                        <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
