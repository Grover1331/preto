<?php 

$handle = curl_init("https://google.com");

curl_setopt($handle, CURLOPT_FOLLOWLOCATION, TRUE);

curl_setopt($handle, CURLOPT_MAXREDIRS, 3);

curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

curl_setopt($handle, CURLOPT_POST, true);

curl_setopt($handle, CURLOPT_POSTFIELDS, $data11);

echo $data = curl_exec($handle);

 ?>