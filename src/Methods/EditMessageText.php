<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Illuminate\Support\Facades\View;
use Psr\Http\Message\ResponseInterface;

class EditMessageText extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $content
     */
    public function __construct( string $content )
    {
        parent::__construct();
        $this->content( $content );
        $this->parseMode();
    }

    /**
     * @param string $content
     * @return static
     */
    public static function create( string $content = '' ) : self
    {
        return new self( $content );
    }

    /**
     * Notification message (Supports Markdown).
     *
     * @return $this
     */
    public function content( string $content ) : self
    {
        $this->payload[ 'text' ] = $content;

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
     * @param string $content
     * @return $this
     */
    public function addContact( string $content = '' ) : self
    {
        $this->payload[ 'text' ] .= $content;

        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function doubleLine( string $content = '' ) : self
    {
        $this->payload[ 'text' ] .= $content . "\n \n";

        return $this;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function escapedLine( string $content ) : self
    {
        // code taken from public gist https://gist.github.com/vijinho/3d66fab3270fc377b8485387ce7e7455
        $content = str_replace( [
            '\\', '-', '#', '*', '+', '`', '.', '[', ']', '(', ')', '!', '&', '<', '>', '_', '{', '}', ], [
            '\\\\', '\-', '\#', '\*', '\+', '\`', '\.', '\[', '\]', '\(', '\)', '\!', '\&', '\<', '\>', '\_', '\{', '\}',
        ], $content );

        return $this->line( $content );
    }

    /**
     * Attach a view file as the content for the notification.
     * Supports Laravel blade template.
     *
     * @return $this
     */
    public function view( string $view, array $data = [], array $mergeData = [] ) : self
    {
        return $this->content( View::make( $view, $data, $mergeData )->render() );
    }

    /**
     * @param string $content
     * @return $this
     */
    public function line( string $content = '' ) : self
    {
        $this->payload[ 'text' ] .= $content . "\n";

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->editMessageText( $this->toArray() );
    }

}
