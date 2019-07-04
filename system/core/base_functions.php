<?php

function dump($var)
{
    echo '<pre>';
    var_dump($var);
    echo "\n";
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    die;
}
