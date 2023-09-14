<?php

namespace Aliw1382\TelegramTools\Commands;

use Aliw1382\TelegramTools\Facades\Telegram;
use Illuminate\Console\Command;
use Validator;

class TelegramSetWebHookCommand extends Command
{
    protected $signature = 'telegram:web-hook
    {--token= : your token bot}
    {--max_connections= : max connections bot}
    ';

    protected $description = 'set web hook telegram bot';

    /**
     * @return void
     */
    public function handle() : void
    {

        $validator = Validator::make( $this->options(), [
            'token' => [ 'nullable', 'string', 'regex:/^[0-9]{8,10}:[a-zA-Z0-9_-]{35}$/' ]
        ] );

        if ( $validator->fails() )
        {

            $this->error( 'Whoops! The given attributes are invalid.' );

            collect( $validator->errors()->all() )
                ->each( fn( $error ) => $this->line( $error ) )
            ;
            exit;

        }

        $token = $this->option( 'token' ) ?? config( 'telegram.telegram-bot-api.token' );

        if ( preg_match( '/^[0-9]{8,10}:[a-zA-Z0-9_-]{35}$/', $token ) )
        {

            $response = Telegram::setTOKEN( $token )->setWebhook(
                url: route( 'telegram.webhook', [ 'token' => $token ] ),
                more: [
                    'ip_address'      => request()->server( 'SERVER_ADDR' ),
                    'max_connections' => $this->option( 'max_connections' ) ?? 60
                ]
            );

            if ( $response[ 'ok' ] )
                $this->info( 'Successfully' );
            else
                $this->error( 'UnSuccess' );

        }
        else
        {
            $this->error( 'Token Bot Invalid.' );
        }

    }
}
