<?php

namespace Aliw1382\TelegramTools\Contracts\Abstract;

use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Contracts\Interface\InterfaceTelegramType;

#[TelegramAttribute( 'CallbackData' )]
abstract class AbstractTelegramCallbackQuery implements InterfaceTelegramType
{

    public function __construct()
    {
    }

}
