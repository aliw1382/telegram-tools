<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class EditMessageReplyMarkup extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param int $message_id
     */
    public function __construct( int $message_id )
    {
        parent::__construct();
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
     * @param int $inline_message_id
     * @return $this
     */
    public function inlineMessageId( int $inline_message_id ) : static
    {
        $this->payload[ 'inline_message_id' ] = $inline_message_id;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->editMessageReplyMarkup( $this->toArray() );
    }

}
