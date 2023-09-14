<?php


return [

    /**
     * Telegram Token Bots
     */
    'telegram-bot-api'         => [

        'token' => env( 'TELEGRAM_API_TOKEN' )

    ],

    /**
     * save log get update
     */
    'update_log'               => env( 'TELEGRAM_LOG', true ),

    /**
     * if find the one command didn't word other command
     */
    'stop-after-first-command' => true,

    /**
     * Command Source Files Code
     */
    'commands' => [

        // Example Command For Message Event
        //\Aliw1382\TelegramTools\Telegram\TelegramMessageCommand::class,

    ]

];
