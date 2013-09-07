# ENVIRON

PHP 5.3+ lightweight environment manager/helper

## HOW TO USE IT

### 1. Instantiate

```php
$environ = new Environ\Environ();
```

### 2. Add environments

When adding an environment, you have to specify :

- A name
- A condition closure
- A callback closure

```php
$environ->add(
    'dev',
    function () {
        return preg_match('/localhost/', $_SERVER['SERVER_NAME']);
    },
    function () {
        $pdo = new PDO('sqlite:dev.db');
    }
);

$environ->add(
    'prod',
    function () {
        return true;
    },
    function () {
        $pdo = new PDO('mysql:host=MYHOST;dbname=MYDBNAME', 'MYUSER', 'MYPASSWORD');
    }
);
```

### 3. ???

```php
$environ->init();
```

This will browse the environments you declared above. The first one which condition closure returns a truthy value is then set up as the current environment, and its callback closure is triggered.

### 4. Profit !

Let's assume you're on localhost.

```php
// This will print 'dev'
echo($environ->get());

// Triggers the callback as well
$environ->set('prod');

if ($environ->is('prod')) {
    // There you go !
}
```
