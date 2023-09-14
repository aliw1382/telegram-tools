<?php

namespace Aliw1382\TelegramTools\Vendor;

/**
 * Telegram Bot Class.
 *
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
class TelegramUpdate
{
    /**
     * Constant for type Inline Query.
     */
    const INLINE_QUERY = 'inline_query';
    /**
     * Constant for type Callback Query.
     */
    const CALLBACK_QUERY = 'callback_query';
    /**
     * Constant for type Edited Message.
     */
    const EDITED_MESSAGE = 'edited_message';
    /**
     * Constant for type Reply.
     */
    const REPLY = 'reply';
    /**
     * Constant for type Message.
     */
    const MESSAGE = 'message';
    /**
     * Constant for type Photo.
     */
    const PHOTO = 'photo';
    /**
     * Constant for type Video.
     */
    const VIDEO = 'video';
    /**
     * Constant for type Audio.
     */
    const AUDIO = 'audio';
    /**
     * Constant for type Voice.
     */
    const VOICE = 'voice';
    /**
     * Constant for type animation.
     */
    const ANIMATION = 'animation';
    /**
     * Constant for type sticker.
     */
    const STICKER = 'sticker';
    /**
     * Constant for type Document.
     */
    const DOCUMENT = 'document';
    /**
     * Constant for type Location.
     */
    const LOCATION = 'location';
    /**
     * Constant for type Contact.
     */
    const CONTACT = 'contact';
    /**
     * Constant for type Channel Post.
     */
    const CHANNEL_POST = 'channel_post';
    /**
     * Constant for type New Chat Member.
     */
    const NEW_CHAT_MEMBER = 'new_chat_member';
    /**
     * Constant for type Left Chat Member.
     */
    const LEFT_CHAT_MEMBER = 'left_chat_member';
    /**
     * Constant for type My Chat Member.
     */
    const MY_CHAT_MEMBER = 'my_chat_member';


    protected $update_type;

    protected $data;

    public function __construct()
    {
        $this->data = $this->getData();
    }

    /**
     * @return mixed
     */
    public function getData() : mixed
    {
        if ( empty( $this->data ) )
        {
            $rawData = file_get_contents( 'php://input' );

            return json_decode( $rawData, true );
        }
        else
        {
            return $this->data;
        }
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData( array $data )
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return mixed
     */
    public function Text() : mixed
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'data' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'text' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'text' ];
        }

        return @$this->data[ 'message' ][ 'text' ];
    }

    /**
     * @return mixed
     */
    public function Caption()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'caption' ];
        }

        return @$this->data[ 'message' ][ 'caption' ];
    }

    /**
     * @return mixed
     */
    public function ChatID()
    {
        $chat = $this->Chat();

        return $chat[ 'id' ];
    }

    /**
     * @return mixed
     */
    public function Chat()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'message' ][ 'chat' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'chat' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'chat' ];
        }
        if ( $type == self::INLINE_QUERY )
        {
            return @$this->data[ 'inline_query' ][ 'from' ];
        }
        if ( $type == self::MY_CHAT_MEMBER )
        {
            return @$this->data[ 'my_chat_member' ][ 'chat' ];
        }

        return $this->data[ 'message' ][ 'chat' ];
    }

    /**
     * @return mixed
     */
    public function MessageID()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'message' ][ 'message_id' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'message_id' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'message_id' ];
        }

        return $this->data[ 'message' ][ 'message_id' ];
    }

    /**
     * @return mixed
     */
    public function ReplyToMessageID()
    {
        return $this->data[ 'message' ][ 'reply_to_message' ][ 'message_id' ];
    }

    /**
     * @return mixed
     */
    public function ReplyToMessageFromUserID()
    {
        return $this->data[ 'message' ][ 'reply_to_message' ][ 'forward_from' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function InlineQuery()
    {
        return $this->data[ 'inline_query' ];
    }

    /**
     * @return mixed
     */
    public function CallbackQuery()
    {
        return $this->data[ 'callback_query' ];
    }

    /**
     * @return mixed
     */
    public function CallbackID()
    {
        return $this->data[ 'callback_query' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function CallbackData()
    {
        return $this->data[ 'callback_query' ][ 'data' ];
    }

    /**
     * @param string $explode
     * @return string[]
     */
    public function CallbackDataArray( string $explode = '-' )
    {
        return explode( $explode, $this->CallbackData() );
    }

    /**
     * @return mixed
     */
    public function CallbackMessage()
    {
        return $this->data[ 'callback_query' ][ 'message' ];
    }

    /**
     * @return mixed
     */
    public function CallbackChatID()
    {
        return $this->data[ 'callback_query' ][ 'message' ][ 'chat' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function CallbackFromID()
    {
        return $this->data[ 'callback_query' ][ 'from' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function Date()
    {
        return $this->data[ 'message' ][ 'date' ];
    }

    /**
     * @return mixed
     */
    public function FirstName()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'from' ][ 'first_name' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'from' ][ 'first_name' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'from' ][ 'first_name' ];
        }

        return @$this->data[ 'message' ][ 'from' ][ 'first_name' ];
    }

    /**
     * @return mixed
     */
    public function LastName()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'from' ][ 'last_name' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'from' ][ 'last_name' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'from' ][ 'last_name' ];
        }
        if ( $type == self::MESSAGE )
        {
            return @$this->data[ 'message' ][ 'from' ][ 'last_name' ];
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function Username()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return @$this->data[ 'callback_query' ][ 'from' ][ 'username' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return @$this->data[ 'channel_post' ][ 'from' ][ 'username' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'from' ][ 'username' ];
        }

        return @$this->data[ 'message' ][ 'from' ][ 'username' ];
    }

    /**
     * @return mixed
     */
    public function Location()
    {
        return $this->data[ 'message' ][ 'location' ];
    }

    /**
     * @return mixed
     */
    public function UpdateID()
    {
        return $this->data[ 'update_id' ];
    }

    /**
     * @return mixed
     */
    public function UserID()
    {
        $type = $this->getUpdateType();
        if ( $type == self::CALLBACK_QUERY )
        {
            return $this->data[ 'callback_query' ][ 'from' ][ 'id' ];
        }
        if ( $type == self::CHANNEL_POST )
        {
            return $this->data[ 'channel_post' ][ 'from' ][ 'id' ];
        }
        if ( $type == self::EDITED_MESSAGE )
        {
            return @$this->data[ 'edited_message' ][ 'from' ][ 'id' ];
        }
        if ( $type == self::INLINE_QUERY )
        {
            return @$this->data[ 'inline_query' ][ 'from' ][ 'id' ];
        }

        return $this->data[ 'message' ][ 'from' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function FromID()
    {
        return $this->data[ 'message' ][ 'forward_from' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function FromChatID()
    {
        return $this->data[ 'message' ][ 'forward_from_chat' ][ 'id' ];
    }

    /**
     * @return mixed
     */
    public function messageFromGroup()
    {
        if ( $this->data[ 'message' ][ 'chat' ][ 'type' ] == 'private' )
        {
            return false;
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getContactPhoneNumber()
    {
        if ( $this->getUpdateType() == self::CONTACT )
        {
            return $this->data[ 'message' ][ 'contact' ][ 'phone_number' ];
        }

        return '';
    }

    /**
     * @return mixed
     */
    public function messageFromGroupTitle()
    {
        if ( $this->data[ 'message' ][ 'chat' ][ 'type' ] != 'private' )
        {
            return $this->data[ 'message' ][ 'chat' ][ 'title' ];
        }

        return '';
    }

    /**
     * @return false|string
     */
    public function getUpdateType()
    {
        if ( $this->update_type )
        {
            return $this->update_type;
        }

        $update = $this->data;
        if ( isset( $update[ 'inline_query' ] ) )
        {
            $this->update_type = self::INLINE_QUERY;

            return $this->update_type;
        }
        if ( isset( $update[ 'callback_query' ] ) )
        {
            $this->update_type = self::CALLBACK_QUERY;

            return $this->update_type;
        }
        if ( isset( $update[ 'edited_message' ] ) )
        {
            $this->update_type = self::EDITED_MESSAGE;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'text' ] ) )
        {
            $this->update_type = self::MESSAGE;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'photo' ] ) )
        {
            $this->update_type = self::PHOTO;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'video' ] ) )
        {
            $this->update_type = self::VIDEO;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'audio' ] ) )
        {
            $this->update_type = self::AUDIO;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'voice' ] ) )
        {
            $this->update_type = self::VOICE;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'contact' ] ) )
        {
            $this->update_type = self::CONTACT;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'location' ] ) )
        {
            $this->update_type = self::LOCATION;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'reply_to_message' ] ) )
        {
            $this->update_type = self::REPLY;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'animation' ] ) )
        {
            $this->update_type = self::ANIMATION;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'sticker' ] ) )
        {
            $this->update_type = self::STICKER;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'document' ] ) )
        {
            $this->update_type = self::DOCUMENT;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'new_chat_member' ] ) )
        {
            $this->update_type = self::NEW_CHAT_MEMBER;

            return $this->update_type;
        }
        if ( isset( $update[ 'message' ][ 'left_chat_member' ] ) )
        {
            $this->update_type = self::LEFT_CHAT_MEMBER;

            return $this->update_type;
        }
        if ( isset( $update[ 'my_chat_member' ] ) )
        {
            $this->update_type = self::MY_CHAT_MEMBER;

            return $this->update_type;
        }
        if ( isset( $update[ 'channel_post' ] ) )
        {
            $this->update_type = self::CHANNEL_POST;

            return $this->update_type;
        }

        return false;
    }

}
