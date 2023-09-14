<?php

namespace Aliw1382\TelegramTools\Methods;

use Aliw1382\TelegramTools\Contracts\Interface\TelegramSenderContract;
use Aliw1382\TelegramTools\TelegramBase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TelegramContact.
 */
class SendContact extends TelegramBase implements TelegramSenderContract
{

    /**
     * @param string $phoneNumber
     */
    public function __construct( string $phoneNumber )
    {
        parent::__construct();
        $this->phoneNumber( $phoneNumber );
    }

    /**
     * @param string $phoneNumber
     * @return static
     */
    public static function create( string $phoneNumber = '' ) : self
    {
        return new self( $phoneNumber );
    }

    /**
     * Contact phone number.
     *
     * @return $this
     */
    public function phoneNumber( string $phoneNumber ) : self
    {
        $this->payload[ 'phone_number' ] = $phoneNumber;

        return $this;
    }

    /**
     * Contact first name.
     *
     * @return $this
     */
    public function firstName( string $firstName ) : self
    {
        $this->payload[ 'first_name' ] = $firstName;

        return $this;
    }

    /**
     * Contact last name.
     *
     * @return $this
     */
    public function lastName( string $lastName ) : self
    {
        $this->payload[ 'last_name' ] = $lastName;

        return $this;
    }

    /**
     * Contact vCard.
     *
     * @return $this
     */
    public function vCard( string $vCard ) : self
    {
        $this->payload[ 'vcard' ] = $vCard;

        return $this;
    }

    /**
     * @return ResponseInterface|array|null
     */
    public function send() : ResponseInterface | array | null
    {
        return $this->telegram->sendContact( $this->toArray() );
    }

}
