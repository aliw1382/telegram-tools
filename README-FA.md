
<p align="center"><img src="https://github.com/aliw1382/telegram-tools/assets/22743719/f7c7bef0-3b39-4f5a-868d-cc8d54410a67" alt="Laravel Telegram Tools"></p>

[Document English](README.md)

<div dir="rtl">

# درباره پکیج

> این پکیج در نسخه تستی خود می باشد امکان دارد دارای مشکلاتی باشد!

<p>این پکیج برای این ساخته شده است تا افرادی که ساخت ربات تلگرام انجام میدهند بتوانند به اسانی و سرعت بیشتر کد نویسی ربات خود را انجام بدهند.</p>
<p>این پکیج توسط علی شاه محمدی توسعه و طراحی شده است.</p>

# الزامات

<div dir="ltr">

* guzzlehttp/guzzle ^7.*
* illuminate/support ~5.8.0|^6.0|^7.0|^8.0|^9.0|^10.0
* php >= 7.4
</div>

# نصب و راه اندازی✨

<p>جهت نصب و دریافت پکیج در پروژه لاراول خود دستور زیر را در ترمینال مسیر پروژه خود اجرا کنید.</p>

<div dir="ltr">

```bash
$ composer require aliw1382/telegram-tools
```
</div>

# فعال سازی

فایل `config/app.php` باز کرده و مقادیر داده شده را اضافه کنید.

<div dir="ltr">

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
</div>



# تنظیمات

<div dir="ltr">

```bash
$ php artisan vendor:publish --tag=config-telegram-tools
```
</div>

سپس فایل `config/telegram.php` ساخته می شود.

<div dir="ltr">

```php
'telegram-bot-api' => [

    'token' => env( 'TELEGRAM_API_TOKEN' )
    
]
```
</div>

# فایل .Env

این را فایل `.env` اضافه کرده و توکن دریافت شده از **بات فادر** را در اینجا قرار دهید.

<div dir="ltr">

```dotenv
TELEGRAM_API_TOKEN=
```
</div>


# نحوه استفاده

* روش اول:

<div dir="ltr">

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
</div>

> اگر `telegram()` استفاده کنید از توکن پیشفرض در فایل `.env` استفاده می کند.

* روش دوم:

<div dir="ltr">

```php
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->send();

telegram( 'Your Other Token Bot' )->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->send();
```
</div>

به عنوان مثال از میخواهید `SendMessage` با ارسال کیبورد و حالت تجزیه ارسال کنید:
<div dir="ltr">

```php
// Keyboard
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->parseMode( 'html' )->button( 'Button 1' )->button( 'Button 2' )->send();

// Inline Keyboard
telegram()->sendMessage()->to( 'YOUR CHAT ID' )->content( 'YOUR CONTENT TEXT' )->parseMode( 'MarkdownV2' )->button( 'Google' , 'https://google.com' )->buttonWithCallback( 'Button 1' , 'Your Callback Data' )->send();
```
</div>

* روش سوم:

<div dir="ltr">

```php
\Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT' );
```
</div>
یا
<div dir="ltr">

```php
use Aliw1382\TelegramTools\Facades\Telegram;

Telegram::sendMessage( 'YOUR CHAT ID', 'YOUR CONTENT TEXT' );
```
</div>

به عنوان مثال از میخواهید `SendMessage` با ارسال کیبورد و حالت تجزیه ارسال کنید:

<div dir="ltr">

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
</div>

<p align="center">✨ امیدوارم از این پکیج لذت ببرید ✨</p>

# برنامه نویسی سورس کد

>این قابلیت در ورژن ۲ فعال سازی شده است!

بسیار خوب حالا زمان هدل کردن دستور /start در ربات است.

نخست نیاز دارید یک کلاس برای کد نویسی ربات خود ایجاد کنید. شما میتوانید با استفاده از دستور زیر یک کلاس برای پیام هایی که در ربات ارسال می شود استفاده کنید.

<div dir="ltr">

```bash
$ php artisan telegram:command StartMessage --type=Message
```

</div>

بعد از اینکه دستور خود را ایجاد کردید نیاز است که آن را به برنامه معرفی کنید لذا برای این کار وارد فایل `config/telegram.php` شوید و آدرس کلاس ساخته شده را به آن اضافه کنید.

<div dir="ltr">

```php
'commands' => [
    
    App\Telegram\StartMessage::class,
    // Commands Class

]
```

این نمونه کلاس ساخته شده است برای پاسخ به پیام `/start` ربات.

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
            'text'    => '!سلام خوش اومدید به ربات'

        ] );

    }

}
```

اگر شما به عنوان مثال میخواستید از یک کلمه غیر مشخص را هندل کنید میتوانید به جای آن از `*` استفاده کنید.

به عنوان مثال برای _Callback Query_

```bash
$ php artisan telegram:command CallBackQueryHandler --type=CallbackQuery
```

کلاس جدید را به فایل `config/telegram.php` اضافه میکنیم.

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
            'text'       => 'شما کاربر  <a href="tg://user=' . $update->CallbackDataArray()[ 1 ] . '">' . $update->CallbackDataArray()[ 1 ] . '</a>' . ' را منشن کردید.'
            
        ] );

    }

}
```

اگر ما داده `mention-123456` را ارسال کنیم سپس کاربر `123456` منشن می شود.

</div>

# تاریخچه

لطفاً برای اطلاعات بیشتر در مورد آنچه اخیراً تغییر کرده است به [تاریخچه](history.md) مراجعه کنید.

# امنیت
در صورتی که مشکل امنیتی در پکیج پیدا کردید به منظور رفع مشکل با ایمیل aliw1382@gmail.com در ارتباط باشید.

# لایسنس
لایسنس از MIT می باشد.
برای اطلاعات به بیشتر فایل
[لایسنس](LICENSE)
مراجعه کنید. 

</div>
