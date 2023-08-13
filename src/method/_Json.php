<?php

namespace FoxWorn3365\YAMLPower\method;

use FoxWorn3365\YAMLPower\Error;
use FoxWorn3365\YAMLPower\ArgChecker;

final class _Json {
    public static function execute(object $var, object $args, Error $error) : object {
        ArgChecker::check([
            'string action',
            'string from',
            'string to'
        ], $args, $error);

        if ($args->action === 'serialize' || $args->action === 'encode') {
            $var->{$args->to} = json_encode($args->from);
        } elseif ($args->action === 'deserialize' || $args->action === 'decode' || $args->action === 'parse') {
            $var->{$args->to} = json_decode($args->from);
        } else {
            $error->throw('undefinedRequestException', false);
        }
        return $var;
    }
}