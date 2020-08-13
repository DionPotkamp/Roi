<?php

if (!function_exists('dd')) {
    function dd($dumpMe, $_ = null){
        $args = func_get_args();
        echo '<code><pre class="d-block p-3 bg-dark text-light">';
        foreach ($args as $arg) {
            var_dump($arg);
            echo '<hr>';
        }
        echo '</pre></code>';
        die();
    }
}

if (!function_exists('env')) {
    /**
     * @param $key
     * @param null $default
     * @return string|null
     */
    function env($key, $default = null){
        $configKey = explode('.', $key);
        $config = include __DIR__.'/../Config/'.$configKey[0].'.php';
        if (array_key_exists($configKey[1], $config)) {
            return $config[$configKey[1]];
        } else {
            return $default;
        }
    }
}