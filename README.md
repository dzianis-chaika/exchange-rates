## Installation

Make sure "Docker"  
and "Docker Compose" are installed on your machine.

```shell
git clone https://github.com/dzianis-chaika/exchange-rates.git
```

Come to project directory and run the following commands:

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
 
 or
 
 docker run --rm \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
 
 if error "[RuntimeException] /var/www/html/vendor does not exist and could not be created." occurred

./vendor/bin/sail up

./vendor/bin/sail artisan migrate

./vendor/bin/sail artisan db:seed

./vendor/bin/sail artisan currencies:seed
```

After, the application will be ready on 80 HTTP port.  
Additionally, "phpMyAdmin" will be ready on 8000 HTTP port.

DB username: **sail**  
DB password: **password**

Admin user login: **admin**  
Admin user password: **admin**

REST API endpoints:

```
date-string format: dd.mm.yyyy

GET       /api/v1/currencies Query{ valuteID?:string, from?:date-string, to?:date-string }
GET       /api/v1/currencies/:id
POST      /api/v1/currencies JSON{ valuteID:string, numCode:string, charCode:string, name:string, value:number, date:date-string }
PUT/PATCH /api/v1/currencies/:id JSON{ valuteID?:string, numCode?:string, charCode?:string, name?:string, value?:number, date?:date-string }
DELETE    /api/v1/currencies/:id
```
