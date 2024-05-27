<?php

class FailedToLogin extends Exception{


//    protected $message;

    public function __construct( $message,$code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }

    public function customData(){
        echo "<script type='text/javascript'>alert('$this->message');</script>";
    }





}