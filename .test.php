<?php
require 'loader.php';

use FoxWorn3365\YAMLPower\Parser;

$parser = new Parser();

$parser->error->globalHandler(function ($name, $data) {
    var_dump($name, $data);
});

$parser->load('config.yml')->parse('code');