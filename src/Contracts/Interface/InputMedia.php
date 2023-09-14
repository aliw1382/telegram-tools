<?php

namespace Aliw1382\TelegramTools\Contracts\Interface;

interface InputMedia
{

    /**
     * @return array
     */
    public function toArray() : array;

    /**
     * @param string $media
     * @return static
     */
    public function media( string $media ) : static;

}
