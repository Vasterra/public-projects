<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/api/v1/gettoken',
        '/api/v1/users',
        '/api/v1/users/me',
        '/api/v1/users/all',
        '/api/v1/users/getMyUsers',
        '/api/v1/users/createAdminUser',
        '/api/v1/users/createManager',
        '/api/v1/users/createUser',
        '/api/v1/users/updateUserByAdmin',
        '/api/v1/users/updateMyUser',
        '/api/v1/users/updateMe',
        '/api/v1/users/deleteUser',
        '/api/v1/countries/create',
        '/api/v1/countries/all',
        '/api/v1/countries/getCountryById',
        '/api/v1/countries/getCountryByName',
        '/api/v1/countries/getCountryIsoCode',
        '/api/v1/countries/updateCountry',
        '/api/v1/countries/deleteCountry',
        '/api/v1/users/updateAndActivateMe'
    ];
}
