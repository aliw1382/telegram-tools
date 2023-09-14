<?php

namespace Aliw1382\TelegramTools\Methods\InputMedia;

use Aliw1382\TelegramTools\Contracts\Interface\InputMedia;
use Aliw1382\TelegramTools\TelegramBase;

class TelegramInputMediaDocument extends TelegramBase implements InputMedia
{

    protected string $type = 'document';

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


}
