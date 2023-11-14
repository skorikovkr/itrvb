<?php

namespace itrvb\onlineshop;

include_once "models/AbstractProduct.php";

class ItemizedProduct extends AbstractProduct
{
    public function calculatePrice($amount) {
        if (is_int($amount))
            return $this->get_price() * $amount;
        else
            throw new \Exception('Amount must be integer for ItemizedProduct.');
    }
}