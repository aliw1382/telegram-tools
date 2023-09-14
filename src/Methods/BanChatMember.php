<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class BanChatMember extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string|int $userId
     */
    public function __construct( string | int $userId )
    {
        parent::__construct();
        $this->user( $userId )->revokeMessages();
    }

    /**
     * @param string|int $userId
     * @return static
     */
    public static function create( string | int $userId = '' ) : self
    {
        return new self( $userId );
    }

    /**
     * @param string|int $userId
     * @return $this
     */
    public function user( string | int $userId ) : static
    {
        $this->payload[ 'user_id' ] = $userId;

        return $this;
    }

    /**
     * @param bool $revokeMessages
     * @return $this
     */
    public function revokeMessages( bool $revokeMessages = false ) : static
    {
        $this->payload[ 'revoke_messages' ] = $revokeMessages;

        return $this;
    }

    /**
     * @param int $time
     * @return $this
     */
    public function untilDate( int $time ) : static
    {
        $this->payload[ 'until_date' ] = $time;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->banChatMember( $this->toArray() );
    }

}
