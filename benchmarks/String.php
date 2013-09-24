<?php

    error_reporting(-1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once ('vendor/autoload.php');

    use Syngr\String;

    $test_raw_strings = array();
    for ($i=0; $i < 1000; $i++) {
        $test_raw_strings[] = 'STRING';
    }

    $test_syngr_strings = array();
    for ($i=0; $i < 1000; $i++) {
        $test_syngr_strings[] = new String('STRING');
    }

    PHP_Timer::start();

    $result_array = array();
    foreach ($test_raw_strings as $key => $value) {
        $result_array[] = str_replace('RIN', 'YLIN', $value);
    }

    echo PHP_Timer::secondsToTimeString(PHP_Timer::stop()).PHP_EOL;

    PHP_Timer::start();

    $result_2_array = array();
    foreach ($test_syngr_strings as $key => $value) {
        $result_2_array[] = $value->replace('RIN', 'YLIN');
    }

    echo PHP_Timer::secondsToTimeString(PHP_Timer::stop()).PHP_EOL;

