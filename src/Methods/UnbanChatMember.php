<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class UnbanChatMember extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string|int $userId
     */
    public function __construct( string | int $userId )
    {
        parent::__construct();
        $this->user( $userId )->onlyIfBanned();
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
     * @param bool $onlyIfBanned
     * @return $this
     */
    public function onlyIfBanned( bool $onlyIfBanned = true ) : static
    {
        $this->payload[ 'only_if_banned' ] = $onlyIfBanned;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->unbanChatMember( $this->toArray() );
    }

}
