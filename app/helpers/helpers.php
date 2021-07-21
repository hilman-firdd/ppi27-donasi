<?php

if (! function_exists('moneyFormat')) {
    function moneyFormat($str){
        return 'Rp. ' . number_format($str, '0', '', '.');
    }
}