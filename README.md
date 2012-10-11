HttpServer
==========

A wrapper around PHP 5.4's HTTP Server.


Requirements
------------

* PHP 5.4


Installation
------------

In your [composer.json](http://getcomposer.org), add the following:

    "require" {
        "robloach/httpserver": "*"
    }


Usage
-----

```php
// Set up the HTTP web server.
$server = new HttpServer\HttpServer('/var/www', 'localhost', 8080);
$server->start();

// Do something with it.
$contents = file_get_contents('http://localhost:8080/example.php');

// Now that we've done something, let's shut it down.
$server->stop();
```


Testing
-------

    php composer.phar install --dev
    php vendor/bin/phpunit