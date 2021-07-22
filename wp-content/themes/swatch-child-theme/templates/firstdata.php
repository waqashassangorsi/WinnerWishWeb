<?php
/* Template Name: firstData Template */
get_header();

$dateTime = date("Y:m:d-H:i:s");
 function getDateTime() {
 global $dateTime;
 return $dateTime;
 }
 function createHash($chargetotal, $currency) {
 $storeId = "1909657401";
$sharedSecret = "sharedsecret";
 $stringToHash = $storeId . getDateTime() . $chargetotal .
$currency . $sharedSecret;
 $ascii = bin2hex($stringToHash);
 return sha1($ascii);
 }
?>



<p><h1>Order Form</h1>
<form method="post" action="https://test.ipg-online.com/connect/gateway/processing">
 <input type="hidden" name="txntype" value="sale">
<input type="hidden" name="timezone" value="CET"/>
 <input type="hidden" name="txndatetime" value="<?php echo
getDateTime() ?>"/>
 <input type="hidden" name="hash" value="<?php echo createHash(
13.00,978 ) ?>"/>
 <input type="hidden" name="storename" value="1909657401"/>
<input type="hidden" name="mode" value="fullpay"/>
<input type="text" name="chargetotal" value="13.00"/>
<input type="hidden" name="currency" value="978"/>
 <input type="submit" value="Submit">
 </form> 

<?php

get_footer();

?>