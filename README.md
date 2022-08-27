### Installation
Install composer dependencies without installing composer itself
```sh
sudo docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

```sh
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate:seed
```
### Login
```
superuser@example.com
qwerty123456
```
