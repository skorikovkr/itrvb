<?php

namespace itrvb\onlineshop;

abstract class AbstractProduct{

    public function __construct(
        protected $id,
        protected $name,
        protected $category_id,
        protected $description,
        protected $price,
        protected $amount_left,
        protected $image,
    )
    {
    }

    abstract protected function calculatePrice($amount);
    
    public function get_id()
    {
        return $this->id;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }
    
    public function get_category_id()
    {
        return $this->category_id;
    }
    
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;
    }
    
    public function get_name()
    {
        return $this->name;
    }
    
    public function set_name($name)
    {
        $this->name = $name;
    }
    
    public function get_description()
    {
        return $this->description;
    }
    
    public function set_description($description)
    {
        $this->description = $description;
    }
    
    public function get_price()
    {
        return $this->price;
    }
    
    public function set_price($price)
    {
        $this->price = $price;
    }
    
    public function get_amount_left()
    {
        return $this->amount_left;
    }

    public function set_amount_left($amount_left)
    {
        $this->amount_left = $amount_left;
    }

    public function get_image()
    {
        return $this->image;
    }

    public function set_image($image)
    {
        $this->image = $image;
    }
}
