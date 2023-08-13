<?php

namespace FoxWorn3365\YAMLPower;

use FoxWorn3365\YAMLPower\function\Index as FunctionIndex;
use FoxWorn3365\YAMLPower\method\Index as MethodIndex;

class Parser {
    protected string $content;
    protected object $parsed;
    public Error $error;

    public function __construct() {
        $this->error = new Error();
    }

    public function load(string $file) : self {
        $this->content = file_get_contents($file);
        $this->parsed = json_decode(json_encode(yaml_parse(($this->content))));
        return $this;
    }

    public function parse(string $key) : void {
        // the string is the output!
        $code = $this->parsed->{$key};
        if (gettype($code) !== 'array') {
            $this->error->throw('notArrayException', true, ['The code is not an array!']);
        } else {
            // Continue with the code!
            $var = new \stdClass;
            $var = self::parseArray($var, $code, $this->error);
            var_dump($var);
        }
    }

    public static function parseArray(object $var, array $code, Error $error) : object {
        foreach ($code as $row) {
            if (gettype($row) === 'string') {
                $args = explode(' ', $row);
                if (in_array($args[0], FunctionIndex::$list)) {
                    $var = FunctionIndex::getClass($args[0])::execute($var, $args, $error);
                }
            } elseif (gettype($row) === 'object') {
                foreach ($row as $loader => $data) {
                    if (in_array($loader, MethodIndex::$list)) {
                        $var = MethodIndex::getClass($loader)::execute($var, $data, $error);
                    }
                }
            }
        }

        return $var;
    }
}