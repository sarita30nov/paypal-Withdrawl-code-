<?php

/*
https://incarnate.github.io/curl-to-php/
https://developer.paypal.com/docs/integration/direct/payouts/integration-guide/payouts_api/#show-payout-details


<!--curl -v https://api.sandbox.paypal.com/v1/oauth2/token \
   -H "Accept: application/json" \
   -H "Accept-Language: en_US" \
   -u "client_id:secret" \
   -d "grant_type=client_credentials"

client_id :  ATgp58YwOKNMJsPKGvC2KYxcpkEJtH3yBc0Q9_pw4sXJpJqfG3MbSPlf7K1IzlQITDFE8tIGLqx22LfA
secret : EFKOkJ1-4xOvPRgapdn8MU_hkeaMXUEzBLEsluw01gt-4is6U36iQ7PwmeZG9f5fjTSiSHf3M39x5t0K
-->

*/



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


echo "<pre>";
//echo  $result;
print_r(  json_decode(  $result , true)  );

/*
Response format 

{"scope":"https://uri.paypal.com/services/disputes/read-seller https://uri.paypal.com/services/subscriptions https://api.paypal.com/v1/payments/.* https://uri.paypal.com/services/disputes/read-buyer https://api.paypal.com/v1/vault/credit-card https://uri.paypal.com/services/applications/webhooks openid https://uri.paypal.com/payments/payouts https://uri.paypal.com/services/disputes/update-seller https://api.paypal.com/v1/vault/credit-card/.*","nonce":"2018-05-30T07:16:51ZEm0DunTXnvNWPG5dR2ed-Rmj5k-91_mQCRex6OUaQ_Y","access_token":"A21AAHRs9fDoTY4sLwb5F7Ah6oToKIB1fjWsiL5N11N-Xyor7UE3LTf3B_wlGQid_k0D-gf5RYFqexOfV0bwtkIAz1GQhhcag","token_type":"Bearer","app_id":"APP-80W284485P519543T","expires_in":32047}

*/