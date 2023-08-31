<?php

namespace Aliw1382\TelegramTools\Commands;

use Illuminate\Console\Command;

class TelegramGenerateMethodCommand extends Command
{

    /** @var string */
    protected $signature = 'telegram:generate-method {name : Name Of Create Method }
        {--path=}
    ';

    /** @var string */
    protected $description = 'generate new method for your package telegram';

    /**
     * @return void
     */
    public function handle() : void
    {

        $validator = \Validator::make( array_merge( $this->arguments(), $this->options() ), [

            'name' => [ 'required', 'string', 'filled' ],
            'path' => [ 'string', 'nullable' ],

        ] );

        if ( $validator->fails() )
        {

            $this->error( 'Whoops! The given attributes are invalid.' );

            collect( $validator->errors()->all() )
                ->each( fn( $error ) => $this->line( $error ) )
            ;
            exit;

        }

        $this->laravel[ 'method.telegram.creator' ]->create(
            $this->argument( 'name' ),
            $this->option( 'path' ) ?? __DIR__ . '/../Methods/',
            $this->argument( 'name' ),
            true
        );

        $this->info( 'Success Created Method File.' );

    }
}
