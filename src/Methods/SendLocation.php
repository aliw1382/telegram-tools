<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TelegramLocation.
 */
class SendLocation extends TelegramBase implements TelegramSenderContract
{

    /**
     * Telegram Location constructor.
     *
     * @param float|string $latitude
     * @param float|string $longitude
     */
    public function __construct( float | string $latitude, float | string $longitude )
    {
        parent::__construct();
        $this->latitude( $latitude )->longitude( $longitude );
    }

    /**
     * @param float|string $latitude
     * @param float|string $longitude
     * @return self
     */
    public static function create( float | string $latitude = '', float | string $longitude = '' ) : self
    {
        return new self( $latitude, $longitude );
    }

    /**
     * Location's latitude.
     *
     * @param float|string $latitude
     * @return $this
     */
    public function latitude( float | string $latitude ) : self
    {
        $this->payload[ 'latitude' ] = $latitude;

        return $this;
    }

    /**
     * Location's longitude.
     *
     * @param float|string $longitude
     * @return $this
     */
    public function longitude( float | string $longitude ) : self
    {
        $this->payload[ 'longitude' ] = $longitude;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendLocation( $this->toArray() );
    }

}
