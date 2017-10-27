<?php

namespace Laravelit\Spaces\Exceptions;

class SpaceDeniedException extends AccessDeniedException
{
    /**
     * Create a new Space denied exception instance.
     *
     * @param string $space
     */
    public function __construct($space)
    {
        $this->message = sprintf("You don't have a required ['%s'] space.", $space);
    }
}
