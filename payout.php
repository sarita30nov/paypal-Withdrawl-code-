<?php


$receiver_email_amount = array('manjeetkumar15@gmail.com'=>100.00 , 'manjeetkr@rediffmail.com'=>300.00) ; // receiver paypal email and amount to pay 
$access_token = 'access_token$production$y9rgq929skm2zgj9$7eb4e15a55d36b860f50edeca0fbf310'; 

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_URL, "https://api.sandbox.paypal.com/v1/payments/payouts?sync_mode=true");   
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
echo "<pre>"; print_r($payout);  die;
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


echo "<pre>";print_r($result);
