<?php
class ConsoleModel
{

    public function getAnimals($function, $type, $name)
    {
        if ($function == "search" and animalType($type) != "both") {
            return $this->searchAnimal($type, $name);
        }
        if ($function == "list") {
            if (!animalType($type)) {
                return;
            }
            return $this->getData($name, $type);
        }
        return "Nisi vnesel pravilnih parametrov.";
    }
    public function searchAnimal($type, $name)
    {
        if (!nameValid($name)) {
            return;
        } else {
            $data = $this->getData($name, $type);
            if (empty($data)) {
                echo "Ni rezultatov vašega iskanja.";
                return;
            } else {
                return $data;
            }
        }
    }
    public function getData($name, $type)
    {

        if ($type == "dogs") {
            $api_url = empty($name) ? "https://api.thedogapi.com/v1/breeds" : "https://api.thedogapi.com/v1/breeds/search?q=" . $name;
            return $this->apiCall($api_url);
        }
        if ($type == "cats") {
            $api_url = empty($name) ? "https://api.thecatapi.com/v1/breeds" : "https://api.thecatapi.com/v1/breeds/search?q=" . $name;
            return $this->apiCall($api_url);
        }
        if ($type == "both") {
            $dogs = $this->apiCall("https://api.thedogapi.com/v1/breeds");
            $cats = $this->apiCall("https://api.thecatapi.com/v1/breeds");
            $animals = array_merge($dogs, $cats);
            usort($animals, "sortByName");
            return $animals;
        }
    }

    private function apiCall($api_url)
    {
        $content = file_get_contents($api_url);
        $data = $content == false ? throw new Exception("Error urlja") : json_decode($content);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error decodanja");
        }
        return $data;
    }
}