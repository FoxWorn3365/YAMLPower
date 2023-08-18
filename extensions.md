# YAMLPower - Extensions
You can easily extend the power of the YAMLPower parser by creating simple extensions.

## 1- Create a new file with a class
> **Note**
> The file name must be used to load the plugin and the class name must be equal to the file name without the `.php`
Example of the file `MyCustomExt.php`:
```php
<?php

class MyCustomExt {
    public bool $extension = true;  // Confirm that this is an extension
    
    public array $functions = [     // List all methods that this class should register and execute
        'example1',
        'example2'
    ];

    public function __construct() {}  // The construct must be empty or require no args!

    public function example1_executor(object $var, object $args, \FoxWorn3365\YAMLPower\Error $error) : object { // The function that will be executed if a custom method will be used is {methodname}_executor and MUST implements these args!
        // The class MUST return the $var object modified if you want to add or remove var
        // The args are the arguments.
        // If you do example1.uwu the argument $args->action should be 'uwu'
        // The error class is used to throw errors. Set true the second arg if you want the end of the code execution when the error is throw!

        // HERE YOU CAN ADD THE CODE
        // Extensions are not static (they're dynamic) so you can store vars is $this but remember to define first!
    }
}
```