<?php

class Haanga_Extension_Tag_SetSafe
{
    public $is_block = false;

    static function generator($cmp, $args)
    {
        foreach ($args as $arg) {
            if (Haanga_AST::is_var($arg)) {
                $cmp->set_safe($arg['var']);
            }
        }

        return hcode();
    }
}
