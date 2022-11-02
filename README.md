# Environment

Set environment variables via .env file or array.

Overrides vars on `$_SERVER` with the same key.
Keys are case-sensitive. 
**Env Var keys should be upper case by convention.** 


## Usage

### By Array

```php
$loader = new LoaderArray([
    'FOO' => 'BAR'
]);
Env::set($loader);
```

### By .env File

```php
$loader = new LoaderDotenv('path/to/.env/file/');
Env::set($loader);
```

or specify file.

```php
$loader = new LoaderDotenv('path/', 'my.env');
Env::set($loader);
```

### Access ENV

```php
Env::get('FOO')
```

### Check for blank or missing vars

```php
$loader = new LoaderArray([
    'X' => 'foo',
    'Y' => ''
]);
Env::set($loader);
$missing = Env::missing(['X', 'Y', 'Z']);

// $missing has ['Y', 'Z']
```