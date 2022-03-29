REST API
========

Endpoint | Description
--- | ---
`POST /api/authentication` | auth user
`GET /api/v1/user` | will return the list of all users
`POST /api/v1/user` | create new user
`GET /api/v1/level` | will return the list of all level
`GET /account/me`| retrieve logged user information

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