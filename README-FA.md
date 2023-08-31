
<p align="center"><img width="400" src="https://github.com/aliw1382/telegram-tools/assets/22743719/f7c7bef0-3b39-4f5a-868d-cc8d54410a67" alt="Laravel Telegram Tools"></p>

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

<div dir="rtl">

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

<h3 align="center">✨ امیدوارم از این پکیج لذت ببرید ✨</h2>

# امنیت
در صورتی که مشکل امنیتی در پکیج پیدا کردید به منظور رفع مشکل با ایمیل aliw1382@gmail.com در ارتباط باشید.

# لایسنس
لایسنس از MIT می باشد.
برای اطلاعات به بیشتر فایل
[لایسنس](LICENSE)
مراجعه کنید. 

</div>
