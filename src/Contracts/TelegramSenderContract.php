<?php

namespace Aliw1382\TelegramTools\Contracts;

use Aliw1382\TelegramTools\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

interface TelegramSenderContract
{

    /**
     * Send the message.
     *
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null;

}
