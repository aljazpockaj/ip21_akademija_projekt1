<?php
if (isset($argv[1])) {
    $name = $argv[1];
    if (is_string($name) and ctype_alpha($name)) {
        //omejimo dolžino parametra na 20 znakov
        if (strlen($name) > 20) {
            echo "Ime je predolgo. Maksimalna dolžina je 20 znakov.";
        } else {
            //izpis iskanega imena
            $data = apiCall($name);
            //preveri, če so rezultati iskanja prazni
            if (empty($data)) {
                echo "Ni rezultatov vašega iskanja.";
            } else {
                foreach ($data as $dog) {
                    echo $dog->name . "\n";
                }
            }
        }
    } else {
        echo "Vnesti je potrebno pravilno ime pasme.";
    }
} else {
    //izpis celotnega seznama
    $data = apiCall();
    foreach ($data as $dog) {
        echo $dog->name . "\n";
    }
}
function apiCall($name = "")
{
    $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogap.com/v1/breeds/search?q=" . $name;
    $content = file_get_contents($api_url);
    $data = $content == false ? throw new Exception("Error urlja") : json_decode($content);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error decodanja");
    }
    return $data;
}