<?php

namespace Aliw1382\TelegramTools\Middlewares;

use Aliw1382\TelegramTools\Vendor\TelegramUpdate;
use Closure;
use Illuminate\Http\Request;

class TelegramMiddleware
{

    public function handle( Request $request, Closure $next )
    {

        if ( ! app()->runningInConsole() )
        {

            $telegram_ip_ranges = [
                [ 'lower' => '149.154.160.0', 'upper' => '149.154.175.255' ],
                [ 'lower' => '91.108.4.0', 'upper' => '91.108.7.255' ],
            ];

            $ip_dec = (float) sprintf( "%u", ip2long( $request->ip() ) );
            $ok     = false;

            foreach ( $telegram_ip_ranges as $telegram_ip_range ) if ( ! $ok )
            {
                $lower_dec = (float) sprintf( "%u", ip2long( $telegram_ip_range[ 'lower' ] ) );
                $upper_dec = (float) sprintf( "%u", ip2long( $telegram_ip_range[ 'upper' ] ) );
                if ( $ip_dec >= $lower_dec and $ip_dec <= $upper_dec ) $ok = true;
            }

            abort_if( ! $ok, 401, "Hmm, I don't trust you..." );

        }

        return $next( $request );

    }
}
