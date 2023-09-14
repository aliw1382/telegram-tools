<?php

namespace Aliw1382\TelegramTools\Facades;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramContracts;
use Aliw1382\TelegramTools\Enums\TelegramTypeMessage;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array endpoint( string $api, array $content, bool $post = true )
 * @method static array sendMessage( int $user_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] )
 * @method static array supperSendMessage( array $data, ?array &$extras = [] )
 * @method static array forwardMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] )
 * @method static array copyMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] )
 * @method static array sendPhoto( int $user_id, string $file_id_or_address_file, string $caption = null, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] )
 * @method static array sendAudio( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] )
 * @method static array sendDocument( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] )
 * @method static array sendVideo( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] )
 * @method static array sendVoice( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] )
 * @method static array sendVideoNote( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] )
 * @method static array sendMediaGroup( int $user_id, array $media, array $more = [] )
 * @method static array sendLocation( int $user_id, float $lat, float $long, string $keyboard = null, array $more = [] )
 * @method static array editMessageLiveLocation( float $lat, float $long, array $more = [] )
 * @method static array stopMessageLiveLocation( array $more )
 * @method static array sendContact( int $user_id, string $phone_number, string $first_name, array $more = [] )
 * @method static array sendPoll( int $user_id, string $question, array $options, bool $is_anonymous = true, string $keyboard = null, array $more = [] )
 * @method static array sendDice( int $user_id, string $emoji, string $keyboard = null, array $more = [] )
 * @method static array sendChatAction( int $user_id, string $action )
 * @method static array getUserProfilePhotos( int $user_id, array $more = [] )
 * @method static array getFile( string $file_id )
 * @method static array banChatMember( int $chat_id, int $user_id, array $more = [] )
 * @method static array unbanChatMember( int $chat_id, int $user_id, bool $only_if_banned = true )
 * @method static array setChatAdministratorCustomTitle( int $chat_id, int $user_id, string $title )
 * @method static array banChatSenderChat( int $user_id, int $sender_chat_id )
 * @method static array approveChatJoinRequest( int $chat_id, int $user_id )
 * @method static array declineChatJoinRequest( int $chat_id, int $user_id )
 * @method static array setChatPhoto( int $chat_id, string $photo_id )
 * @method static array deleteChatPhoto( int $chat_id )
 * @method static array setChatTitle( int $chat_id, string $title )
 * @method static array setChatDescription( int $chat_id, string $description )
 * @method static array pinChatMessage( int $chat_id, int $message_id, bool $disable_notification = true )
 * @method static array unpinChatMessage( int $chat_id, int $message_id )
 * @method static array unpinAllChatMessages( int $chat_id )
 * @method static array leaveChat( int $chat_id )
 * @method static array getChat( int $chat_id )
 * @method static array getChatAdministrators( int $chat_id )
 * @method static array getChatMemberCount( int $chat_id )
 * @method static array getChatMember( int $chat_id, int $user_id )
 * @method static array answerInlineQuery( string $inline_query_id, string $results, array $more = [] )
 * @method static array editMessageText( int $user_id, int $message_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] )
 * @method static array editMessageCaption( int $user_id, int $message_id, string $caption, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] )
 * @method static array editKeyboard( int $chat_id, int $message_id, string $keyboard = null, array $more = [] )
 * @method static array stopPoll( int $chat_id, int $message_id, string $keyboard = null )
 * @method static array deleteMessage( int $chat_id, int $message_id )
 * @method static array answerCallbackQuery( string $callback_query_id, string $text, bool $show_alert = false, array $more = [] )
 * @method static array createChatInviteLink( int $chat_id, array $more = [] )
 * @method static array editChatInviteLink( int $chat_id, string $invite_link, array $more = [] )
 * @method static array revokeChatInviteLink( int $chat_id, string $invite_link )
 * @method static string buildKeyBoardHide( bool $selective = true )
 * @method static string buildForceReply( bool $selective = true )
 * @method static array buildKeyboardButton( $text, bool $request_contact = false, bool $request_location = false )
 * @method static array buildInlineKeyboardButton( $text, string $url = "", string $callback_data = "", string $switch_inline_query = "" )
 * @method static string buildInlineKeyBoard( array $options )
 * @method static string buildKeyBoard( array $options, string $input_field_placeholder = '', bool $onetime = false, bool $resize = true, bool $selective = false )
 * @method static array setWebhook( string $url, string $certificate = "", array $more = [] )
 * @method static array deleteWebhook( bool $drop_pending_updates = true )
 * @method static array getWebhookInfo()
 * @method static $this setTOKEN( string $TOKEN )
 * @method static void downloadFile( $telegram_file_path, $local_file_path )
 * @method static array getMe()
 * @method static string usernameUrl()
 * @see TelegramContracts
 */
class Telegram extends Facade
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor() : string
    {
        return TelegramContracts::class;
    }

}
