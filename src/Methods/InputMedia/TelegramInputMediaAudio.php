<?php

namespace Aliw1382\TelegramTools\Methods\InputMedia;

use Aliw1382\TelegramTools\TelegramBase;
use Aliw1382\TelegramTools\Contracts\InputMedia;

class TelegramInputMediaAudio extends TelegramBase implements InputMedia
{

    protected string $type = 'audio';

    /**
     * @param string $media
     */
    public function __construct( string $media = '' )
    {
        parent::__construct();
        $this->media( $media );
        $this->payload[ 'type' ] = $this->type;
    }

    /**
     * @param string $media
     * @return TelegramInputMediaAudio
     */
    public static function create( string $media = '' ) : TelegramInputMediaAudio
    {
        return new self( $media );
    }

    /**
     * @param string $media
     * @return $this
     */
    public function media( string $media ) : static
    {
        $this->payload[ 'media' ] = $media;

        return $this;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function caption( string $caption ) : static
    {
        $this->payload[ 'caption' ] = $caption;

        return $this;
    }


}
