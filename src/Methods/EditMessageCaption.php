<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Illuminate\Support\Facades\View;
use Psr\Http\Message\ResponseInterface;

class EditMessageCaption extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $caption
     */
    public function __construct( string $caption )
    {
        parent::__construct();
        $this->caption( $caption );
        $this->parseMode();
    }

    /**
     * @param string $caption
     * @return static
     */
    public static function create( string $caption = '' ) : self
    {
        return new self( $caption );
    }

    /**
     * Notification message (Supports Markdown).
     *
     * @return $this
     */
    public function caption( string $caption ) : self
    {
        $this->payload[ 'caption' ] = $caption;

        return $this;
    }

    /**
     * @param int $message_id
     * @return $this
     */
    public function messageId( int $message_id ) : static
    {
        $this->payload[ 'message_id' ] = $message_id;

        return $this;
    }

    /**
     * @param int $inline_message_id
     * @return $this
     */
    public function inlineMessageId( int $inline_message_id ) : static
    {
        $this->payload[ 'inline_message_id' ] = $inline_message_id;

        return $this;
    }


    /**
     * @param string $caption
     * @return $this
     */
    public function addContact( string $caption = '' ) : self
    {
        $this->payload[ 'caption' ] .= $caption;

        return $this;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function doubleLine( string $caption = '' ) : self
    {
        $this->payload[ 'caption' ] .= $caption . "\n \n";

        return $this;
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function escapedLine( string $caption ) : self
    {
        // code taken from public gist https://gist.github.com/vijinho/3d66fab3270fc377b8485387ce7e7455
        $caption = str_replace( [
            '\\', '-', '#', '*', '+', '`', '.', '[', ']', '(', ')', '!', '&', '<', '>', '_', '{', '}', ], [
            '\\\\', '\-', '\#', '\*', '\+', '\`', '\.', '\[', '\]', '\(', '\)', '\!', '\&', '\<', '\>', '\_', '\{', '\}',
        ], $caption );

        return $this->line( $caption );
    }

    /**
     * Attach a view file as the caption for the notification.
     * Supports Laravel blade template.
     *
     * @return $this
     */
    public function view( string $view, array $data = [], array $mergeData = [] ) : self
    {
        return $this->caption( View::make( $view, $data, $mergeData )->render() );
    }

    /**
     * @param string $caption
     * @return $this
     */
    public function line( string $caption = '' ) : self
    {
        $this->payload[ 'caption' ] .= $caption . "\n";

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->editMessageCaption( $this->toArray() );
    }

}
