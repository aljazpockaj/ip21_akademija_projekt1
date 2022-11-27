<?php
$function = $argv[1] ?? null;
$type = $argv[2] ?? null;
$name = $argv[3] ?? null;
getAnimal($function, $type, $name);
function apiCall($name = "", $type)
{
    if ($type == "dogs") {
        $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
    } else if ($type == "cats") {
        $api_url = empty($name) ? "https://api.thecatapi.com/v1/breeds" : "https://api.thecatapi.com/v1/breeds/search?q=" . $name;
    }

    $content = file_get_contents($api_url);
    $data = $content == false ? throw new Exception("Error urlja") : json_decode($content);
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Error decodanja");
    }
    return $data;
}
function printAnimal($data)
{
    foreach ($data as $animal) {
        echo $animal->name . "\n";
    }
}
function getAnimal($function, $type, $name)
{
    if (isset($function) and isset($type)) {
        if ($function == "search" and isset($name)) {
            if (isset($name) and is_string($name) and ctype_alpha($name) and strlen($name) <= 20) {
                $data = apiCall($name, $type);
                if (empty($data)) {
                    echo "Ni rezultatov vašega iskanja.";
                } else {
                    printAnimal($data);
                }
            } else {
                echo "Vnesti je potrebno pravilno ime pasme.";
            }
        } else if ($function == "list" and $type == "cats" or $function == "list" and $type == "dogs") {
            $type = ($type == "dogs") ? "dogs" : "cats";
            printAnimal(apiCall($name, $type));
        } else {
            echo "Nisi vnesel pravilnih parametrov.";
        }
    } else {
        echo "Nisi vnesel pravilnih parametrov.";
    }
}