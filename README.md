# Environment

Set environment variables via a `.env file` or an `associative array`.

Overrides variables already set on `$_SERVER` with the same key.

Keys are case-sensitive and by convention should be upper case. 

Values will always be treated as strings.
```
MY_BOOL=true
```

Will be `"true"`

## Usage

### Setting Environment By Array

```php
$loader = new LoaderArray([
    'FOO' => 'BAR'
]);
Env::set($loader);
```

### Setting Environment By .env File

```php
$loader = new LoaderDotenv('path/to/.env/file/');
Env::set($loader);
```

or define a specific file.

```php
$loader = new LoaderDotenv('path/', 'my.env');
Env::set($loader);
```

### Accessing Environment variables

`Get` always returns a string.
If the environment variable is not set and empty string is returned. 

```php
Env::get('FOO')
```

### Check missing environment variables

```php
$loader = new LoaderArray([
    'X' => 'foo',
    'Y' => ''
]);
Env::set($loader);
$missing = Env::missing(['X', 'Y', 'Z']);

// $missing has ['Y', 'Z']
```

### Check for true values

A true value is "true" or "1"

```php
$loader = new LoaderArray([
    'X' => 'true',
    'Y' => '1',
    'Z' => 'Anything else'
]);
Env::set($loader);
$true = Env::isTrue('X'); // true
$true = Env::isTrue('Y'); // true
$true = Env::isTrue('Z'); // false
```