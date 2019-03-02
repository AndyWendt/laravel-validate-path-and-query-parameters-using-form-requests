# Laravel Validate Query and Path/Route Parameters 

An example repository on how to validate route/path and query parameters using Laravel Form Requests.  

The two primary classes at play are [here](https://github.com/AndyWendt/laravel-validate-path-and-query-parameters-using-form-requests/tree/master/app/Http/Requests)

Read more about how to easily use this in this snippet: https://commandz.io/snippets/laravel/laravel-validate-path-or-query-parameter-in-form-request/

```php
<?php

protected $routeParametersToValidate = ['post_id' => 'postId'];
protected $queryParametersToValidate = ['include' => 'include'];

public function rules()
{
    return [
        'post_id' => 'required|exists:posts,id',
        'include' => 'sometimes|numeric|nullable',
        'name' => 'required|string',
    ];
}
```
