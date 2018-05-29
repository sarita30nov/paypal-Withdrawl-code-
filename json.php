<?php

$json ='{"sender_batch_header":{"sender_batch_id":"38799631","email_subject":"You have a payout!","recipient_type":"EMAIL"},"items":[{"recipient_type":"EMAIL","amount":{"value":"1.0","currency":"USD"},"note":"Thanks for your patronage!","sender_item_id":"51842036","receiver":"sanjay@rudrainnovatives.com" }]}';

$decode= json_decode($json , true); 
echo "<pre>";
print_r($decode); 
echo "</pre>";