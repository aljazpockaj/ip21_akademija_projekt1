<?php
if (isset($argv[1])) {
    $name = $argv[1];
    if (is_string($name) and ctype_alpha($name)) {
        if (strlen($name) > 20) {
            echo "Ime je predolgo. Maksimalna dolžina je 20 znakov.";
        } else {
            $data = apiCall($name);
            foreach ($data as $dog) {
                echo $dog->name . "\n";
                if (empty($dog)) {
                    echo "Ni rezultatov vašega iskanja.";
                }
            }
        }
    } else {
        echo "Vnesti je potrebno pravilno ime pasme.";
    }
} else {
    $data = apiCall($name = "");
    foreach ($data as $dog) {
        echo $dog->name . "\n";
    }
}
function apiCall($name)
{
    empty($name) ? $api_url = "https://api.thedogapi.com/v1/breeds" : $api_url = "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
    $data = file_get_contents($api_url);
    $data = json_decode($data);
    return $data;
}