**This is a PHP 7+ version from an initial fork of https://github.com/pearlkrishn/lumen-request-validate**
----
Lumen doesn't have form request validator seperatly. This package helps developers to segregate the validation layer from the controller to a separate dedicated class.

## Installation

   `composer require ghostff/lumen-formrequest`

- Add the service provider in bootstrap/app.php

`$app->register(Ghostff\FormRequest\RequestServiceProvider::class);`

Next step is create your validator class using below console comment

`php artisan make:request {class_name}`

 Request validator class will be create under **app/Http/Requests** folder.
 
 #### Example:
 
 Login validation class
 ```php
<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Ghostff\FormRequest\AbstractFromRequest;

class Login extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            "username" => "required",
            "password" => "required"
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}

```
 
 
 ## How to use?
 Now you can use your Request class in method injections
```php
use App\Http\Requests\Login;

class ExampleController extends Controller
{
    public function auth(Login $request)
    {
        $validated = $request->validated();
	    //Login logic goes here
    }
...
```
