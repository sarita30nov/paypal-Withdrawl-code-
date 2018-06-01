<?php

// generate token code 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_USERPWD, "ATgp58YwOKNMJsPKGvC2KYxcpkEJtH3yBc0Q9_pw4sXJpJqfG3MbSPlf7K1IzlQITDFE8tIGLqx22LfA" . ":" . "EFKOkJ1-4xOvPRgapdn8MU_hkeaMXUEzBLEsluw01gt-4is6U36iQ7PwmeZG9f5fjTSiSHf3M39x5t0K");

$headers = array();
$headers[] = "Accept: application/json";
$headers[] = "Accept-Language: en_US";
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);


$response = json_decode(  $result , true  ); 
// generate token code 

echo "<pre>"; print_r( $response );

$receiver_email_amount = array('manjeetkumar15@gmail.com'=>1.00 , 'manjeetkr@rediffmail.com'=>3.00) ; // receiver paypal email and amount to pay 
//$access_token = 'A21AAFwqiUNo9zt3jYUoIQsPvxU9mrE-Oa6dwtg7WIWbEKhseTgLpFB62QCtyjwu_6KMNjHYr0h1Iq8-l78OOfFIAWD4f6coQ'; 

$access_token = $response['access_token']; 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts?sync_mode=false");   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$payout = array();
$payout['sender_batch_header']['sender_batch_id']  = time();
$payout['sender_batch_header']['email_subject']  = "Salary Credited.";
$payout['sender_batch_header']['recipient_type']  = "EMAIL";

$start= 0;
foreach($receiver_email_amount as $receiver=>$amount)
{
	$payout['items'][$start]['recipient_type'] = "EMAIL";
	$payout['items'][$start]['note'] = "Thank you for salary";
	$payout['items'][$start]['sender_item_id'] = time().$start;
	$payout['items'][$start]['receiver'] = $receiver;
	$payout['items'][$start]['amount']['value'] = number_format($amount,2);
	$payout['items'][$start]['amount']['currency'] ="USD";
	$start++;
}
//echo "<pre>"; print_r($payout);  die;
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payout)); 
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = "Content-Type: application/json";
$headers[] = "Authorization: Bearer ".$access_token."";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);

if (curl_errno($ch)) 
{
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);



print_r( json_decode(  $result  , true ));

/*  Response 


{"batch_header":{"payout_batch_id":"SASSCXJ5WPJJS","batch_status":"PENDING","sender_batch_header":{"sender_batch_id":"1527660053","recipient_type":"EMAIL","email_subject":"Salary Credited."}},"links":[{"href":"https://api.sandbox.paypal.com/v1/payments/payouts/SASSCXJ5WPJJS","rel":"self","method":"GET","encType":"application/json"}]}
*/
