<!DOCTYPE html>
<html>
<head>
    <title>GatePass</title>
</head>
<body>
    <div style="text-align:right;">
       {{$gatePass->ref}}
    </div>
    
    <h1>Company Name</h1>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">GATEPASS</div>
    </div>
    
    <table style="line-height: 1.5;">
        <tr>
            <td><b>Time</b> {{$appointment->appointment_date}}</td>
            
            <td style="text-align:right;"><b>Yard:</b>{{$appointment->yard->name}}</td>
        </tr>
        <tr>
            <td><b>Driver:</b> {{$appointment->driver_name}}</td>
            <td style="text-align:right;"><b>Purpose: </b>{{$appointment->purpose}}</td>
        </tr>
        <tr>
            <td><b>Driver Contact:</b> {{$appointment->contact_details}}</td>
            <td style="text-align:right;"><b>File No: </b>{{$appointment->file_number}}</td>
        </tr>
        <tr>
            <td><b>Truck:</b> {{$appointment->truck_details}}</td>
            <td style="text-align:right;"><b></b></td>
        </tr>
        <tr>
            <td><b>Container No:</b> {{$appointment->contact_details}}</td>
            <td style="text-align:right;"><b></b></td>
        </tr>
       
        <tr>
            <td><b>Hauler:</b> {{$appointment->hauler->name}}</td>
            <td style="text-align:right;"></td>
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
                    <td style = "border:1px solid #cccccc;width:530px">{{$appointment->comments}}</td>
                    {{-- <td></td>
                    <td></td>
                    <td></td> --}}
                </tr>
                <tr>
                    <td></td>
                </tr>
        </table>
        <center><img src="data:image/svg;base64,  {{$qrCode}}" width="100" style="margin-top:10px; left:50%"></center>
        
    </div>

    {{-- <p>
        <u> Kindly make your payment to</u>:<br/>
            Bank: American Bank of Commerce<br/>
            A/C: 05346346543634563423<br/>
            BIC: 23141434<br/>
    </p> --}}

    <p><i>Served by: {{Auth::user()->name}}</i></p>
</body>
</html>