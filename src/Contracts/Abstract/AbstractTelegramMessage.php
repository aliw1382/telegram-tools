<?php

namespace Aliw1382\TelegramTools\Contracts\Abstract;


use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Contracts\Interface\InterfaceTelegramType;

#[TelegramAttribute( 'Text' )]
abstract class AbstractTelegramMessage implements InterfaceTelegramType
{

    public function __construct()
    {
    }

}
