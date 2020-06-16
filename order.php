<?php

use src\Entity\BaseProduct;
use src\Manufacture\Bakery\Bakery;
use src\Entity\Request\CliRequest;

function myAutoLoad($className)
{
    $classPieces = explode("\\", $className);
    switch ($classPieces[0]) {
        case 'src':
            $classPath = __DIR__ .'/'. implode(DIRECTORY_SEPARATOR, $classPieces) . '.php';
            if (file_exists($classPath)) {
                include $classPath;
                break;
            }
    }
}
spl_autoload_register('myAutoLoad', '', true);

$inputProductName = $argv[1] ?? null;
$productsList = BaseProduct::getProductsList();

if (empty($inputProductName) || ! in_array(mb_strtolower($inputProductName), $productsList)) {
    echo 'Please, provide a correct product name.' . PHP_EOL;
    echo 'Our menu: ' . implode(', ', $productsList) . PHP_EOL;
    exit();
}

// check if any additional requirements was queried
$additions = [];
if (count($argv) > 2) {
    $additions = array_slice($argv, 2);
}

$inputProductName = ucfirst(mb_strtolower($inputProductName));

$request = new CliRequest($inputProductName, $additions);
$bakery = new Bakery();

$product = $bakery->produce($request);

if ($product->isCompleted()) {
    echo 'Pancake completed' . PHP_EOL;
} else {
    echo "{$product->getName()} was not completed because of {$product->getfailReason()}" . PHP_EOL;
}

