<?php
$r = file_get_contents('http://one:80');
var_dump($r);

$curlSession = curl_init();
curl_setopt($curlSession, CURLOPT_URL, 'http://one:80');
curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

var_dump(curl_exec($curlSession));
curl_close($curlSession);


