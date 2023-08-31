<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Aliw1382\TelegramTools\Contracts\InputMedia;
use Psr\Http\Message\ResponseInterface;

class SendMediaGroup extends TelegramBase implements TelegramSenderContract
{

    /** @var array */
    protected array $media = [];

    /**
     * @return static
     */
    public static function create() : self
    {
        return new self();
    }

    /**
     * @param InputMedia $media
     * @return $this
     * @throws \JsonException
     */
    public function add( InputMedia $media ) : static
    {
        if ( count( $this->media ) < 10 )
        {
            $this->media[] = $media->toArray();
        }

        $this->payload[ 'media' ] = json_encode( $this->media, JSON_THROW_ON_ERROR );

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendMediaGroup( $this->toArray() );
    }

    /**
     * @return array
     */
    public function getMedia() : array
    {
        return $this->media;
    }

}
