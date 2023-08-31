<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class EditChatInviteLink extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $inviteLink
     */
    public function __construct( string $inviteLink )
    {
        parent::__construct();
        $this->inviteLink( $inviteLink );
    }

    /**
     * @param string $inviteLink
     * @return static
     */
    public static function create( string $inviteLink = '' ) : self
    {
        return new self( $inviteLink );
    }

    /**
     * @param string $inviteLink
     * @return $this
     */
    public function inviteLink( string $inviteLink ) : static
    {
        $this->payload[ 'invite_link' ] = $inviteLink;

        return $this;
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
        return $this->telegram->editChatInviteLink( $this->toArray() );
    }

}
