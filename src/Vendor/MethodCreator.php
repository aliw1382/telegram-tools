<?php

namespace Aliw1382\TelegramTools\Vendor;

use Closure;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use InvalidArgumentException;

class MethodCreator
{

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected Filesystem $files;

    /**
     * The custom app stubs directory.
     *
     * @var string
     */
    protected string $customStubPath;

    /**
     * The registered post create hooks.
     *
     * @var array
     */
    protected array $postCreate = [];

    /**
     * Create a new method creator instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string $customStubPath
     * @return void
     */
    public function __construct( Filesystem $files, string $customStubPath )
    {
        $this->files          = $files;
        $this->customStubPath = $customStubPath;
    }

    /**
     * Create a new method at the given path.
     *
     * @param string $name
     * @param string $path
     * @param string|null $className
     * @param bool $create
     * @return string
     *
     * @throws \Exception
     */
    public function create( string $name, string $path, string $className = null, bool $create = false ) : string
    {
        $this->ensureMethodDoesntAlreadyExist( $name, $path );

        // First we will get the stub file for the method, which serves as a type
        // of template for the method. Once we have those we will populate the
        // various place-holders, save the file, and run the post create event.
        $stub = $this->getStub( $className, $create );

        $path = $this->getPath( $name, $path );

        $this->files->ensureDirectoryExists( dirname( $path ) );

        $this->files->put(
            $path, $this->populateStub( $stub, $className )
        );

        // Next, we will fire any hooks that are supposed to fire after a method is
        // created. Once that is done we'll be ready to return the full path to the
        // method file so it can be used however it's needed by the developer.
        $this->firePostCreateHooks( $className, $path );

        return $path;
    }

    /**
     * Ensure that a method with the given name doesn't already exist.
     *
     * @param string $name
     * @param string $MethodPath
     * @return void
     *
     * @throws \InvalidArgumentException|\Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function ensureMethodDoesntAlreadyExist( $name, $MethodPath = null ) : void
    {
        if ( ! empty( $MethodPath ) )
        {
            $MethodFiles = $this->files->glob( $MethodPath . '/*.php' );

            foreach ( $MethodFiles as $MethodFile )
            {
                $this->files->requireOnce( $MethodFile );
            }
        }

        if ( class_exists( $className = $this->getClassName( $name ) ) )
        {
            throw new InvalidArgumentException( "A {$className} class already exists." );
        }
    }

    /**
     * Get the method stub file.
     *
     * @param string|null $className
     * @param bool $create
     * @return string
     * @throws FileNotFoundException
     */
    protected function getStub( $className, $create ) : string
    {
        if ( is_null( $className ) )
        {
            $stub = $this->files->exists( $customPath = $this->customStubPath . '/method.stub' )
                ? $customPath
                : $this->stubPath() . '/method.stub';
        }
        elseif ( $create )
        {
            $stub = $this->files->exists( $customPath = $this->customStubPath . '/method.create.stub' )
                ? $customPath
                : $this->stubPath() . '/method.create.stub';
        }
        else
        {
            $stub = $this->files->exists( $customPath = $this->customStubPath . '/method.update.stub' )
                ? $customPath
                : $this->stubPath() . '/method.update.stub';
        }

        return $this->files->get( $stub );
    }

    /**
     * Populate the place-holders in the method stub.
     *
     * @param string $stub
     * @param string|null $className
     * @return string
     */
    protected function populateStub( $stub, $className ) : string
    {
        // Here we will replace the table place-holders with the table specified by
        // the developer, which is useful for quickly creating a tables creation
        // or update method from the console instead of typing it manually.
        if ( ! is_null( $className ) )
        {
            $stub = str_replace(
                [ 'DummyClass', '{{ ClassName }}', '{{class}}' ],
                $className, $stub
            );
            $stub = str_replace(
                [ '{{ class }}', '{{ className }}' ],
                \str( $className )->lcfirst(), $stub
            );
        }

        return $stub;
    }

    /**
     * Get the class name of a method name.
     *
     * @param string $name
     * @return string
     */
    protected function getClassName( $name ) : string
    {
        return Str::studly( $name );
    }

    /**
     * Get the full path to the method.
     *
     * @param string $name
     * @param string $path
     * @return string
     */
    protected function getPath( string $name, string $path ) : string
    {
        return $path . '/' . $name . '.php';
    }

    /**
     * Fire the registered post create hooks.
     *
     * @param string|null $className
     * @param string $path
     * @return void
     */
    protected function firePostCreateHooks( ?string $className, string $path ) : void
    {
        foreach ( $this->postCreate as $callback )
        {
            $callback( $className, $path );
        }
    }

    /**
     * Register a post method create hook.
     *
     * @param Closure $callback
     * @return void
     */
    public function afterCreate( Closure $callback )
    {
        $this->postCreate[] = $callback;
    }

    /**
     * Get the date prefix for the method.
     *
     * @return string
     */
    protected function getDatePrefix() : string
    {
        return date( 'Y_m_d_His' );
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function stubPath() : string
    {
        return __DIR__ . '/../Methods/stubs';
    }

    /**
     * Get the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFilesystem()
    {
        return $this->files;
    }


}
