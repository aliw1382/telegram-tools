<?php

namespace Aliw1382\TelegramTools\Controllers;


use Aliw1382\TelegramTools\Attribute\TelegramAttribute;
use Aliw1382\TelegramTools\Vendor\TelegramUpdate;
use Illuminate\Routing\Controller;
use ReflectionClass;
use ReflectionMethod;

class TelegramController extends Controller
{

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __invoke( TelegramUpdate $update )
    {

        $abstractClass = 'Aliw1382\TelegramTools\Contracts\Abstract\AbstractTelegram' . str( $update->getUpdateType() )->ucfirst()->camel();

        collect( config( 'telegram.commands' ) )->each( function ( $class ) use ( $update, $abstractClass ) {

            if ( class_exists( $abstractClass ) && is_a( new $class, $abstractClass ) )
            {

                $reflector_abstract  = new ReflectionClass( $abstractClass );
                $attributes_abstract = $reflector_abstract->getAttributes( TelegramAttribute::class );

                if ( isset( $attributes_abstract[ 0 ] ) )
                {

                    $name = $attributes_abstract[ 0 ]->newInstance()->getName();

                    if ( filled( $name ) )
                    {

                        $reflector_class = new ReflectionClass( $class );
                        foreach ( $reflector_class->getMethods( ReflectionMethod::IS_PUBLIC ) as $method ) if ( ! isset( $attributes_class_method ) || ! $attributes_class_method->newInstance()->stop() )
                        {

                            foreach ( $method->getAttributes( TelegramAttribute::class ) as $attributes_class_method )
                            {

                                $name = $attributes_class_method->newInstance()->getMethod( $name );

                                if (
                                    filled( $attributes_class_method->newInstance()->getName() ) &&
                                    method_exists( $update, $name ) &&
                                    str( $update->{$name}() )->is( $attributes_class_method->newInstance()->getName() )
                                )
                                {

                                    app()->call( [ new $class, $method->getName() ] );

                                }

                            }

                        }

                    }
                    else
                    {
                        throw new \Exception( "Attribute Class {$abstractClass} Can't Empty!" );
                    }

                }
                else
                {
                    throw new \Exception( "You Can't Use {$abstractClass} Without Attribute!" );
                }

            }

        } );

    }

}
