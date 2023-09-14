<?php

namespace Aliw1382\TelegramTools\Contracts\Interface;

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
