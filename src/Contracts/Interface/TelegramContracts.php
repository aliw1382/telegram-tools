<?php

namespace Aliw1382\TelegramTools\Contracts\Interface;

use Aliw1382\TelegramTools\Enums\TelegramTypeMessage;


interface TelegramContracts
{

    public function endpoint( string $api, array $content, bool $post = true ) : array;

    public function sendMessage( int $user_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array;

    public function supperSendMessage( array $data, ?array &$extras = [] ) : array;

    public function forwardMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] ) : array;

    public function copyMessage( int $to_user_id, int $chat_id, int $message_id, array $more = [] ) : array;

    public function sendPhoto( int $user_id, string $file_id_or_address_file, string $caption = null, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array;

    public function sendAudio( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array;

    public function sendDocument( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array;

    public function sendVideo( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array;

    public function sendVoice( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array;

    public function sendVideoNote( int $user_id, string $file_id_or_address_file, string $caption, string $keyboard = null, array $more = [] ) : array;

    public function sendMediaGroup( int $user_id, array $media, array $more = [] ) : array;

    public function sendLocation( int $user_id, float $lat, float $long, string $keyboard = null, array $more = [] ) : array;

    public function editMessageLiveLocation( float $lat, float $long, array $more = [] ) : array;

    public function stopMessageLiveLocation( array $more ) : array;

    public function sendContact( int $user_id, string $phone_number, string $first_name, array $more = [] ) : array;

    public function sendPoll( int $user_id, string $question, array $options, bool $is_anonymous = true, string $keyboard = null, array $more = [] ) : array;

    public function sendDice( int $user_id, string $emoji, string $keyboard = null, array $more = [] ) : array;

    public function sendChatAction( int $user_id, string $action ) : array;

    public function getUserProfilePhotos( int $user_id, array $more = [] ) : array;

    public function getFile( string $file_id ) : array;

    public function banChatMember( int $chat_id, int $user_id, array $more = [] ) : array;

    public function unbanChatMember( int $chat_id, int $user_id, bool $only_if_banned = true ) : array;

    public function setChatAdministratorCustomTitle( int $chat_id, int $user_id, string $title ) : array;

    public function banChatSenderChat( int $user_id, int $sender_chat_id ) : array;

    public function approveChatJoinRequest( int $chat_id, int $user_id ) : array;

    public function declineChatJoinRequest( int $chat_id, int $user_id ) : array;

    public function setChatPhoto( int $chat_id, string $photo_id ) : array;

    public function deleteChatPhoto( int $chat_id ) : array;

    public function setChatTitle( int $chat_id, string $title ) : array;

    public function setChatDescription( int $chat_id, string $description ) : array;

    public function pinChatMessage( int $chat_id, int $message_id, bool $disable_notification = true ) : array;

    public function unpinChatMessage( int $chat_id, int $message_id ) : array;

    public function unpinAllChatMessages( int $chat_id ) : array;

    public function leaveChat( int $chat_id ) : array;

    public function getChat( int $chat_id ) : array;

    public function getChatAdministrators( int $chat_id ) : array;

    public function getChatMemberCount( int $chat_id ) : array;

    public function getChatMember( int $chat_id, int $user_id ) : array;

    public function answerInlineQuery( string $inline_query_id, string $results, array $more = [] ) : array;

    public function editMessageText( int $user_id, int $message_id, string $text, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array;

    public function editMessageCaption( int $user_id, int $message_id, string $caption, string $keyboard = null, string $mode = TelegramTypeMessage::HTML, array $more = [] ) : array;

    public function editKeyboard( int $chat_id, int $message_id, string $keyboard = null, array $more = [] ) : array;

    public function stopPoll( int $chat_id, int $message_id, string $keyboard = null ) : array;

    public function deleteMessage( int $chat_id, int $message_id ) : array;

    public function answerCallbackQuery( string $callback_query_id, string $text, bool $show_alert = false, array $more = [] ) : array;

    public function createChatInviteLink( int $chat_id, array $more = [] ) : array;

    public function editChatInviteLink( int $chat_id, string $invite_link, array $more = [] ) : array;

    public function revokeChatInviteLink( int $chat_id, string $invite_link ) : array;

    public function buildKeyBoardHide( bool $selective = true ) : string;

    public function buildForceReply( bool $selective = true ) : string;

    public function buildKeyboardButton( $text, bool $request_contact = false, bool $request_location = false ) : array;

    public function buildInlineKeyboardButton( $text, string $url = "", string $callback_data = "", string $switch_inline_query = "" ) : array;

    public function buildInlineKeyBoard( array $options ) : string;

    public function buildKeyBoard( array $options, string $input_field_placeholder = '', bool $onetime = false, bool $resize = true, bool $selective = false );

    public function setWebhook( string $url, string $certificate = "", array $more = [] ) : array;

    public function deleteWebhook( bool $drop_pending_updates = true ) : array;

    public function getWebhookInfo() : array;

    public function downloadFile( $telegram_file_path, $local_file_path );

    public function getMe() : array;

    public function usernameUrl() : string;

}
