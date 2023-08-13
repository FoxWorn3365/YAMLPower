<?php

namespace FoxWorn3365\YAMLPower\method;

use FoxWorn3365\YAMLPower\Error;
use FoxWorn3365\YAMLPower\Parser;
use FoxWorn3365\YAMLPower\ArgChecker;

final class _Dir {
    public static function execute(object $var, object $args, Error $error) : object {
        ArgChecker::check([
            'string action',
            'string dir'
        ], $args, $error);

        if ($args->action === 'create' || $args->action === 'make') {
            if (ArgChecker::has('int permissions', $args)) {
                $permissions = $args->permissions;
            } else {
                $permissions = 0777;
            }

            if (ArgChecker::has('bool recursive', $args)) {
                $recursive = $args->recursive;
            } else {
                $recursive = false;
            }

            @mkdir($args->dir, $permissions, $recursive);
        } elseif ($args->action === 'remove' || $args->action === 'delete') {
            self::rrmdir($args->dir);
        } elseif ($args->action === 'exists') {
            if (is_dir($args->file)) {
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
            $error->throw('undefinedRequestException');
        }
        
        return $var;
    }

    protected static function rrmdir($dir) { 
        if (is_dir($dir)) { 
          $objects = scandir($dir);
          foreach ($objects as $object) { 
            if ($object != "." && $object != "..") { 
              if (is_dir($dir. DIRECTORY_SEPARATOR .$object) && !is_link($dir."/".$object))
                self::rrmdir($dir. DIRECTORY_SEPARATOR .$object);
              else
                unlink($dir. DIRECTORY_SEPARATOR .$object); 
            } 
          }
          rmdir($dir); 
        } 
    }
}