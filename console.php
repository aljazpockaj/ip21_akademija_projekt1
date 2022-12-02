<?php
$function = $argv[1] ?? null;
$type = $argv[2] ?? null;
$name = $argv[3] ?? null;

checkParameters($function, $type, $name);

function getAnimal($name = "", $type)
{
    if ($type == "dogs") {
        $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
        return apiCall($api_url);
    } else if ($type == "cats") {
        $api_url = empty($name) ? "https://api.thecatapi.com/v1/breeds" : "https://api.thecatapi.com/v1/breeds/search?q=" . $name;
        return apiCall($api_url);
    } else if ($type == "both") {
        $dogs = apiCall("https://api.thedogapi.com/v1/breeds");
        $cats = apiCall("https://api.thecatapi.com/v1/breeds");
        $animals = array_merge($dogs, $cats);
        usort($animals, "sortByName");
        printAnimal($animals);
    }
}
function sortByName($a, $b)
{
    return $a->name > $b->name;
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
function checkParameters($function, $type, $name)
{
    if (isset($function) and isset($type)) {
        checkFunction($function, $type, $name);
    } else {
        echo "Nisi vnesel pravilnih parametrov.";
    }
}
function checkName($name, $type)
{
    if (isset($name) and is_string($name) and ctype_alpha($name) and strlen($name) <= 20) {
        $data = getAnimal($name, $type);
        if (empty($data)) {
            echo "Ni rezultatov vašega iskanja.";
        } else {
            printAnimal($data);
        }
    } else {
        echo "Vnesti je potrebno pravilno ime pasme.";
    }
}
function checkFunction($function, $type, $name)
{
    if ($function == "search" and isset($name)) {
        checkName($name, $type);
    } else if ($function == "list" and $type == "cats" or $function == "list" and $type == "dogs") {
        $type = ($type == "dogs") ? "dogs" : "cats";
        printAnimal(getAnimal($name, $type));
    } else if ($function == "list" and $type == "both") {
        getAnimal($name, $type);
    } else {
        echo "Nisi vnesel pravilnih parametrov.";
    }
}