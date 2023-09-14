<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\Enums\TelegramTypeChatAction;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

class SendChatAction extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param TelegramTypeChatAction $action
     */
    public function __construct( TelegramTypeChatAction $action )
    {
        parent::__construct();
        $this->action( $action );
    }

    /**
     * @param TelegramTypeChatAction $action
     * @return static
     */
    public static function create( TelegramTypeChatAction $action = TelegramTypeChatAction::Typing ) : self
    {
        return new self( $action );
    }

    /**
     * @param TelegramTypeChatAction $action
     * @return $this
     */
    public function action( TelegramTypeChatAction $action ) : static
    {
        $this->payload[ 'action' ] = $action;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendChatAction( $this->toArray() );
    }

}
