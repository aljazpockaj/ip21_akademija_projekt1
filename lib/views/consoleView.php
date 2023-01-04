<?php
function printAnimal($data)
{
    foreach ($data as $animal) {
        echo $animal->name . "\n";
    }
}