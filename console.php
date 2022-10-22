<?php
echo "Hello world";
$api_url = "https://api.thedogapi.com/v1/breeds";
$data = file_get_contents($api_url);
$data = json_decode($data);
foreach ($data as $dog) {
    var_dump($dog->name);
 }

?>