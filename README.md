# YAMLPower
Add high customization at the highest level to your YAML configurations: programming.<br>
This library allows you to parse special code written in YAML and execute it, thus allowing the user more complete and direct customization

## Installation
Copy all the files contained within the `src/` folder into your project and include them with the file `loader.php`.<br><br>
Example:
```php
<?php
require_once 'loader.php';

// .. code ..
```

## Implementation
To use the parser, it is necessary to specify the file and location of the object, for example:
```php
<?php
require_once 'loader.php';

use FoxWorn3365\YAMLPower\Parser;

$parser = new Parser();

$parser->error->globalHandler(function(string $ex, array $data) {
    // handle every exception
});

$parser->load('config.yml');
$parser->parse('code');
```

## Functions
### `define`
Define a var
```yaml
    - define <VAR> = <STRING VALUE>
```
Example:
```yaml
    - define a = hello
```

### `var`
Define a var
```yaml
    - var <VAR> = <STRING VALUE>
```
Example:
```yaml
    - var a = hello
```

### `print`
Print a var
```yaml
    - print <VAR>
```
Example:
```yaml
    - print a
```

### `echo`
Alias of [print](#print)

### `display`
Alias of [print](#print)

### `dump`
Dump a var
```yaml
    - dump <VAR>
```
Example:
```yaml
    - dump a
```

## Methods

### `get`
Make an HTTP GET request
```yaml
    - get:
        url: <URL>
        to: <VAR>
        toHeaders: <VAR>
        onSuccess: <ARRAY (CODE)>
        onError: <ARRAY (CODE)>
```
Example:
```yaml
    - get:
        url: https://example.com
        to: a
```
> **Note**
> Response will be saved to the var `a`, the others args are not mandatory.
> toHeaders saves in a var the response headers as ARRAY

### `post`
Make an HTTP POST request
```yaml
    - post:
        url: <URL>
        content: <STRING|ARRAY>
        headers: <ARRAY>
        to: <VAR>
        toHeaders: <VAR>
        onSuccess: <ARRAY (CODE)>
        onError: <ARRAY (CODE)>
```
Example:
```yaml
    - post:
        url: https://example.com/API/v1/users
        content: '{"name":"ZioPera"}'
        headers: 
            - 'Content-Type: application/json'
        to: a
```
> **Note**
> Request will be sent with the defined `content` (can be an array or a string) and `headers` (array)
> Response will be saved to the var `a`, the others args are not mandatory.
> toHeaders saves in a var the response headers as ARRAY

### `file`
Manage file(s) (not dir)
```yaml
    - file:
        action: <STRING (READ|WRITE|DELETE|EXISTS)>
        file: <STRING>
        ?to: <VAR>
        ?content: <STRING>
        ?do: <ARRAY (CODE)>
```
Example (creating and reading a file if exists):
```yaml
    - file:
        action: write
        file: mynames.txt
        content: Silvio Berlusconi, Mara Maionchi, Barbara d'Urso, Paolo Bonolis
    -
    - file:
        action: exists
        file: mynames.txt
        do:
            - 
            - file:
                action: read
                file: mynames.txt
                to: a
            -
            - print a
```
> **Note**
> Some methods are not mandatory.
> When writing the `content` method is mandatory, then reading the `to` method is mandatory and when finding the `do` method is mandatory. You can also set a `else` method (array (CODE)) to catch and manage a negative response.

### `dir`
Manages directories (no files!)
```yaml
    - dir:
        action: <STRING (CREATE|REMOVE|EXISTS)>
        dir: <STRING>
        ?permissions: <INT>
        ?recursive: <BOOL>
        ?do: <ARRAY (CODE)>
```
Example: create a directory and then check if exists!
```yaml
    - dir:
        action: create
        dir: barb/
        permissions: 0770
    -
    - dir:
        action: exists
        dir: barba/
        do:
            # THIS CODE WILL NEVER BE EXECUTED!
            - define output = No u
            - print output
        else:
            - define output = Nope
            - print output
```

### `list`
Create and manage lists (simple arrays)
```yaml
    - list:
        action: <STRING (CREATE|ADD|GET|SET|COUNT|FOREACH)>
        ?to: <VAR>
        ?list: <VAR>
        ?index: <INT>
        ?data: <VAR|STRING>
        ?as: <VAR>
        ?do: <ARRAY (STRING)>
```
Example: create a list, add and remove some values and then foreach
```yaml
    - list:
        action: create
        to: b
    -
    - list:
        action: add
        list: b
        data: Oh my god!
    -
    - list:
        action: add
        list: b
        data: Nope
    - list:
        action: set
        index: 0
        list: b
        data: UWU
    - list:
        action: foreach
        list: b
        as: element
        do:
            - print element
```
Output:
```
UWU
Nope
```

### `json`
Encode and decode json 
```yaml
    - json:
        action: <STRING (ENCODE or SERIALIZE|DECODE or DESERIALIZE or PARSE)
        from: <VAR>
        to: <VAR>
```
Example: define a list and serialize as JSON
```yaml
    - list:
        action: create
        to: b
    -
    - list:
        action: add
        list: b
        data: Oh my god!
    -
    - list:
        action: add
        list: b
        data: Nope
    - json:
        action: serialize
        from: b
        to: a
    - print a
```
Output:
```
["Oh my god!", "Nope"]
```

### `object`
Manage objects (AKA arrays with keys)

```yaml
    - object:
        action: <STRING (MAKE|SET|GET|COUNT|FOREACH)>
        ?object: <VAR>
        ?to: <VAR>
        ?key: <VAR|STRING>
        ?data: <VAR|STRING>
        ?as: <STRING (SPECIFIED)>
        ?do: <ARRAY (VALUES)>
```
Example: define an object and foreach
```yaml
    - object:
        action: create
        to: a
    - object:
        action: set
        object: a
        key: first
        value: bruh
    - object:
        action: set
        object: a
        key: idk
        value: ASASASAS
    -
    - object:
        action: foreach
        object: a
        as: k => v
        do:
            - print k
            - print v
    - define a = end
    - print a
```
Output:
```
first
bruh
idk
ASASASAS
end
```

### `if`
Statement with no condition catch

```yaml
    - if:
        first: <VAR>
        comparator: <STRING (==|===|!=|!==|<|>|<=|>=|is|not)>
        second: <VAR|COMPARATOR (EMPTY|NULL|TRUE|FALSE)>
        do: <ARRAY (CODE)>
        ?else: <ARRY (CODE)>
```
Example #1: Compare two vars
```yaml
    - define a = 50
    - define b = 75
    - define c = 71
    - if:
        first: a
        comparator: <=
        second: b
        do:
            - if:
                first: b
                comparator: ==
                second: c
                do:
                    - define c = This will never gonna happens!
                    - print c
                else: 
                    - define c = Ok, this will be displayed!
                    - print c
        else:
            - define c = This will never gonna happens!
            - print c
```
Example #2: Is a var empty?
```yaml
    - define b = 77
    - if:
        first: a
        comparator: is
        second: empty
        do: 
            # THIS CODE WILL BE EXECUTED
        else:
            # THIS NOT!
```