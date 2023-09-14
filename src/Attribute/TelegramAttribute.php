<?php

namespace Aliw1382\TelegramTools\Attribute;

use Attribute;

#[Attribute( Attribute::TARGET_ALL )]
class TelegramAttribute
{

    /**
     * @param string $name
     * @param string|null $method
     * @param bool|null $stop
     */
    public function __construct( private readonly string $name, private readonly ?string $method = null, private ?bool $stop = null )
    {
        if ( is_null( $this->stop ) )
            $this->stop = config( 'telegram.stop-after-first-command', true );
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return bool|null
     */
    public function stop() : ?bool
    {
        return $this->stop;
    }

    /**
     * @param string|null $default
     * @return string|null
     */
    public function getMethod( string $default = null ) : ?string
    {
        return $this->method ?? $default;
    }

}
