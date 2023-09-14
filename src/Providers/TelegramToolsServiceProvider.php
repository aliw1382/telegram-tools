<?php

namespace Aliw1382\TelegramTools\Providers;

use Aliw1382\TelegramTools\Commands\TelegramCommandGeneratorCommand;
use Aliw1382\TelegramTools\Commands\TelegramGenerateMethodCommand;
use Aliw1382\TelegramTools\Commands\TelegramSetWebHookCommand;
use Aliw1382\TelegramTools\Contracts\Interface\TelegramContracts;
use Aliw1382\TelegramTools\Middlewares\TelegramMiddleware;
use Aliw1382\TelegramTools\Telegram;
use Aliw1382\TelegramTools\Vendor\CommandCreator;
use Aliw1382\TelegramTools\Vendor\MethodCreator;
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

        $this->app->singleton( 'method.telegram.creator', static fn( $app ) => new MethodCreator(
            $app[ 'files' ],
            __DIR__ . './../Methods/stubs'
        ) );

        $this->app->singleton( 'abstract.telegram.creator', static fn( $app, $parameters ) => new CommandCreator(
            $app[ 'files' ],
            __DIR__ . './../Contracts/Abstract/stubs'
        ) );

    }

    /**
     * @return void
     */
    public function boot() : void
    {

        $this->commands(
            TelegramGenerateMethodCommand::class,
            TelegramCommandGeneratorCommand::class,
            TelegramSetWebHookCommand::class
        );

        $this->loadRoutesFrom(
            __DIR__ . '/../Routes/web.php'
        );

        $this->app[ 'router' ]->aliasMiddleware( 'telegram', TelegramMiddleware::class );

        if ( $this->app->runningInConsole() )
        {

            $this->publishes( [

                __DIR__ . '/../Config'   => config_path(),
                __DIR__ . '/../Telegram' => app_path( 'Telegram' )

            ], 'config-telegram-tools' );

        }

    }

}
