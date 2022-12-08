<?php
$function = $argv[1] ?? null;
$type = $argv[2] ?? null;
$name = $argv[3] ?? null;
getAnimals($function, $type, $name);
function getAnimals($function, $type, $name)
{
    if ($function == null and $type == null) {
        echo "Nisi vnesel pravilnih parametrov.";
        return;
    }
    if ($function == "search") {
        if (!nameValid($name)) {
            echo "Vnesti je potrebno pravilno ime pasme.";
            return;
        }
        $data = getData($name, $type);
        if (empty($data)) {
            echo "Ni rezultatov vašega iskanja.";
            return;
        } else {
            return printAnimal($data);
        }
    }
    if ($function == "list") {
        return printAnimal(getData($name, $type));
    } else {
        echo "Nisi vnesel pravilnih parametrov.";
    }
}
function nameValid($name)
{
    if (isset($name) and is_string($name) and ctype_alpha($name) and strlen($name) <= 20) {
        return true;
    }
    return;
}

function getData($name = "", $type)
{
    if ($type != "dogs" and $type != "cats" and $type != "both") {
        echo "Nisi vnesel pravilnega tipa živali";
        return;
    }
    if ($type == "dogs") {
        $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
        return apiCall($api_url);
    }
    if ($type == "cats") {
        $api_url = empty($name) ? "https://api.thecatapi.com/v1/breeds" : "https://api.thecatapi.com/v1/breeds/search?q=" . $name;
        return apiCall($api_url);
    }
    if ($type == "both") {
        $dogs = apiCall("https://api.thedogapi.com/v1/breeds");
        $cats = apiCall("https://api.thecatapi.com/v1/breeds");
        $animals = array_merge($dogs, $cats);
        usort($animals, "sortByName");
        return $animals;
    }
}
function apiCall($api_url)
{
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

function sortByName($a, $b)
{
    return $a->name > $b->name;
}