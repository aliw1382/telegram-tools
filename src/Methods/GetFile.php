<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class GetFile extends TelegramBase implements TelegramSenderContract
{

    const URL_GET_FILE = 'https://api.telegram.org/file/bot<token>/<file_path>';

    /**
     * @param string $file_id
     */
    public function __construct( string $file_id )
    {
        parent::__construct();
        $this->fileId( $file_id );
    }

    /**
     * @param string $file_id
     * @return static
     */
    public static function create( string $file_id = '' ) : self
    {
        return new self( $file_id );
    }

    /**
     * @param string $fileId
     * @return $this
     */
    public function fileId( string $fileId ) : static
    {
        $this->payload[ 'file_id' ] = $fileId;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->getFile( $this->toArray() );
    }

}
