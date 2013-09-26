<?php
    error_reporting(-1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once ('vendor/autoload.php');

    use Syngr\Number;
    $number = new Number(49);
    // echo $number->sqrt_to();
    // echo $number->as_max(array(1,7,9));
    // $string = new String('Hello World');
    // echo $string;
