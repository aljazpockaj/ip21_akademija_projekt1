<?php
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
        $data = printAnimal(getData($name, $type));
        return $data;
    }
    return "Nisi vnesel pravilnih parametrov.";
}
function searchAnimal($type, $name)
{
    if (!nameValid($name)) {
        return;
    } else {
        $data = getData($name, $type);
        if (empty($data)) {
            echo "Ni rezultatov vašega iskanja.";
            return;
        } else {
            return printAnimal($data);
        }
    }
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