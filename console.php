<?php
$function = $argv[1] ?? null;
$type = $argv[2] ?? null;
$name = $argv[3] ?? null;
getAnimals($function, $type, $name);
function getAnimals($function, $type, $name)
{
    if ($function == "search" and animalType($type) != "both") {
        searchAnimal($type, $name);
        return;
    }
    if ($function == "list") {
        if (!animalType($type)) {
            return;
        }
        return printAnimal(getData($name, $type));
    }
    echo "Nisi vnesel pravilnih parametrov.";
    return;
}
function animalType($type)
{
    if ($type == "dogs" or $type == "cats" or $type == "both") {
        return $type;
    } else {
        echo "Nisi vnesel pravilnega tipa živali";
        return;
    }
}
function searchAnimal($type, $name)
{
    if (!nameValid($name)) {
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

function nameValid($name)
{
    if ($name == null) {
        echo "Nisi vnesel imena.";
        return;
    }
    if (!is_string($name) or !ctype_alpha($name)) {
        echo "Ime ne vsebuje pravilnih znakov.";
        return;
    }
    if (strlen($name) >= 20) {
        echo "Ime je predolgo. Maksimalna dolžina je 20 znakov.";
        return;
    }
    return true;
}

function getData($name, $type)
{

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