REST API
========

Endpoint | Description
--- | ---
`/api/docs` | Documentation

#Problem swagger

add in producion env `L5_SWAGGER_GENERATE_ALWAYS = false` or local  `true`
and add in `AppServiceProvider.php`
```
 public function boot()
    {
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
 ```

 change language en to pt-br ++
 https://github.com/lucascudo/laravel-pt-BR-localization


