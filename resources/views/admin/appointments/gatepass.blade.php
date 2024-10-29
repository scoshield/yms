<!DOCTYPE html>
<html>

<head>
    <title>GatePass</title>
    <style>
        .table td{
            border: 1px solid #e3e3e3;
        }

        /* .table {
            margin-top: 10px;
            margin-bottom: 10px;
        } */
    </style>
</head>

<body>
    {{-- 
        <div style="text-align:right;">
            {{ $gatePass->ref }}
        </div> 
    --}}

    <div style="-border-top:1px solid #000;">
        <table style="line-height: 1.5;">
            <tr>
                <td>
                    <div style="text-align: left;font-size: 24px;color: #666;">
                        <img src="{{ public_path('/images/AGL_LOGO.jfif') }}" width="200">
                    </div>
                </td>
                <td style="text-align:right;">
                    <div style="font-size: 18px;color: #666;">GATEPASS</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 18px;color: #666;">GATEPASS</div>
    </div> --}}

    <table style="line-height: 1.5;">
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
        <p>Please allow truck {{ $appointment->truck_details }} {{ $action }}</p>
        {{-- <p><b>Purpose of Visit:</b> {{ config('app.purpose_of_visit')[$appointment->purpose] }}</p> --}}
        <table style="line-height: 2;">
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

    <table class="table" style="line-height: 2;border:1px solid #e3e3e3">
        @if ($appointment->admitted_at)
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td colspan="2"><span class="fw-bold" style="font-weight: bold">Gate In:</span></td>
                <td>{{ $appointment->admission->name ?? '' }}</td>
                <td>{{ formatDate($appointment->admitted_at) }}</td>
            </tr>
        @endif
        @php $time = 0; $time2= 0; @endphp
        @if ($appointment->offloading)
            {{-- <tr>
                    <td colspan="3">OFFLOADING</td>
                </tr> --}}
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
                <td colspan="3"><span style="font-weight: bold; float: right;">T.A.T</span></td> @php $time = $time + (int)dateDifference($appointment->offloading->finished_at, $appointment->offloading->started_at); @endphp
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
    
   <div>&nbsp;</div>
    <table class="table" style="line-height: 2;border:1px solid #e3e3e3; margin-top: 10px;">
        <thead>
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <th colspan="3">GLOBAL T.A.T</th>
                <th><span style="font-weight: bold; font-size: 14px;">{{$time + $time2}}</span>
                </th>
            </tr>
        </thead>
    </table>
    <div>&nbsp;</div>
    {{-- <br /><br /> --}}
    <table class="table" style="line-height: 2;border:1px solid #e3e3e3;">
        {{-- @if ($appointment->hod_approved_by) --}}
            <tr>
                <td>Appointment By:</td>
                <td colspan="2">{{ $appointment->creator->name ?? '' }}</td>
                <td>{{ formatDate($appointment->hod_approved_at) }}</td>
            </tr>
        {{-- @endif --}}

        @if ($appointment->hod_approved_by)
            <tr>
                <td>H.O.D Approval:</td>
                <td colspan="2">{{ $appointment->hod_approver->name }}</td>
                <td>{{ formatDate($appointment->hod_approved_at) }}</td>
            </tr>
        @endif

        @if ($appointment->security_approved_by)
            <tr>
                <td>Security Approval:</td>
                <td colspan="2">{{ $appointment->security_approver->name }}</td>
                <td>{{ formatDate($appointment->security_approved_at) }}</td>
            </tr>
        @endif
    </table>

    <br />

    {{-- <table>
        <tr>
            <td>
                <p>
                    <br /><br />
                    Issued By: {{ Auth::user()->name }} _____________________<br />
                    Received By: ________________________<br />
                </p>
            </td>

        </tr>
    </table> --}}

</body>

</html>
