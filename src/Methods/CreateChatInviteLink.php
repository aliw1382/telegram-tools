<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class CreateChatInviteLink extends TelegramBase implements TelegramSenderContract
{

    /**
     * @return static
     */
    public static function create() : self
    {
        return new self();
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name( string $name ) : static
    {
        $this->payload[ 'name' ] = $name;

        return $this;
    }

    /**
     * @param int $expireDate
     * @return $this
     */
    public function expireDate( int $expireDate ) : static
    {
        $this->payload[ 'expire_date' ] = $expireDate;

        return $this;
    }

    /**
     * @param int $memberLimit
     * @return $this
     */
    public function memberLimit( int $memberLimit ) : static
    {
        $this->payload[ 'member_limit' ] = $memberLimit;

        return $this;
    }

    /**
     * @param bool $createsJoinRequest
     * @return $this
     */
    public function createsJoinRequest( bool $createsJoinRequest ) : static
    {
        $this->payload[ 'creates_join_request' ] = $createsJoinRequest;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->createChatInviteLink( $this->toArray() );
    }

}
