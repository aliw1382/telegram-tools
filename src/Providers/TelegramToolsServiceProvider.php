<?php

namespace Aliw1382\TelegramTools\Providers;

use Aliw1382\TelegramTools\Commands\TelegramGenerateMethodCommand;
use Aliw1382\TelegramTools\Contracts\TelegramContracts;
use Aliw1382\TelegramTools\Vendor\MethodCreator;
use Aliw1382\TelegramTools\Telegram;
use Aliw1382\TelegramTools\Vendor\TelegramManager;
use Illuminate\Support\ServiceProvider;

class TelegramToolsServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function register() : void
    {

        require_once __DIR__ . '/../helpers.php';

        $this->app->bind( Telegram::class, static fn( $app, $parameters ) => new Telegram(
            ( $parameters[ 'token' ] ?? null )
        ) );

        $this->app->bind( TelegramContracts::class, TelegramManager::class );

        $this->app->singleton( 'method.telegram.creator', function ( $app ) {
            return new MethodCreator( $app[ 'files' ], __DIR__ . './../Methods/stubs' );
        } );

    }

    /**
     * @return void
     */
    public function boot() : void
    {

        $this->commands(
            TelegramGenerateMethodCommand::class
        );

        if ( $this->app->runningInConsole() )
        {

            $this->publishes( [

                __DIR__ . '/../Config' => config_path()

            ], 'config-telegram-tools' );

        }

    }

}
