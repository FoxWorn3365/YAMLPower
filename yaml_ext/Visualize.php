<?php

use FoxWorn3365\YAMLPower\Error;

class Visualize {
    public bool $extension = true;
    public array $functions = [
        'visualizator'
    ];

    public function __construct() {
    }

    public function visualizator_executor(object $var, object $args, Error $error) : object {
        die("NO U HAHAHA\n\n\n\nAHHAHAH");
        return $var;
    }
}