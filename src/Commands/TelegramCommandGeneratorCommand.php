<?php

namespace Aliw1382\TelegramTools\Commands;

use Aliw1382\TelegramTools\Enums\TelegramAbstract;
use Illuminate\Console\Command;
use Illuminate\Validation\Rules\Enum;
use Validator;

class TelegramCommandGeneratorCommand extends Command
{
    protected $signature = 'telegram:command {name : Name Of Command Telegram Handler }
        {--path= : Your Custom Path}
        {--type=Message : you can just use ( Message , CallbackQuery , ChannelPost , ChatJoinRequest , ChatMember , EditedChannelPost )}
    ';

    protected $description = 'you can make command for developer your source bot telegram';

    /**
     * @return void
     */
    public function handle() : void
    {

        $validator = Validator::make( array_merge( $this->arguments(), $this->options() ), [

            'name' => [ 'required', 'string', 'filled' ],
            'path' => [ 'string', 'nullable' ],
            'type' => [ 'required', 'string', new Enum( TelegramAbstract::class ) ],

        ] );

        if ( $validator->fails() )
        {

            $this->error( 'Whoops! The given attributes are invalid.' );

            collect( $validator->errors()->all() )
                ->each( fn( $error ) => $this->line( $error ) )
            ;
            exit;

        }

        $path = $this->laravel[ 'abstract.telegram.creator' ]->create(
            $this->argument( 'name' ),
            $this->option( 'path' ) ?? app_path( 'Telegram' ),
            $this->argument( 'name' ),
            $this->option( 'type' ),
            true
        );

        $this->info( 'Success Created Command File.' );
        $this->line( $path );

    }
}
