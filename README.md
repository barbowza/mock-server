# mock-server
A quick to configure and deploy mock API server to accelerate your Integrations

Proudly in PHP

## Features

- PHP 7.4 and above
- No dependencies/frameworks
- Responsive out-of-the-box
- Configuration defined Routes
- Static and Dynamic Responses

# Unit Testing

```shell
./vendor/bin/phpunit --testdox tests/unit
```

# Running Server

```shell
php -S 127.0.0.1:8765 -t /path/to/src/
```

# Integration Testing

Run server as shown above. Then:

```shell
$ vendor/bin/phpunit --testdox tests/rest/
```