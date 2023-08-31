<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\TelegramSenderContract;
use Aliw1382\TelegramTools\Exceptions\CouldNotSendNotification;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TelegramPoll.
 */
class SendPoll extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $question
     */
    public function __construct( string $question )
    {
        parent::__construct();
        $this->question( $question );
    }

    /**
     * @param string $question
     * @return static
     */
    public static function create( string $question = '' ) : self
    {
        return new self( $question );
    }

    /**
     * Poll question.
     *
     * @return $this
     */
    public function question( string $question ) : self
    {
        $this->payload[ 'question' ] = $question;

        return $this;
    }

    /**
     * Poll choices.
     *
     * @return $this
     * @throws \JsonException
     */
    public function choices( array $choices ) : self
    {
        $this->payload[ 'options' ] = json_encode( $choices, JSON_THROW_ON_ERROR );

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendPoll( $this->toArray() );
    }

}
