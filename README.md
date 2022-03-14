## Installation

Make sure "Docker"  
and "Docker Compose" are installed on your machine.

Clone the repository:

```shell
git clone https://github.com/dzianis-chaika/exchange-rates.git
```

Come to the project directory and run the following commands:

1. Install composer dependencies:
```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

If error below occurred on WSL systems

```
[RuntimeException]
/var/www/html/vendor does not exist and could not be created.
```

try to install composer dependencies with the following command

```shell
docker run --rm \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

2. Run Docker containers in detached mode:
```shell
./vendor/bin/sail up -d
```

3. Run database migrations:
```shell
./vendor/bin/sail artisan migrate
```

4. Create a default user in the database:
```shell
./vendor/bin/sail artisan db:seed
```

5. Seed last 30 days exchange rates from cbr.ru service:
```shell
./vendor/bin/sail artisan currencies:seed
```

After all listed commands run,  
the application will be ready on **80** HTTP port.  
Additionally, "phpMyAdmin" will be ready on **8000** HTTP port.

DB username: **sail**  
DB password: **password**

Default user login: **admin**  
Default user password: **admin**

REST API endpoints:

```
date-string format: dd.mm.yyyy

GET       /api/v1/currencies Query{ valuteID?:string, from?:date-string, to?:date-string }
GET       /api/v1/currencies/:id
POST      /api/v1/currencies JSON{ valuteID:string, numCode:string, charCode:string, name:string, value:number, date:date-string }
PUT/PATCH /api/v1/currencies/:id JSON{ valuteID?:string, numCode?:string, charCode?:string, name?:string, value?:number, date?:date-string }
DELETE    /api/v1/currencies/:id
```
