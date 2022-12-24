# Maintenance Mode for Codeigniter 4

Maintenance mode module for CodeIgniter 4 with CLI

## Installing

```shell
$ composer require codeigniterext/maintenancemode
```

or 

```shell
$ composer require codeigniterext/maintenancemode:dev-master
```

Now you can use the following commands from the command prompt
```shell
$ php spark mm:publish
$ php spark mm:down
$ php spark mm:status
$ php spark mm:up
```
---

## Configuration
Run the following command from the command prompt, and it will copy views (error_503.php)  into your application
```shell
$ php spark mm:publish
```

## Use it

#### Method 1 (Recommended)

edit application/Config/Events.php and
add the new line top of the code for maintenance mode check:

```php
Events::on('post_controller_constructor', 'CodeigniterExt\MaintenanceMode\Controllers\MaintenanceMode::check');
...
```

---

#### Method 2

edit application/Config/Filters.php and
add the new line in $aliases array:

```php
public $aliases = [
    'maintenancemode' => \CodeigniterExt\MaintenanceMode\Filters\MaintenanceMode::class,
    ...
]
```
and add "maintenancemode" in $globals['before'] array:
```php
public $globals = [
    'before' => [
        'maintenancemode',
        ...
    ],
    'after'  => [
        ...
    ],
];
```
