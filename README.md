
<p align="center"><img src="https://github.com/aliw1382/telegram-tools/assets/22743719/f7c7bef0-3b39-4f5a-868d-cc8d54410a67" alt="Laravel Telegram Tools"></p>

<div dir="rtl">

[داکیومنت فارسی](README-FA.md)

</div>

# About Package

> This package is in its test version, it may have problems!

<p>This package is made so that people who build Telegram bots can easily and quickly code their bots.</p>
<p>This package was developed and designed by Ali Shahmohammadi.</p>

# Requirement
* guzzlehttp/guzzle ^7.*
* illuminate/support ~5.8.0|^6.0|^7.0|^8.0|^9.0|^10.0
* php >= 7.4

# Installation ✨

<p>To install and receive the package in your Laravel project, execute the following command in the terminal of your project path.</p>

```bash
$ composer require aliw1382/telegram-tools
```

# Add Providers

Open the file `config/app.php` and add the following values to it.

Providers:
```php
'providers' => [

    // ......
    
    Aliw1382\TelegramTools\Providers\TelegramToolsServiceProvider::class,
    
    // ......

]
```

Aliases:

```php
'aliases' => [

    // ......
    
    'Telegram' => Aliw1382\TelegramTools\Facades\Telegram::class,
    
    // ......

]
```

# Publish Config

```bash
$ php artisan vendor:publish --tag=config-telegram-tools
```

Then the file `config/telegram.php` is created.

```php
'telegram-bot-api' => [

    'token' => env( 'TELEGRAM_API_TOKEN' )
    
]
```

# .Env File

Add this `.env` file and put the token received from **Bot Father** here.
```dotenv
TELEGRAM_API_TOKEN=
```

# Usage

* The first method

```php
telegram()->sendMessage( [

    'chat_id' => 'YOUR CHAT ID',
    'text'    => 'YOUR CONTENT TEXT'
    // ....

] );

telegram( 'Your Other Token Bot' )->sendMessage( [

    'chat_id' => 'YOUR CHAT ID',
    'text'    => 'YOUR CONTENT TEXT'
    // ....

] );
```

> If you use `telegram()` we use your `.env` token bot.

* The second method

```php
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->send();

telegram( 'Your Other Token Bot' )->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->send();
```

For Example For `SendMessage` With Keyboard And Parse Mode:
```php
// Keyboard
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->parseMode( 'html' )->button( 'Button 1' )->button( 'Button 2' )->send();

// Inline Keyboard
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->parseMode( 'MarkdownV2' )->button( 'Google' , 'https://google.com' )->buttonWithCallback( 'Button 1' , 'Your Callback Data' )->send();
```

* The third method

```php
\Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT' );
```
or
```php
use Aliw1382\TelegramTools\Facades\Telegram;

Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT' );
```

For Example For `SendMessage` With Keyboard And Parse Mode:
```php
use Aliw1382\TelegramTools\Facades\Telegram;

Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT', Telegram::buildKeyBoard( [
    [
        Telegram::buildKeyboardButton( 'Button 1' ),
        Telegram::buildKeyboardButton( 'Button 2' , true ), // for request contact
    ]
] ) , 'html' );

Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT', Telegram::buildInlineKeyBoard( [
    [
        Telegram::buildInlineKeyboardButton( 'Google' ,'https://google.com'),
        Telegram::buildInlineKeyboardButton( 'Button 1' , '','Your CALLBACK DATA' ),
        // or
        Telegram::buildInlineKeyboardButton( text: 'Button 2' ,callback_data: 'Your CALLBACK DATA' ),
    ]
] ) , 'html' );

```

<p align="center">✨ I hope you enjoy this package ✨</p>

# Source Code Programming

> This feature is activated in version 2.0.0 !

Okay, now it's time to handle the `/start` command in the robot.

First you need to create a class to code your bot. You can use the following command to create a class for the messages that are sent to the bot.

```bash
$ php artisan telegram:command StartMessage --type=Message
```

After you create your command, you need to introduce it to the program, so for this, enter the file `config/telegram.php` and add the address of the created class to it.

```php
'commands' => [
    
    App\Telegram\StartMessage::class,
    // Commands Class

]
```

This class instance is made to handle the bot `/start` message and respond to it.

```php
<?php

namespace App\Telegram;

use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Contracts\Abstract\AbstractTelegramMessage;
use Aliw1382\TelegramTools\Vendor\TelegramUpdate;


class StartMessage extends AbstractTelegramMessage
{

    #[TelegramAttribute( '/start' )]
    public function myMethod( TelegramUpdate $update )
    {

        telegram()->sendMessage( [

            'chat_id' => $update->ChatID(),
            'text'    => 'Hello Welcome To Bot!'

        ] );

    }

}
```

For example, if you want to handle an unknown word, you can use `*` instead. 

for example: We want to handle the word `/help`, but the user might send it `/hel`

```php
<?php

namespace App\Telegram;

use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Contracts\Abstract\AbstractTelegramMessage;
use Aliw1382\TelegramTools\Vendor\TelegramUpdate;


class StartMessage extends AbstractTelegramMessage
{

    #[TelegramAttribute( '/hel*' )]
    public function myMethod( TelegramUpdate $update )
    {

        telegram()->sendMessage( [

            'chat_id' => $update->ChatID(),
            'text'    => 'Help Message ...'

        ] );

    }

}

```

An example for _Callback Query_

```bash
$ php artisan telegram:command CallBackQueryHandler --type=CallbackQuery
```

add new class to `config/telegram.php`

```php
<?php

namespace App\Telegram;

use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Contracts\Abstract\AbstractTelegramCallbackQuery;
use Aliw1382\TelegramTools\Vendor\TelegramUpdate;


class CallBackQueryHandler extends AbstractTelegramCallbackQuery
{

    #[TelegramAttribute( 'mention-*' )]
    public function exampleMethod( TelegramUpdate $update )
    {

        telegram()->editMessageText( [
            
            'chat_id'    => $update->ChatID(),
            'message_id' => $update->MessageID(),
            'text'       => 'You Mention The User <a href="tg://user=' . $update->CallbackDataArray()[ 1 ] . '">' . $update->CallbackDataArray()[ 1 ] . '</a>'
            
        ] );

    }

}
```

if we send data `mention-123456` so we mentioned the user `123456`

# History

Please see [History](history.md) for more information on what has been changed recently.


# Security

If you discover any security related issues, please email aliw1382@gmail.com instead of using the issue tracker.

# License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
