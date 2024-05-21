<!DOCTYPE html>
<html>

<head>
    <title>GatePass</title>
</head>

<body>
    <div style="text-align:right;">
        {{ $gatePass->ref }}
    </div>

    <div style="border-top:1px solid #000;">
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
            <td><b>Time</b> {{ $appointment->appointment_date }}</td>

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

    {{-- <br /><br /> --}}
    <table>
        @if ($appointment->hod_approved_by)
            <tr>
                <td>H.O.D Approval:</td>
                <td>{{ $appointment->hod_approver->name }}</td>
                <td>{{ $appointment->hod_approved_at }}</td>
            </tr>
        @endif

        @if ($appointment->security_approved_by)
            <tr>
                <td>Security Approval:</td>
                <td>{{ $appointment->security_approver->name }}</td>
                <td>{{ $appointment->security_approved_at }}</td>
            </tr>
        @endif
    </table>

    <br />
    <p>
        &nbsp;&nbsp;&nbsp;<br />
        Issued By: {{ Auth::user()->name }} _____________________<br />
        Received By: ________________________<br />
        {{-- BIC: 23141434<br /> --}}
    </p>

</body>

</html>
