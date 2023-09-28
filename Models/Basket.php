<?php

namespace itrvb\onlineshop;

class Basket {
    private $id;
    private $user_id;
    private $products;

    public function __construct() {
        // ...
    }
    
    public function get_id()
    {
        return $this->id;
    }
    
    public function set_id($id)
    {
        $this->id = $id;
    }
    
    public function get_user_id()
    {
        return $this->user_id;
    }
    
    public function set_user_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function add_product($product, $quantity) 
    { 
        if (!isset($this->products[$product->get_id()])) {
            $this->products[$product->get_id()] = 0;
        }
        $this->products[$product->get_id()] += $quantity;
    }

    public function remove_product($product, $quantity) 
    { 
        if (isset($this->products[$product->get_id()])) {
            $this->products[$product->get_id()] -= $quantity;
        }
    }
}