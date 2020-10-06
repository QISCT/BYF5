<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Castable;
use App\Casts\Contacts as ContactsCast;

class Contact implements Castable
{
    public string $name;
    public string $email;
    public string $phone;

    /**
     * The View Factory to create the Html string
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected static $viewFactory;

    /**
     * Contact constructor.
     * @param array $arguments
     */
    public function __construct(array $arguments)
    {
        ['name' => $this->name, 'email' => $this->email, 'phone' => $this->phone] = $arguments;
    }


    /**
     * Get the name of the caster class to use when casting from / to this cast target.
     * @param  array  $arguments
     * @return string
     */
    public static function castUsing(array $arguments) : string
    {
        return ContactsCast::class;
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        if (!static::$viewFactory) {
            static::$viewFactory = view();
        }

        return static::$viewFactory->make('inc.render.contact')->with('contact', $this)->render();
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }
}
