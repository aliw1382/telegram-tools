<?php

namespace Aliw1382\TelegramTools\Methods\InputMedia;

use Aliw1382\TelegramTools\TelegramBase;
use Aliw1382\TelegramTools\Contracts\InputMedia;

class TelegramInputMediaVideo extends TelegramBase implements InputMedia
{

    /** @var string */
    protected string $type = 'video';

    /**
     * @param string $media
     */
    public function __construct( string $media = '' )
    {
        parent::__construct();
        $this->media( $media );
        $this->supportsStreaming();
        $this->payload[ 'type' ] = $this->type;
    }

    /**
     * @param string $media
     * @return $this
     */
    public static function create( string $media = '' ) : static
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

    /**
     * @param int $width
     * @return $this
     */
    public function width( int $width ) : static
    {
        $this->payload[ 'width' ] = $width;

        return $this;
    }

    /**
     * @param int $height
     * @return $this
     */
    public function height( int $height ) : static
    {
        $this->payload[ 'height' ] = $height;

        return $this;
    }

    /**
     * @param bool $supportsStreaming
     * @return $this
     */
    public function supportsStreaming( bool $supportsStreaming = true ) : static
    {
        $this->payload[ 'supports_streaming' ] = $supportsStreaming;

        return $this;
    }

    /**
     * @param bool $hasSpoiler
     * @return $this
     */
    public function hasSpoiler( bool $hasSpoiler = true ) : static
    {
        $this->payload[ 'has_spoiler' ] = $hasSpoiler;

        return $this;
    }


}
