<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class PinChatMessage extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param int $message_id
     */
    public function __construct( int $message_id = 0 )
    {
        parent::__construct();
        $this->messageId( $message_id );
    }

    /**
     * @param int $message_id
     * @return static
     */
    public static function create( int $message_id = 0 ) : self
    {
        return new self( $message_id );
    }

    /**
     * @param int $message_id
     * @return $this
     */
    public function messageId( int $message_id ) : static
    {
        $this->payload[ 'message_id' ] = $message_id;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->pinChatMessage( $this->toArray() );
    }

}
