<?php
var_dump($argc);
var_dump($argv);
$api_url = "https://api.thedogapi.com/v1/breeds";
$data = file_get_contents($api_url);
$data = json_decode($data);
$name = $argv[1];
if(empty($name))
{
    foreach ($data as $dog) {
        print_r($dog->name."\n");
     }
}
else if($name){
    $datalength = count($data);
    for($i = 0; $i<$datalength;$i++){
        if(str_contains($data[$i]->name,$name)){
            print_r($data[$i]->name."\n");
        }
    }
}



?>