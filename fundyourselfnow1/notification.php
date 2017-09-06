<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"http://142.4.10.93/~vooap/ulawn/webservice/delete");
//curl_setopt($ch, CURLOPT_URL,"http://52.74.139.176/fundslive/addAlertNotification");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec($ch);
curl_close ($ch);

?>
