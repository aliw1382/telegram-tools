<?php

namespace Aliw1382\TelegramTools\Vendor;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramContracts;
use Aliw1382\TelegramTools\Enums\TelegramTypeChatAction;
use Aliw1382\TelegramTools\Enums\TelegramTypeMessage;

class TelegramManager implements TelegramContracts
{

    /** @var string */
    protected string $url_api = 'https://api.telegram.org/bot<token>/';

    /** @var string|\Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|mixed|null */
    protected ?string $TOKEN;

    /**
     * @param string|null $token
     * @throws \Exception
     */
    public function __construct( ?string $token = null )
    {
        $this->TOKEN = $token ?? config( 'telegram.telegram-bot-api.token' );
    }

    /**
     * @param string $mode
     * @return string
     */
    private function checkMode( string $mode ) : string
    {
        return in_array( $mode, TelegramTypeMessage::cases() ) ? $mode : TelegramTypeMessage::HTML;
    }

    /**
     * @param string $action
     * @return string
     * @throws \Exception
     */
    private function checkAction( string $action ) : string
    {
        if ( in_array( $action, TelegramTypeChatAction::cases() ) ) return $action;
        throw new \Exception( "You Can't Use Action " . $action . ' On Method ' . __METHOD__ );
    }

    /**
     * @param string $api
     * @param array $content
     * @param bool $post
     * @return array
     */
    public function endpoint( string $api, array $content, bool $post = true ) : array
    {
        $url = str( $this->url_api )->replace( '<token>', $this->TOKEN )->append( $api );
        if ( $post )
        {
            $reply = $this->sendAPIRequest( $url, $content );
        }
        else
        {
            $reply = $this->sendAPIRequest( $url, array(), false );
        }
        return json_decode( $reply, true );
    }

    /**
     * @param $url
     * @param array $content
     * @param bool $post
     * @return mixed
     */
    private function sendAPIRequest( $url, array $content, bool $post = true ) : mixed
    {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        if ( $post )
        {
            curl_setopt( $ch, CURLOPT_POST, 1 );
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $content );
        }
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        $result = curl_exec( $ch );
        curl_close( $ch );
        return json( $result );
    }

    /**
     * @param int $user_id
     * @param string $text
     * @param string|null $keyboard
     * @param string $mode
     * @param array $more
     * @return array
     */
    public function sendMessage( int $user_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendMessage', array_merge( [

                'chat_id'                  => $user_id,
                'text'                     => $text,
                'parse_mode'               => $this->checkMode( $mode ),
                'reply_markup'             => $keyboard,
                'disable_web_page_preview' => true,

            ], $more )
        );
    }

    /**
     * @param array $data
     * @param array|null $extras
     * @return array
     */
    public function supperSendMessage( array $data, ?array &$extras = [] ) : array
    {
        $extras = array_merge( [
            'split'    => 4096,
            'encoding' => mb_internal_encoding(),
        ], (array) $extras );

        $text       = $data[ 'text' ];
        $encoding   = $extras[ 'encoding' ];
        $max_length = $extras[ 'split' ] ?: mb_strlen( $text, $encoding );

        $responses = [];

        do
        {
            // Chop off and send the first message.
            $data[ 'text' ] = mb_substr( $text, 0, $max_length, $encoding );
            $responses[]    = $this->endpoint( 'sendMessage', $data );

            // Prepare the next message.
            $text = mb_substr( $text, $max_length, null, $encoding );
        } while ( $text !== '' );

        // Add all response objects to referenced variable.
        $extras[ 'responses' ] = $responses;

        return end( $responses );
    }

    /**
     * @param int $to_user_id
     * @param int $chat_id
     * @param int $message_id
     * @param array $more
     * @return array
     */
    public function forwardMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] ) : array
    {
        return $this->endpoint(
            'forwardMessage', array_merge( [

                'chat_id'      => $to_user_id,
                'from_chat_id' => $chat_id,
                'message_id'   => $message_id,

            ], $more )
        );
    }

    /**
     * @param int $to_user_id
     * @param int $chat_id
     * @param int $message_id
     * @param array $more
     * @return array
     */
    public function copyMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] ) : array
    {
        return $this->endpoint(
            'copyMessage', array_merge( [

                'chat_id'      => $to_user_id,
                'from_chat_id' => $chat_id,
                'message_id'   => $message_id,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string|null $caption
     * @param string|null $keyboard
     * @param string $mode
     * @param array $more
     * @return array
     */
    public function sendPhoto( int $user_id, string $file_id_or_address_file, string $caption = null, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendPhoto', array_merge( [

                'chat_id'      => $user_id,
                'photo'        => $file_id_or_address_file,
                'caption'      => $caption,
                'reply_markup' => $keyboard,
                'parse_mode'   => $mode,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string $caption
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendAudio( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendAudio', array_merge( [

                'chat_id'      => $user_id,
                'audio'        => $file_id_or_address_file,
                'caption'      => $caption,
                'reply_markup' => $keyboard

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string $caption
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendDocument( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendDocument', array_merge( [

                'chat_id'      => $user_id,
                'document'     => $file_id_or_address_file,
                'caption'      => $caption,
                'reply_markup' => $keyboard

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string $caption
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendVideo( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendVideo', array_merge( [

                'chat_id' => $user_id,
                'video'   => $file_id_or_address_file,
                'caption' => $caption,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string $caption
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendVoice( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendVoice', array_merge( [

                'chat_id'      => $user_id,
                'voice'        => $file_id_or_address_file,
                'caption'      => $caption,
                'reply_markup' => $keyboard

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $file_id_or_address_file
     * @param string $caption
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendVideoNote( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendVideoNote', array_merge( [

                'chat_id'      => $user_id,
                'video_note'   => $file_id_or_address_file,
                'caption'      => $caption,
                'reply_markup' => $keyboard

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param array $media
     * @param array $more
     * @return array
     */
    public function sendMediaGroup( int $user_id, array $media, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendMediaGroup', array_merge( [

                'chat_id' => $user_id,
                'media'   => json_encode( $media ),

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param float $lat
     * @param float $long
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendLocation( int $user_id, float $lat, float $long, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendLocation', array_merge( [

                'chat_id'      => $user_id,
                'latitude'     => $lat,
                'longitude'    => $long,
                'reply_markup' => $keyboard,

            ], $more )
        );
    }

    /**
     * @param float $lat
     * @param float $long
     * @param array $more
     * @return array
     */
    public function editMessageLiveLocation( float $lat, float $long, array $more = [] ) : array
    {
        return $this->endpoint(
            'editMessageLiveLocation', array_merge( [

                'latitude'  => $lat,
                'longitude' => $long,

            ], $more )
        );
    }

    /**
     * @param array $more
     * @return array
     */
    public function stopMessageLiveLocation( array $more ) : array
    {
        return $this->endpoint( 'stopMessageLiveLocation', $more );
    }

    /**
     * @param int $user_id
     * @param string $phone_number
     * @param string $first_name
     * @param array $more
     * @return array
     */
    public function sendContact( int $user_id, string $phone_number, string $first_name, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendContact', array_merge( [

                'chat_id'      => $user_id,
                'phone_number' => $phone_number,
                'first_name'   => $first_name,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $question
     * @param array $options
     * @param bool $is_anonymous
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendPoll( int $user_id, string $question, array $options, bool $is_anonymous = true, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendPoll', array_merge( [

                'chat_id'      => $user_id,
                'question'     => $question,
                'options'      => json_encode( $options ),
                'is_anonymous' => $is_anonymous,
                'reply_markup' => $keyboard,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $emoji
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function sendDice( int $user_id, string $emoji, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendDice', array_merge( [

                'chat_id'      => $user_id,
                'emoji'        => $emoji,
                'reply_markup' => $keyboard,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param string $action
     * @return array
     * @throws \Exception
     */
    public function sendChatAction( int $user_id, string $action ) : array
    {
        return $this->endpoint( 'sendChatAction', [

            'chat_id' => $user_id,
            'action'  => $this->checkAction( $action ),

        ] );
    }

    /**
     * @param int $user_id
     * @param array $more
     * @return array
     */
    public function getUserProfilePhotos( int $user_id, array $more = [] ) : array
    {
        return $this->endpoint(
            'sendChatAction', array_merge( [

                'user_id' => $user_id,

            ], $more )
        );
    }

    /**
     * @param string $file_id
     * @return array
     */
    public function getFile( string $file_id ) : array
    {
        return $this->endpoint( 'getFile', [

            'file_id' => $file_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @param array $more
     * @return array
     */
    public function banChatMember( int $chat_id, int $user_id, array $more = [] ) : array
    {
        return $this->endpoint(
            'banChatMember', array_merge( [

                'chat_id' => $chat_id,
                'user_id' => $user_id,

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @param bool $only_if_banned
     * @return array
     */
    public function unbanChatMember( int $chat_id, int $user_id, bool $only_if_banned = true ) : array
    {
        return $this->endpoint( 'unbanChatMember', [

            'chat_id'        => $chat_id,
            'user_id'        => $user_id,
            'only_if_banned' => $only_if_banned

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @param string $title
     * @return array
     */
    public function setChatAdministratorCustomTitle( int $chat_id, int $user_id, string $title ) : array
    {
        return $this->endpoint( 'setChatAdministratorCustomTitle', [

            'chat_id'      => $chat_id,
            'user_id'      => $user_id,
            'custom_title' => $title

        ] );
    }

    /**
     * @param int $user_id
     * @param int $sender_chat_id
     * @return array
     */
    public function banChatSenderChat( int $user_id, int $sender_chat_id ) : array
    {
        return $this->endpoint( 'banChatSenderChat', [

            'chat_id'        => $user_id,
            'sender_chat_id' => $sender_chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @return array
     */
    public function approveChatJoinRequest( int $chat_id, int $user_id ) : array
    {
        return $this->endpoint( 'approveChatJoinRequest', [

            'chat_id' => $chat_id,
            'user_id' => $user_id

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @return array
     */
    public function declineChatJoinRequest( int $chat_id, int $user_id ) : array
    {
        return $this->endpoint( 'declineChatJoinRequest', [

            'chat_id' => $chat_id,
            'user_id' => $user_id

        ] );
    }

    /**
     * @param int $chat_id
     * @param string $photo_id
     * @return array
     */
    public function setChatPhoto( int $chat_id, string $photo_id ) : array
    {
        return $this->endpoint( 'setChatPhoto', [

            'chat_id' => $chat_id,
            'photo'   => $photo_id

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function deleteChatPhoto( int $chat_id ) : array
    {
        return $this->endpoint( 'deleteChatPhoto', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @param string $title
     * @return array
     */
    public function setChatTitle( int $chat_id, string $title ) : array
    {
        return $this->endpoint( 'setChatTitle', [

            'chat_id' => $chat_id,
            'title'   => $title

        ] );
    }

    /**
     * @param int $chat_id
     * @param string $description
     * @return array
     */
    public function setChatDescription( int $chat_id, string $description ) : array
    {
        return $this->endpoint( 'setChatDescription', [

            'chat_id' => $chat_id,
            'title'   => $description

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @param bool $disable_notification
     * @return array
     */
    public function pinChatMessage( int $chat_id, int $message_id, bool $disable_notification = true ) : array
    {
        return $this->endpoint( 'pinChatMessage', [

            'chat_id'              => $chat_id,
            'message_id'           => $message_id,
            'disable_notification' => $disable_notification

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @return array
     */
    public function unpinChatMessage( int $chat_id, int $message_id ) : array
    {
        return $this->endpoint( 'unpinChatMessage', [

            'chat_id'    => $chat_id,
            'message_id' => $message_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function unpinAllChatMessages( int $chat_id ) : array
    {
        return $this->endpoint( 'unpinAllChatMessages', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function leaveChat( int $chat_id ) : array
    {
        return $this->endpoint( 'leaveChat', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function getChat( int $chat_id ) : array
    {
        return $this->endpoint( 'getChat', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function getChatAdministrators( int $chat_id ) : array
    {
        return $this->endpoint( 'getChatAdministrators', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @return array
     */
    public function getChatMemberCount( int $chat_id ) : array
    {
        return $this->endpoint( 'getChatMemberCount', [

            'chat_id' => $chat_id,

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $user_id
     * @return array
     */
    public function getChatMember( int $chat_id, int $user_id ) : array
    {
        return $this->endpoint( 'getChatMember', [

            'chat_id' => $chat_id,
            'user_id' => $user_id

        ] );
    }

    /**
     * @param string $inline_query_id
     * @param string $results
     * @param array $more
     * @return array
     */
    public function answerInlineQuery( string $inline_query_id, string $results, array $more = [] ) : array
    {
        return $this->endpoint(
            'answerInlineQuery', array_merge( [

                'inline_query_id' => $inline_query_id,
                'results'         => $results,

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param int $message_id
     * @param string $text
     * @param string|null $keyboard
     * @param string $mode
     * @param array $more
     * @return array
     */
    public function editMessageText( int $user_id, int $message_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array
    {
        return $this->endpoint(
            'editMessageText', array_merge( [

                'chat_id'      => $user_id,
                'text'         => $text,
                'message_id'   => $message_id,
                'reply_markup' => $keyboard,
                'parse_mode'   => $this->checkMode( $mode )

            ], $more )
        );
    }

    /**
     * @param int $user_id
     * @param int $message_id
     * @param string $caption
     * @param string|null $keyboard
     * @param string $mode
     * @param array $more
     * @return array
     */
    public function editMessageCaption( int $user_id, int $message_id, string $caption, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array
    {
        return $this->endpoint(
            'editMessageCaption', array_merge( [

                'chat_id'      => $user_id,
                'caption'      => $caption,
                'message_id'   => $message_id,
                'reply_markup' => $keyboard,
                'parse_mode'   => $this->checkMode( $mode )

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @param string|null $keyboard
     * @param array $more
     * @return array
     */
    public function editKeyboard( int $chat_id, int $message_id, string $keyboard = null, array $more = [] ) : array
    {
        return $this->endpoint(
            'editMessageReplyMarkup', array_merge( [

                'chat_id'      => $chat_id,
                'message_id'   => $message_id,
                'reply_markup' => $keyboard,

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @param string|null $keyboard
     * @return array
     */
    public function stopPoll( int $chat_id, int $message_id, string $keyboard = null ) : array
    {
        return $this->endpoint( 'stopPoll', [

            'chat_id'      => $chat_id,
            'message_id'   => $message_id,
            'reply_markup' => $keyboard,

        ] );
    }

    /**
     * @param int $chat_id
     * @param int $message_id
     * @return array
     */
    public function deleteMessage( int $chat_id, int $message_id ) : array
    {
        return $this->endpoint( 'deleteMessage', [

            'chat_id'    => $chat_id,
            'message_id' => $message_id,

        ] );
    }

    /**
     * @param string $callback_query_id
     * @param string $text
     * @param bool $show_alert
     * @param array $more
     * @return array
     */
    public function answerCallbackQuery( string $callback_query_id, string $text, bool $show_alert = false, array $more = [] ) : array
    {
        return $this->endpoint(
            'answerCallbackQuery', array_merge( [

                'callback_query_id' => $callback_query_id,
                'text'              => $text,
                'show_alert'        => $show_alert

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param array $more
     * @return array
     */
    public function createChatInviteLink( int $chat_id, array $more = [] ) : array
    {
        return $this->endpoint(
            'createChatInviteLink', array_merge( [

                'chat_id' => $chat_id,

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param string $invite_link
     * @param array $more
     * @return array
     */
    public function editChatInviteLink( int $chat_id, string $invite_link, array $more = [] ) : array
    {
        return $this->endpoint(
            'editChatInviteLink', array_merge( [

                'chat_id'     => $chat_id,
                'invite_link' => $invite_link

            ], $more )
        );
    }

    /**
     * @param int $chat_id
     * @param string $invite_link
     * @return array
     */
    public function revokeChatInviteLink( int $chat_id, string $invite_link ) : array
    {
        return $this->endpoint( 'revokeChatInviteLink', [

            'chat_id'     => $chat_id,
            'invite_link' => $invite_link

        ] );
    }

    /**
     * @param bool $selective
     * @return string
     */
    public function buildKeyBoardHide( bool $selective = true ) : string
    {
        return json_encode( [ 'hide_keyboard' => true, 'selective' => $selective ], true );
    }

    /**
     * @param bool $selective
     * @return string
     */
    public function buildForceReply( bool $selective = true ) : string
    {
        return json_encode( [ 'force_reply' => true, 'selective' => $selective ], true );
    }

    /**
     * @param $text
     * @param bool $request_contact
     * @param bool $request_location
     * @return array
     */
    public function buildKeyboardButton( $text, bool $request_contact = false, bool $request_location = false ) : array
    {
        return [ 'text' => $text, 'request_contact' => $request_contact, 'request_location' => $request_location ];
    }

    /**
     * @param $text
     * @param string $url
     * @param string $callback_data
     * @param string $switch_inline_query
     * @return array
     */
    public function buildInlineKeyboardButton( $text, string $url = "", string $callback_data = "", string $switch_inline_query = "" ) : array
    {
        $replyMarkup = array( 'text' => $text );
        if ( $url != "" )
        {
            $replyMarkup[ 'url' ] = $url;
        }
        else
        {
            if ( $callback_data != "" )
            {
                $replyMarkup[ 'callback_data' ] = $callback_data;
            }
            else
            {
                if ( $switch_inline_query != "" )
                {
                    $replyMarkup[ 'switch_inline_query' ] = $switch_inline_query;
                }
            }
        }
        return $replyMarkup;
    }

    /**
     * @param array $options
     * @return string
     */
    public function buildInlineKeyBoard( array $options ) : string
    {
        return json_encode( [ 'inline_keyboard' => $options ], true );
    }

    /**
     * @param array $options
     * @param string $input_field_placeholder
     * @param bool $onetime
     * @param bool $resize
     * @param bool $selective
     * @return false|string
     */
    public function buildKeyBoard( array $options, string $input_field_placeholder = '', bool $onetime = false, bool $resize = true, bool $selective = false )
    {
        return json_encode( [
            'keyboard'                => $options,
            'one_time_keyboard'       => $onetime,
            'resize_keyboard'         => $resize,
            'selective'               => $selective,
            'input_field_placeholder' => $input_field_placeholder
        ], true );
    }

    /**
     * @param string $url
     * @param string $certificate
     * @param array $more
     * @return array
     */
    public function setWebhook( string $url, string $certificate = "", array $more = [] ) : array
    {
        if ( $certificate == "" )
        {
            $content = array( 'url' => $url );
        }
        else
        {
            $content = array( 'url' => $url, 'certificate' => $certificate );
        }
        return $this->endpoint( "setWebhook", array_merge( $content, $more ) );
    }

    /**
     * @param bool $drop_pending_updates
     * @return array
     */
    public function deleteWebhook( bool $drop_pending_updates = true ) : array
    {
        return $this->endpoint( "deleteWebhook", [ 'drop_pending_updates' => $drop_pending_updates ] );
    }

    /**
     * @return array
     */
    public function getWebhookInfo() : array
    {
        return $this->endpoint( "getWebhookInfo", [] );
    }

    /**
     * @param $telegram_file_path
     * @param $local_file_path
     * @return void
     */
    public function downloadFile( $telegram_file_path, $local_file_path )
    {
        $file_url = "https://api.telegram.org/file/bot" . $this->TOKEN . "/" . $telegram_file_path;
        $in       = fopen( $file_url, "rb" );
        $out      = fopen( $local_file_path, "wb" );
        while ( $chunk = fread( $in, 8192 ) )
        {
            fwrite( $out, $chunk, 8192 );
        }
        fclose( $in );
        fclose( $out );
    }

    /**
     * @return array
     */
    public function getMe() : array
    {
        return $this->endpoint( "getMe", array(), false );
    }

    /**
     * @return string
     */
    public function usernameUrl() : string
    {
        return 'tg://resolve?domain=' . $this->getMe()[ 'result' ][ 'username' ];
    }

    /**
     * @param string $TOKEN
     * @return TelegramManager
     */
    public function setTOKEN( string $TOKEN ) : TelegramManager
    {
        $this->TOKEN = $TOKEN;
        return $this;
    }

}
