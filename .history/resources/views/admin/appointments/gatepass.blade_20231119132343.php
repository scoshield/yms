<!DOCTYPE html>
<html>
<head>
    <title>GatePass</title>
</head>
<body>
<div style="text-align:right;">
        <b>Sender:</b> Phppot
    </div>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">GATEPASS</div>
    </div>
<table style="line-height: 1.5;">
    <tr><td><b>Invoice:</b> #<?php echo $result[0]["order_invoice"]; ?>
        </td>
        <td style="text-align:right;"><b>Receiver:</b></td>
    </tr>
    <tr>
        <td><b>Date:</b> <?php echo $orderedDate; ?></td>
        <td style="text-align:right;"><?php echo $result[0]["customer_first_name"] . ' ' . $result[0]["customer_last_name"]; ?></td>
    </tr>
    <tr>
        <td><b>Payment Due:</b><?php echo $due_date; ?>
        </td>
        <td style="text-align:right;"><?php echo $result[0]["customer_company"]; ?></td>
    </tr>
<tr>
<td></td>
<td style="text-align:right;"><?php echo $result[0]["customer_address"]; ?></td>
</tr>
</table>

<div></div>
    <div style="border-bottom:1px solid #000;">
        <table style="line-height: 2;">
            <tr style="font-weight: bold;border:1px solid #cccccc;background-color:#f2f2f2;">
                <td style="border:1px solid #cccccc;width:200px;">Item Description</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:85px">Price ($)</td>
                <td style = "text-align:right;border:1px solid #cccccc;width:75px;">Quantity</td>
                <td style = "text-align:right;border:1px solid #cccccc;">Subtotal ($)</td>
            </tr>
<?php
$total = 0;
$productModel = new Order();
foreach ($orderItemResult as $k => $v) {
    $price = $orderItemResult[$k]["item_price"] * $orderItemResult[$k]["quantity"];
    $total += $price;
    $productResult = $productModel->getProduct($orderItemResult[$k]["product_id"]);
    ?>
    <tr> <td style="border:1px solid #cccccc;"><?php echo $productResult[0]["product_title"]; ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($orderItemResult[$k]["item_price"], 2); ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo $orderItemResult[$k]["quantity"]; ?></td>
                    <td style = "text-align:right; border:1px solid #cccccc;"><?php echo number_format($price, 2); ?></td>
               </tr>
<?php
}
?>
<tr style = "font-weight: bold;">
    <td></td><td></td>
    <td style = "text-align:right;">Total ($)</td>
    <td style = "text-align:right;"><?php echo number_format($total, 2); ?></td>
</tr>
</table></div>
<p><u>Kindly make your payment to</u>:<br/>
Bank: American Bank of Commerce<br/>
A/C: 05346346543634563423<br/>
BIC: 23141434<br/>
</p>
<p><i>Note: Please send a remittance advice by email to vincy@phppot.com</i></p>
</body>
</html>