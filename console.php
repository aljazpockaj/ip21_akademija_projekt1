<?php
$function = $argv[1] ?? null;
$name = $argv[2] ?? null;
if (isset($function)) {
    $data = getDogs($function, $name);
    if (empty($data)) {
        echo "Ni rezultatov vašega iskanja.";
    } else {
        foreach ($data as $dog) {
            echo $dog->name . "\n";
        }
    }
} else {
    echo "Nisi vnesel pravilnih parametrov.";
}

function apiCall($name = "")
{
    $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
    $content = file_get_contents($api_url);
    $data = $content == false ? throw new Exception("Error urlja") : json_decode($content);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error decodanja");
    }

    return $data;
}
function getDogs($function, $name)
{
    if ($function == "search" and isset($name)) {
        if (is_string($name) and ctype_alpha($name) and strlen($name) <= 20) {
            return apiCall($name);
        } else {
            echo "Vnesti je potrebno pravilno ime pasme.";
        }
    } else if ($function == "list") {
        return apiCall();
    }
}