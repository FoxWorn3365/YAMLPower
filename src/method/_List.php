<?php

namespace FoxWorn3365\YAMLPower\method;

use FoxWorn3365\YAMLPower\Error;
use FoxWorn3365\YAMLPower\Parser;
use FoxWorn3365\YAMLPower\ArgChecker;

final class _List {
    public static function execute(object $var, object $args, Error $error) : object {
        ArgChecker::check([
            'string action'
        ], $args, $error);

        if ($args->action === 'make' || $args->action === 'create') {
            if (ArgChecker::has('string to', $args)) {
                $var->{$args->to} = [];
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'add') {
            if (ArgChecker::has('string list', $args) && ArgChecker::has('string data', $args)) {
                $var->{$args->list}[] = $args->data;
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'count') {
            if (ArgChecker::has('string list', $args) && ArgChecker::has('string to', $args)) {
                $var->{$args->to} = count($var->{$args->list});
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'get') {
            if (ArgChecker::has('string list', $args) && ArgChecker::has('int index', $args) && ArgChecker::has('string to', $args)) {
                $var->{$args->to} = $var->{$args->list}[$args->index];
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'set') {
            if (ArgChecker::has('string list', $args) && ArgChecker::has('int index', $args) && ArgChecker::has('string data', $args)) {
                $var->{$args->list}[$args->index] = $var->{$args->data};
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'foreach') {
            if (ArgChecker::has('string list', $args) && ArgChecker::has('string as', $args) && ArgChecker::has('array do', $args)) {
                foreach ($var->{$args->list} as $element) {
                    $var->{$args->as} = $element;
                    $var = Parser::parseArray($var, $args->do, $error);
                }
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } else {
            $error->throw('undefinedRequestException', false);
        }
        
        return $var;
    }
}