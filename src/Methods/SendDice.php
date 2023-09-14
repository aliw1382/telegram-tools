<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\Enums\TelegramTypeDice;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class SendDice extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $emoji
     */
    public function __construct( string $emoji )
    {
        parent::__construct();
        $this->emoji( $emoji );
    }

    /**
     * @param TelegramTypeDice|string $dice
     * @return static
     */
    public static function create( TelegramTypeDice | string $dice = TelegramTypeDice::TAS ) : self
    {
        return new self( $dice );
    }

    /**
     * @param string $emoji
     * @return $this
     */
    public function emoji( string $emoji ) : static
    {
        if ( in_array( $emoji, TelegramTypeDice::cases() ) )
            $this->payload[ 'emoji' ] = $emoji;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendDice( $this->toArray() );
    }

}
