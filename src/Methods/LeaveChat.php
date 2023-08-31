<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class LeaveChat extends TelegramBase implements TelegramSenderContract
{

    public function __construct()
    {
        parent::__construct();
    }

    public static function create() : self
    {
        // TODO: Implement create() method.
        return new self();
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->leaveChat( $this->toArray() );
    }

}
