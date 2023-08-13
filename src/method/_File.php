<?php

namespace FoxWorn3365\YAMLPower\method;

use FoxWorn3365\YAMLPower\Error;
use FoxWorn3365\YAMLPower\Parser;
use FoxWorn3365\YAMLPower\ArgChecker;

final class _File {
    public static function execute(object $var, object $args, Error $error) : object {
        ArgChecker::check([
            'string action',
            'string file'
        ], $args, $error);

        if ($args->action === 'read' || $args->action === 'get') {
            if (ArgChecker::has('string to', $args)) {
                $var->{$args->to} = @file_get_contents($args->file);
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'write' || $args->action === 'put') {
            if (ArgChecker::has('string content', $args)) {
                file_put_contents($args->file, $args->content);
            } else {
                $error->throw('noRequredArgForSpecificTaskException', false);
            }
        } elseif ($args->action === 'delete' || $args->action === 'remove') {
            @unlink($args->file);
        } elseif ($args->action === 'exists') {
            if (file_exists($args->file)) {
                if (ArgChecker::has('array do', $args)) {
                    $var = Parser::parseArray($var, $args->do, $error);
                } else {
                    $error->throw('noRequredArgForSpecificTaskException', false);
                }
            } else {
                if (ArgChecker::has('array else', $args)) {
                    $var = Parser::parseArray($var, $args->do, $error);
                } else {
                    $error->throw('noRequredArgForSpecificTaskException', false);
                }
            }
        } elseif ($args->action === 'notExists') {
            if (!file_exists($args->file)) {
                if (ArgChecker::has('array do', $args)) {
                    $var = Parser::parseArray($var, $args->do, $error);
                } else {
                    $error->throw('noRequredArgForSpecificTaskException', false);
                }
            } else {
                if (ArgChecker::has('array else', $args)) {
                    $var = Parser::parseArray($var, $args->do, $error);
                } else {
                    $error->throw('noRequredArgForSpecificTaskException', false);
                }
            }
        } else {
            $error->throw('undefinedRequestException', false);
        }
        return $var;
    }
}