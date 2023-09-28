<?php

namespace itrvb\onlineshop;

class User{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $patronim;
    protected $address;
    protected $email;
    protected $password;
    protected $profile_picture;

    public function __construct(){
        // ...
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function get_first_name()
    {
        return $this->first_name;
    }
    
    public function set_first_name($first_name)
    {
        $this->first_name = $first_name;
    }
    
    public function get_last_name()
    {
        return $this->last_name;
    }

    public function set_last_name($last_name)
    {
        $this->last_name = $last_name;
    }
    
    public function get_patronim()
    {
        return $this->patronim;
    }
    
    public function set__patronim($patronim)
    {
        $this->patronim = $patronim;
    }

    public function get_email()
    {
        return $this->email;
    }
    
    public function set_email($email)
    {
        $this->email = $email;
    }
    
    public function get_password()
    {
        return $this->password;
    }

    public function set_password($password)
    {
        $this->password = $password;
    }

    public function get_profile_picture()
    {
        return $this->profile_picture;
    }
    
    public function set_profile_picture($profile_picture)
    {
        $this->profile_picture = $profile_picture;
    }
}