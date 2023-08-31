<?php

namespace Aliw1382\TelegramTools\Vendor;

class TelegramUrlBot
{

    /**
     * @param string $token
     */
    public function __construct( protected string $token = '' )
    {
    }

    /**
     * @return string
     */
    public function getToken() : string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return TelegramUrlBot
     */
    public function setToken( string $token ) : static
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param string $parameter
     * @return \Illuminate\Support\Stringable|mixed
     */
    public function start( string $parameter ) : mixed
    {
        return str( 'https://t.me/<username-bot>?start=' )
            ->append( $parameter )
            ->replace(
                '<username-bot>',
                json(
                    telegram( $this->token )->getMe()->getBody()->getContents()
                )->get( 'result' )->username,
            )
        ;
    }

    /**
     * @return \Illuminate\Support\Stringable|mixed
     */
    public function group() : mixed
    {
        return str( 'https://telegram.me/<username-bot>?startgroup' )
            ->replace(
                '<username-bot>',
                json(
                    telegram( $this->token )->getMe()->getBody()->getContents()
                )->get( 'result' )->username,
            )
        ;
    }

    /**
     * @return \Illuminate\Support\Stringable|mixed
     */
    public function channel() : mixed
    {
        return str( 'https://telegram.me/<username-bot>?startchannel' )
            ->replace(
                '<username-bot>',
                json(
                    telegram( $this->token )->getMe()->getBody()->getContents()
                )->get( 'result' )->username,
            )
        ;
    }

    /**
     * @param string $parameter
     * @return mixed
     */
    public function username( string $parameter ) : mixed
    {
        return str( 'tg://resolve?domain=' )->append( $parameter );
    }

    /**
     * @param string $parameter
     * @return mixed
     */
    public function user( string $parameter ) : mixed
    {
        return str( 'tg://user?id=' )->append( $parameter );
    }

}
