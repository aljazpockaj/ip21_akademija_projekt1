<?php
if(isset($argv[1])){
    $name = $argv[1];
}else{
    return 0;
}
if(is_string($name) and ctype_alpha($name))
{
    if(strlen($name) > 20){
        echo "Ime je predolgo. Maksimalna dolžina je 20 znakov.";
    }
    else{
        if(empty($name))
        {
            $api_url = "https://api.thedogapi.com/v1/breeds";
            $data = file_get_contents($api_url);
            $data = json_decode($data);
            foreach ($data as $dog) {
               echo $dog->name."\n";
             }
        }
        else if($name){
            $api_url = "https://api.thedogapi.com/v1/breeds/search?q=".$name;
            $data = file_get_contents($api_url);
            $data = json_decode($data);
            $datalength = count($data);
            foreach ($data as $dog) {
                echo $dog->name."\n";
              }
        }
    }
}
else{
    echo "Vnesti je potrebno pravilno ime pasme.";
}
?>