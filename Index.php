<?php

$function = "list";
$type = "both";
$name = $argv[3] ?? null;
require_once("lib/model.php");
require_once("lib/views/consoleView.php");
require_once 'vendor/autoload.php';

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'debug' => true
]);
$twig->addExtension(new \Twig\Extension\DebugExtension());
$view = new ConsoleView();
$model = new ConsoleModel();
try {
    $template = $twig->load('list.html.twig');
    $animals = $model->getAnimals($function, $type, $name);
    echo $template->render(['list.html.twig', 'animals' => $animals]);
} catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage();
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
function nameValid($name)
{
    if ($name == "-v") {
        return;
    }
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

function sortByName($a, $b)
{
    return $a["name"] > $b["name"];
}
