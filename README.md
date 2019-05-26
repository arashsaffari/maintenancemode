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
---

## Configuration
Run the following command from the command prompt, and it will copy views (error_503.php)  into your application
```shell
$ php spark mm:publish
```

## Use it
```shell
$ php spark mm:down
```
```shell
$ php spark mm:status
```
```shell
$ php spark mm:up
```

