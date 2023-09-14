<?php

namespace Aliw1382\TelegramTools\Traits;

use Aliw1382\TelegramTools\Enums\TelegramTypeMessage;
use Aliw1382\TelegramTools\Telegram;
use Aliw1382\TelegramTools\TelegramBase;
use Illuminate\Support\Traits\Conditionable;

/**
 * Trait HasSharedLogic.
 */
trait HasSharedLogic
{

    use Conditionable;

    /** @var null|string Bot Token. */
    public ?string $token = null;

    /** @var array Params payload. */
    protected array $payload = [];

    /** @var array Inline Keyboard Buttons. */
    protected array $buttons = [];

    /**
     * Recipient's Chat ID.
     *
     * @param int|string $chatId
     * @return HasSharedLogic|TelegramBase
     */
    public function to( int | string $chatId ) : self
    {
        $this->payload[ 'chat_id' ] = $chatId;

        return $this;
    }

    /**
     * @param int|string $chatId
     * @return HasSharedLogic|TelegramBase
     */
    public function thread( int | string $chatId ) : self
    {
        $this->payload[ 'message_thread_id' ] = $chatId;

        return $this;
    }

    /**
     * Add an inline button.
     *
     * @param string $text
     * @param string|null $url
     * @param int $columns
     * @return HasSharedLogic|TelegramBase
     *
     * @throws \JsonException
     */
    public function button( string $text, string $url = null, int $columns = 2 ) : self
    {
        $this->buttons[] = compact( 'text', 'url' );

        $this->payload[ 'reply_markup' ] = json_encode( [
            is_null( $url ) ? 'keyboard' : 'inline_keyboard' => array_chunk( $this->buttons, $columns ),
        ], JSON_THROW_ON_ERROR );

        return $this;
    }

    /**
     * Add an inline button with callback_data.
     *
     * @param string $text
     * @param string $callback_data
     * @param int $columns
     * @return static
     *
     * @throws \JsonException
     */
    public function buttonWithCallback( string $text, string $callback_data, int $columns = 2 ) : self
    {
        $this->buttons[] = compact( 'text', 'callback_data' );

        $this->payload[ 'reply_markup' ] = json_encode( [
            'inline_keyboard' => array_chunk( $this->buttons, $columns ),
        ], JSON_THROW_ON_ERROR );

        return $this;
    }

    /**
     * Send the message silently.
     * Users will receive a notification with no sound.
     *
     * @param bool $disableNotification
     * @return static
     */
    public function disableNotification( bool $disableNotification = true ) : self
    {
        $this->payload[ 'disable_notification' ] = $disableNotification;

        return $this;
    }

    /**
     * @param TelegramTypeMessage|string $typeMessage
     * @return HasSharedLogic|TelegramBase
     */
    public function parseMode( TelegramTypeMessage | string $typeMessage = TelegramTypeMessage::Markdown ) : self
    {
        $this->payload[ 'parse_mode' ] = $typeMessage;

        return $this;
    }

    /**
     * @param bool $allowSendingWithoutReply
     * @return HasSharedLogic|TelegramBase
     */
    public function allowSendingWithoutReply( bool $allowSendingWithoutReply = true ) : self
    {
        $this->payload[ 'allow_sending_without_reply' ] = $allowSendingWithoutReply;

        return $this;
    }

    /**
     * @param bool $disableWebPagePreview
     * @return HasSharedLogic|TelegramBase
     */
    public function disableWebPagePreview( bool $disableWebPagePreview = true ) : self
    {
        $this->payload[ 'disable_web_page_preview' ] = $disableWebPagePreview;

        return $this;
    }

    /**
     * @param bool $protectContent
     * @return HasSharedLogic|TelegramBase
     */
    public function protectContent( bool $protectContent = false ) : self
    {
        $this->payload[ 'protect_content' ] = $protectContent;

        return $this;
    }

    /**
     * Bot Token.
     * Overrides default bot token with the given value for this notification.
     *
     * @param string $token
     * @return HasSharedLogic|TelegramBase
     */
    public function token( string $token ) : self
    {
        $this->token = $token;
        $this->telegram->setToken( $token );

        return $this;
    }

    /**
     * Determine if bot token is given for this notification.
     */
    public function hasToken() : bool
    {
        return null !== $this->token;
    }

    /**
     * Additional options to pass to sendMessage method.
     *
     * @param array $options
     * @return static
     */
    public function options( array $options ) : self
    {
        $this->payload = array_merge( $this->payload, $options );

        return $this;
    }

    /**
     * Determine if chat id is not given.
     */
    public function toNotGiven() : bool
    {
        return ! isset( $this->payload[ 'chat_id' ] );
    }

    /**
     * Get payload value for given key.
     *
     * @return null|mixed
     */
    public function getPayloadValue( string $key ) : mixed
    {
        return $this->payload[ $key ] ?? null;
    }

    /**
     * Returns params payload.
     */
    public function toArray() : array
    {
        return $this->payload;
    }

    /**
     * Convert the object into something JSON serializable.
     */
    public function jsonSerialize() : array
    {
        return $this->toArray();
    }
}
