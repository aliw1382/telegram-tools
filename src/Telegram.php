<?php

namespace Aliw1382\TelegramTools;

use Aliw1382\TelegramTools\Methods\AnswerCallbackQuery;
use Aliw1382\TelegramTools\Methods\ApproveChatJoinRequest;
use Aliw1382\TelegramTools\Methods\BanChatMember;
use Aliw1382\TelegramTools\Methods\CreateChatInviteLink;
use Aliw1382\TelegramTools\Methods\DeclineChatJoinRequest;
use Aliw1382\TelegramTools\Methods\DeleteMessage;
use Aliw1382\TelegramTools\Methods\EditChatInviteLink;
use Aliw1382\TelegramTools\Methods\EditMessageCaption;
use Aliw1382\TelegramTools\Methods\EditMessageReplyMarkup;
use Aliw1382\TelegramTools\Methods\EditMessageText;
use Aliw1382\TelegramTools\Methods\GetChat;
use Aliw1382\TelegramTools\Methods\GetChatMember;
use Aliw1382\TelegramTools\Methods\GetFile;
use Aliw1382\TelegramTools\Methods\LeaveChat;
use Aliw1382\TelegramTools\Methods\PinChatMessage;
use Aliw1382\TelegramTools\Methods\SendChatAction;
use Aliw1382\TelegramTools\Methods\SendContact;
use Aliw1382\TelegramTools\Methods\CopyMessage;
use Aliw1382\TelegramTools\Methods\SendDice;
use Aliw1382\TelegramTools\Methods\SendFile;
use Aliw1382\TelegramTools\Methods\ForwardMessage;
use Aliw1382\TelegramTools\Methods\SendLocation;
use Aliw1382\TelegramTools\Methods\SendMediaGroup;
use Aliw1382\TelegramTools\Methods\SendMessage;
use Aliw1382\TelegramTools\Methods\SendPoll;
use Aliw1382\TelegramTools\Methods\UnbanChatMember;
use Aliw1382\TelegramTools\Methods\UnpinAllChatMessages;
use Aliw1382\TelegramTools\Methods\UnpinChatMessage;
use Aliw1382\TelegramTools\Vendor\TelegramUrlBot;
use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Str;
use Aliw1382\TelegramTools\Exceptions\CouldNotSendNotification;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Telegram.
 *
 * @method ResponseInterface|null getMe()
 * @method ResponseInterface|null|ForwardMessage forwardMessage( array $params = null )
 * @method ResponseInterface|null|CopyMessage copyMessage( array $params = null )
 * @method ResponseInterface|null|SendMediaGroup sendMediaGroup( array $params = null )
 * @method ResponseInterface|null|SendDice sendDice( array $params = null )
 * @method ResponseInterface|null|SendChatAction sendChatAction( array $params = null )
 * @method ResponseInterface|null|GetFile getFile( array $params = null )
 * @method ResponseInterface|null|BanChatMember banChatMember( array $params = null )
 * @method ResponseInterface|null|SendMessage sendMessage( array $params = null )
 * @method ResponseInterface|null|SendPoll sendPoll( array $params = null )
 * @method ResponseInterface|null|SendContact sendContact( array $params = null )
 * @method ResponseInterface|null|SendLocation sendLocation( array $params = null )
 * @method ResponseInterface|null|UnbanChatMember unbanChatMember( array $params = null )
 * @method ResponseInterface|null|CreateChatInviteLink createChatInviteLink( array $params = null )
 * @method ResponseInterface|null|EditChatInviteLink editChatInviteLink( array $params = null )
 * @method ResponseInterface|null|ApproveChatJoinRequest approveChatJoinRequest( array $params = null )
 * @method ResponseInterface|null|DeclineChatJoinRequest declineChatJoinRequest( array $params = null )
 * @method ResponseInterface|null|PinChatMessage pinChatMessage( array $params = null )
 * @method ResponseInterface|null|UnpinChatMessage unpinChatMessage( array $params = null )
 * @method ResponseInterface|null|UnpinAllChatMessages unpinAllChatMessages( array $params = null )
 * @method ResponseInterface|null|LeaveChat leaveChat( array $params = null )
 * @method ResponseInterface|null|GetChat getChat( array $params = null )
 * @method ResponseInterface|null|GetChatMember getChatMember( array $params = null )
 * @method ResponseInterface|null|EditMessageText editMessageText( array $params = null )
 * @method ResponseInterface|null|EditMessageCaption editMessageCaption( array $params = null )
 * @method ResponseInterface|null|EditMessageReplyMarkup editMessageReplyMarkup( array $params = null )
 * @method ResponseInterface|null|DeleteMessage deleteMessage( array $params = null )
 * @method ResponseInterface|null|AnswerCallbackQuery answerCallbackQuery( array $params = null )
 */
class Telegram
{

    /** @var HttpClient HTTP Client */
    protected HttpClient $http;

    /** @var null|string Telegram Bot API Token. */
    protected ?string $token;

    /** @var string Telegram Bot API Base URI */
    protected string $apiBaseUri;

    /** @var TelegramUrlBot */
    public TelegramUrlBot $url;

    /**
     * @param string|null $token
     * @param HttpClient|null $httpClient
     * @param string|null $apiBaseUri
     */
    public function __construct( string $token = null, HttpClient $httpClient = null, string $apiBaseUri = null )
    {
        $this->token = $token;
        $this->http  = $httpClient ?? new HttpClient();
        $this->setApiBaseUri( $apiBaseUri ?? 'https://api.telegram.org' );
        $this->url = new TelegramUrlBot( $this->token );
    }

    /**
     * Token getter.
     */
    public function getToken() : ?string
    {
        return $this->token;
    }

    /**
     * Token setter.
     *
     * @return $this
     */
    public function setToken( string $token ) : self
    {
        $this->token = $token;
        $this->url->setToken( $token );

        return $this;
    }

    /**
     * API Base URI getter.
     */
    public function getApiBaseUri() : string
    {
        return $this->apiBaseUri;
    }

    /**
     * API Base URI setter.
     *
     * @return $this
     */
    public function setApiBaseUri( string $apiBaseUri ) : self
    {
        $this->apiBaseUri = rtrim( $apiBaseUri, '/' );

        return $this;
    }

    /**
     * Set HTTP Client.
     *
     * @return $this
     */
    public function setHttpClient( HttpClient $http ) : self
    {
        $this->http = $http;

        return $this;
    }

    /**
     * Send File as Image or Document.
     *
     * @param array|null $params
     * @param string|null $type
     * @param bool $multipart
     * @return SendFile|ResponseInterface|null
     *
     * @throws CouldNotSendNotification
     */
    public function sendFile( array $params = null, string $type = null, bool $multipart = false ) : SendFile | ResponseInterface | null
    {
        return is_null( $params ) ? SendFile::create() : $this->sendRequest( 'send' . Str::studly( $type ), $params, $multipart );
    }

    /**
     * Get updates.
     *
     * @param array $params
     * @return ResponseInterface|null
     *
     * @throws CouldNotSendNotification
     */
    public function getUpdates( array $params ) : ?ResponseInterface
    {
        return $this->sendRequest( __FUNCTION__, $params );
    }

    /**
     * Get HttpClient.
     */
    protected function httpClient() : HttpClient
    {
        return $this->http;
    }

    /**
     * Send an API request and return response.
     *
     * @param string $endpoint
     * @param array $params
     * @param bool $multipart
     * @return ResponseInterface|null
     *
     * @throws CouldNotSendNotification
     */
    protected function sendRequest( string $endpoint, array $params, bool $multipart = false ) : ?ResponseInterface
    {
        if ( blank( $this->token ) )
        {
            throw CouldNotSendNotification::telegramBotTokenNotProvided( 'You must provide your telegram bot token to make any API requests.' );
        }

        $apiUri = sprintf( '%s/bot%s/%s', $this->apiBaseUri, $this->token, $endpoint );

        try
        {
            return $this->httpClient()->post( $apiUri, [
                $multipart ? 'multipart' : 'form_params' => $params,
            ] );
        }
        catch ( ClientException $exception )
        {
            throw CouldNotSendNotification::telegramRespondedWithAnError( $exception );
        }
        catch ( Exception $exception )
        {
            throw CouldNotSendNotification::couldNotCommunicateWithTelegram( $exception );
        }

    }

    /**
     * @param string $name
     * @param array|null $arguments
     * @return ResponseInterface|null
     * @throws CouldNotSendNotification
     */
    public function __call( string $name, array $arguments = null )
    {
        $class = str( $name )->studly()->prepend( __NAMESPACE__ . "\\Methods\\" )->toString();
        return ! isset( $arguments[ 0 ] ) && class_exists( $class )
            ? app()->call( [ $class, 'create' ] )->token( $this->token )
            : $this->sendRequest( $name, ( $arguments[ 0 ] ?? [] ) );
    }

}
