<?php

if (!function_exists('poke_xdebug')) {
    /**
     * Enable XDebug jit mode.
     *
     * @param bool $trigger Trigger XDebug by calling a suppressed trigger_error
     *
     * @return void
     */
    function poke_xdebug($trigger = true)
    {
        if (function_exists('xdebug_enable')) {
            ini_set('xdebug.remote_mode', 'jit');
            $trigger && @trigger_error("I'm poking that bear!");
        }
    }
}
