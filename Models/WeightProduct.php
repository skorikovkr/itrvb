<?php

namespace itrvb\onlineshop;

include_once "models/AbstractProduct.php";

class WeightProduct extends AbstractProduct
{
    public function calculatePrice($amount) {
        return $this->get_price() * $amount;
    }
}