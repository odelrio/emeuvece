<?php

class Haanga_Extension_Filter_Safe
{
    static function generator($compiler, $args)
    {
        $compiler->var_is_safe = true;
        return current($args);
    }
}
