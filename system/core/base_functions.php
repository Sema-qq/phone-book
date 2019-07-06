<?php

function dump($var)
{
    echo '<pre>';
    var_export($var);
    echo "\n";
}

function dd($var)
{
    echo '<pre>';
    var_export($var);
    die;
}
