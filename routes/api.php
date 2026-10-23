<?php

use Illuminate\Support\Facades\Route;

/*
| This build is an interface mockup, so no API endpoints are implemented yet.
| The versioned group is kept so the routing contract is visible to whoever
| picks the backend up.
*/

Route::prefix('v1')->name('api.v1.')->group(function () {
    //
});
