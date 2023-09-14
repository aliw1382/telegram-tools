<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class AnswerCallbackQuery extends TelegramBase implements TelegramSenderContract
{

    public function __construct( string $callback_query_id )
    {
        parent::__construct();
        $this->callbackQueryId( $callback_query_id );
    }

    public static function create( string $callback_query_id = '' ) : self
    {
        return new self( $callback_query_id );
    }

    public function callbackQueryId( string $callback_query_id ) : static
    {
        $this->payload[ 'callback_query_id' ] = $callback_query_id;

        return $this;
    }

    /**
     * @param int $cache_time
     * @return $this
     */
    public function cacheTime( int $cache_time ): static
    {
        $this->payload[ 'cache_time' ] = $cache_time;

        return $this;
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
     * @param string $content
     * @return $this
     */
    public function line( string $content = '' ) : self
    {
        $this->payload[ 'text' ] .= $content . "\n";

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
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->answerCallbackQuery( $this->toArray() );
    }

}
