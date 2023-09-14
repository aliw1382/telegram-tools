<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class ForwardMessage extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param int|string $from_chat_id
     * @param int $message_id
     */
    public function __construct( int | string $from_chat_id, int $message_id )
    {
        parent::__construct();
        $this->fromChatId( $from_chat_id )->messageId( $message_id );
    }

    /**
     * @param int|string $from_chat_id
     * @param int $message_id
     * @return ForwardMessage
     */
    public static function create( int $message_id = 0, int | string $from_chat_id = '' ) : ForwardMessage
    {
        return new self( $from_chat_id, $message_id );
    }

    /**
     * @param int|string $from_chat_id
     * @return $this
     */
    public function fromChatId( int | string $from_chat_id ) : static
    {
        $this->payload[ 'from_chat_id' ] = $from_chat_id;

        return $this;
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
        return $this->telegram->forwardMessage( $this->toArray() );
    }

}
