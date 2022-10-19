### oAuth server implementation with Laravel and Passport

#### Installation
1. Clone the repo
2. `cd <clone directory>`
3. Run following command to install application's dependency
``` 
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
4. comy `.env.example` to `.env` 
5.`./vendor/bin/sail up -d`
6. Make the `sail` alias if you need https://laravel.com/docs/9.x/sail#configuring-a-shell-alias
7. `sail artisan migrate`
