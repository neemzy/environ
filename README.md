# ENVIRON

Lightweight environment manager

## HOW TO USE IT

### 1. Instantiate

```php
$environ = new Neemzy\Environ\Manager();
```

### 2. Add environments

When adding an environment, you have to specify :

- A name
- A condition closure
- A callback closure

```php
$environ
    ->add(
        'dev',
        new Neemzy\Environ\Environment(
            function () {
                return preg_match('/localhost/', $_SERVER['SERVER_NAME']);
            },
            function () {
                $pdo = new PDO('sqlite:dev.db');
            }
        )
    )
    ->add(
        'prod',
        new Neemzy\Environ\Environment(
            function () {
                return true;
            },
            function () {
                $pdo = new PDO('mysql:host=MYHOST;dbname=MYDBNAME', 'MYUSER', 'MYPASSWORD');
            }
        )
    );
```

You can chain declarations as above.

You can also use multiple detection cases for a single key. 

```php
$environ->add('prod', new Environment(function () {
    return php_sapi_name() == 'cli' && MY_PROJECT_DIR == '/var/www/myproject';
}));
$environ->add('prod', new Environment(function () {
    return $_SERVER['HTTP_HOST'] == 'my.domain';
}));
$environ->init();
```

### 3. Trigger detection

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
