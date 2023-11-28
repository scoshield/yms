<!DOCTYPE html>
<html>
<head>
    <title>GatePass</title>
</head>
<body>
<div style="text-align:right;">
        <b>ref:</b> {{$gatePass->ref}}
    </div>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">GATEPASS</div>
    </div>
    
    <table style="line-height: 1.5;">
        <tr>
            <td><b>Time</b> {{$appointment->appointment_date}}</td>
            <td style="text-align:right;"><b>Receiver:</b></td>
        </tr>
        <tr>
            <td><b>Driver:</b> {{$appointment->driver_name}}</td>
            <td style="text-align:right;"><b>Receiver:</b></td>
        </tr>
        <tr>
            <td><b>Truck:</b> {{$appointment->truck_details}}</td>
            <td style="text-align:right;"><b>Receiver:</b></td>
        </tr>
        <tr>
            <td><b>Date:</b> 2023-11-18</td>
            <td style="text-align:right;">Driver Names</td>
        </tr>
        <tr>
            <td><b>Hauler:</b> {{$appointment->hauler->name}}</td>
            <td style="text-align:right;"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:right;">Yard Address</td>
        </tr>
    </table>

    <div></div>
    <div style="border-bottom:1px solid #000;">
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
                    <td style = "border:1px solid #cccccc;width:530px">Some stuff</td>
                    {{-- <td></td>
                    <td></td>
                    <td></td> --}}
                </tr>
                <tr>
                    <td></td>
                </tr>
        </table>
        <img src="data:image/svg;base64,  {{$qrCode}}" width="120" style="margin-top:10px">
    </div>

    <p>
        <u> Kindly make your payment to</u>:<br/>
            Bank: American Bank of Commerce<br/>
            A/C: 05346346543634563423<br/>
            BIC: 23141434<br/>
    </p>

    <p><i>Note: Please send a remittance advice by email to vincy@phppot.com</i></p>
</body>
</html>