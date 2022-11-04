<?php
function parameterApiCall($name){
    $api_url = "https://api.thedogapi.com/v1/breeds/search?q=".$name;
    $data = file_get_contents($api_url);
    $data = json_decode($data);
    return $data;
}
function emptyApiCall(){
    $api_url = "https://api.thedogapi.com/v1/breeds";
    $data = file_get_contents($api_url);
    $data = json_decode($data);
    return $data;
}

if(isset($argv[1])){
    $name = $argv[1];
    if(is_string($name) and ctype_alpha($name))
{
    if(strlen($name) > 20){
        echo "Ime je predolgo. Maksimalna dolžina je 20 znakov.";
    }
    else{
            if($name){
            $data = parameterApiCall($name);
            foreach ($data as $dog) {
                echo $dog->name."\n";
              }
            if(empty($dog)){
                echo "Ni rezultatov vašega iskanja.";
            }
        }
    }
}
else{
    echo "Vnesti je potrebno pravilno ime pasme.";
}
}
else{
    if(empty($name))
    {
        $data = emptyApiCall();
        foreach ($data as $dog) {
           echo $dog->name."\n";
         }
    }
}

?>