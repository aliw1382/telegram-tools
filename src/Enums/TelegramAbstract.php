<?php

namespace Aliw1382\TelegramTools\Enums;

enum TelegramAbstract: string
{

    case Message = 'Message';

    case CallbackQuery = 'CallbackQuery';

    case ChannelPost = 'ChannelPost';

    case ChatJoinRequest = 'ChatJoinRequest';

    case ChatMember = 'ChatMember';

    case EditedChannelPost = 'EditedChannelPost';

}
