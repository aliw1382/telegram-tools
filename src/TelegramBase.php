<?php

namespace Aliw1382\TelegramTools;

use JsonSerializable;
use Aliw1382\TelegramTools\Traits\HasSharedLogic;

/**
 * Class TelegramBase.
 */
abstract class TelegramBase implements JsonSerializable
{
    use HasSharedLogic;

    /**
     * @var Telegram
     */
    protected Telegram $telegram;

    public function __construct()
    {
        $this->telegram = app( Telegram::class );
    }

}
