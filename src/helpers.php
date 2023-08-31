<?php


use Aliw1382\TelegramTools\Telegram;

if ( ! function_exists( 'telegram' ) )
{

    /**
     * @param string|null $token
     * @return Telegram
     */
    function telegram( string $token = null ) : Telegram
    {
        return app( Telegram::class, [
            'token' => transform(
                $token,
                fn( $token ) => $token,
                config( 'telegram.telegram-bot-api.token' )
            )
        ] );
    }

}

if ( ! function_exists( 'json' ) )
{

    /**
     * @return \Illuminate\Support\Collection|mixed
     */
    function json() : mixed
    {
        return collect( func_get_args() )
            ->map(
                fn( $value ) => is_array( $value )
                    ? json_encode( $value )
                    : ( Str::isJson( $value ) ? collect( json_decode( $value ) ) : $value )
            )->when(
                fn( $collection ) => $collection->count() == 1,
                fn( $collection ) => $collection->first()
            )
        ;
    }

}

if ( ! function_exists( 'str' ) )
{
    /**
     * Get a new stringable object from the given string.
     *
     * @param string|null $string
     * @return \Illuminate\Support\Stringable|mixed
     */
    function str( string $string = null ) : mixed
    {
        if ( func_num_args() === 0 )
        {
            return new class {
                public function __call( $method, $parameters )
                {
                    return Str::$method( ...$parameters );
                }

                public function __toString()
                {
                    return '';
                }
            };
        }

        return Str::of( $string );
    }
}
