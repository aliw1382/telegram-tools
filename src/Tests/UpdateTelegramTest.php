<?php

namespace Aliw1382\TelegramTools\Tests;

use Tests\TestCase;

class UpdateTelegramTest extends TestCase
{

    public function testBasic()
    {

        $response = $this->post(
            route( 'telegram.webhook', [ 'token' => config( 'telegram.telegram-bot-api.token' ) ] ),
            json_decode( '{"update_id":289155601,"message":{"message_id":1,"from":{"id":120545527,"is_bot":false,"first_name":"\ud835\udd6c\ud835\udd91\ud835\udd8e","username":"aliw1382","language_code":"en","is_premium":true},"chat":{"id":120545527,"first_name":"\ud835\udd6c\ud835\udd91\ud835\udd8e","username":"aliw1382","type":"private"},"date":1693767140,"text":"\/start","entities":[{"offset":0,"length":6,"type":"bot_command"}]}}', true )
        );

        $response->assertStatus( 200 );

    }
}
