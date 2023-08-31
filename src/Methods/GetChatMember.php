<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class GetChatMember extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param int|string $user_id
     */
    public function __construct( int | string $user_id )
    {
        parent::__construct();
        $this->user( $user_id );
    }

    /**
     * @param int|string $user_id
     * @return static
     */
    public static function create( int | string $user_id = '' ) : self
    {
        return new self( $user_id );
    }

    /**
     * @param int|string $user_id
     * @return $this
     */
    public function user( int | string $user_id ) : static
    {
        $this->payload[ 'user_id' ] = $user_id;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->getChatMember( $this->toArray() );
    }

}
