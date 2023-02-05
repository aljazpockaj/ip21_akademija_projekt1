<?php
class ConsoleView
{
    public function showAnimals($data)
    {
        foreach ($data as $animal) {
            echo $animal["name"] . "\n";
        }
    }
}