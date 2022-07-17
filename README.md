# mock-server
A quick to configure and deploy mock API server to accelerate your Integrations

Proudly in PHP

## Features

- PHP 7.4 and above
- No dependencies/frameworks
- Responsive out-of-the-box
- Configuration defined Routes
- Static and Dynamic Responses

# Config

See config/mock-server.config.php for default config.

# Unit Testing

```shell
./vendor/bin/phpunit --testdox tests/unit
```

# Running Server via local php

php must be able to see `index.php`

```shell
php -S 127.0.0.1:8765 -t /install/dir/
```

# Integration Testing

Run local php server as shown above then:

```shell
$ vendor/bin/phpunit --testdox tests/rest/
```

# Running Server via Docker

default port 8765

```shell
$ docker compose up --build
$ curl -s http://localhost:8765/mock-server/status
2022-07-17 13:45:04 / Operational (script:mock-server-status.php)
```

