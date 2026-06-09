<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to PayHere...</title>
</head>
<body onload="document.getElementById('payhere_form').submit();">
    <div style="text-align: center; margin-top: 50px;">
        <h2>Redirecting to PayHere...</h2>
        <p>Please wait while we transfer you to the secure payment gateway.</p>
        
        <form action="<?=$action_url?>" method="POST" id="payhere_form">
            <input type="hidden" name="merchant_id" value="<?=$merchant_id?>">
            <input type="hidden" name="return_url" value="<?=$return_url?>">
            <input type="hidden" name="cancel_url" value="<?=$cancel_url?>">
            <input type="hidden" name="notify_url" value="<?=$notify_url?>">
            <input type="hidden" name="order_id" value="<?=$order_id?>">
            <input type="hidden" name="items" value="<?=$items?>">
            <input type="hidden" name="currency" value="<?=$currency?>">
            <input type="hidden" name="amount" value="<?=$amount?>">
            <input type="hidden" name="first_name" value="<?=$first_name?>">
            <input type="hidden" name="last_name" value="<?=$last_name?>">
            <input type="hidden" name="email" value="<?=$email?>">
            <input type="hidden" name="phone" value="0000000000">
            <input type="hidden" name="address" value="Sri Lanka">
            <input type="hidden" name="city" value="Colombo">
            <input type="hidden" name="country" value="Sri Lanka">
            <input type="hidden" name="hash" value="<?=$hash?>">
        </form>
    </div>
</body>
</html>
