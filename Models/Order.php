<?php

namespace itrvb\onlineshop;

class Order{
    private $id;
    private $user_id;
    private $basket_id;
    private $address;
    private $total_price;
    private $status;
    private $date;

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

    public function get_basket_id()
    {
        return $this->basket_id;
    }
    
    public function set_basket_id($basket_id)
    {
        $this->basket_id = $basket_id;
    }
    
    public function get_user_id()
    {
        return $this->user_id;
    }
    
    public function set_user_id($user_id)
    {
        $this->user_id = $user_id;
    }
    
    public function get_address()
    {
        return $this->address;
    }
    
    public function set_address($address)
    {
        $this->address = $address;
    }
    
    public function get_total_price()
    {
        return $this->total_price;
    }
    
    public function set_total_price($total_price)
    {
        $this->total_price = $total_price;
    }
    
    public function get_status()
    {
        return $this->status;
    }
    
    public function set_status($status)
    {
        $this->status = $status;
    }
    
    public function getDate()
    {
        return $this->date;
    }
    
    public function setDate($date)
    {
        $this->date = $date;
    }
}