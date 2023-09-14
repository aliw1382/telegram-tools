<?php


use Aliw1382\TelegramTools\Controllers\TelegramController;
use Illuminate\Support\Facades\Route;

Route::middleware( [ 'api', 'telegram' ] )
     ->prefix( 'api' )
     ->post(
         'telegram/{token}/webhook/index.php',
         TelegramController::class
     )
     ->name( 'telegram.webhook' )
     ->where( [ 'token' => '[0-9]{8,10}:[a-zA-Z0-9_-]{35}' ] )
;
