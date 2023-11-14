<?php

namespace itrvb\onlineshop;

include_once "models/DigitalProduct.php";
include_once "models/ItemizedProduct.php";
include_once "models/WeightProduct.php";
include_once "models/AbstractProduct.php";

$digital_product = new DigitalProduct(
    1, "Digital product", 1, "Digital product desc", 10, 1000, null
);
$itemized_product = new ItemizedProduct(
    2, "Itemized product", 1, "Itemized product desc", 20, 1000, null
);
$weight_product = new WeightProduct(
    3, "Weight product", 1, "Weight product desc", 100, 1000, null
);

function getPrettyString($amount, $abstract_product) {
    echo "Продукт за цену " . $abstract_product->get_price() . 
    " в количестве " . $amount . 
    " стоил " . $abstract_product->calculatePrice($amount) . "\n";
}

getPrettyString(10, $digital_product);  // в 2 раза меньше
getPrettyString(20, $itemized_product);
getPrettyString(0.5, $weight_product);

try {
    $itemized_product->calculatePrice(0.5);
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}