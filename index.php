<?php

/*
 * FlightPHP Framework
 * @copyright   Copyright (c) 2024, Mike Cao <mike@mikecao.com>, n0nag0n <n0nag0n@sky-9.com>
 * @license     MIT, http://flightphp.com/license
                                                                  .____   __ _
     __o__   _______ _ _  _                                     /     /
     \    ~\                                                  /      /
       \     '\                                         ..../      .'
        . ' ' . ~\                                      ' /       /
       .  _    .  ~ \  .+~\~ ~ ' ' " " ' ' ~ - - - - - -''_      /
      .  <#  .  - - -/' . ' \  __                          '~ - \
       .. -           ~-.._ / |__|  ( )  ( )  ( )  0  o    _ _    ~ .
     .-'                                               .- ~    '-.    -.
    <                      . ~ ' ' .             . - ~             ~ -.__~_. _ _
      ~- .       N121PP  .          . . . . ,- ~
            ' ~ - - - - =.   <#>    .         \.._
                        .     ~      ____ _ .. ..  .- .
                         .         '        ~ -.        ~ -.
                           ' . . '               ~ - .       ~-.
                                                       ~ - .      ~ .
                                                              ~ -...0..~. ____
   Cessna 402  (Wings)
   by Dick Williams, rjw1@tyrell.net
*/
$ds = DIRECTORY_SEPARATOR;

// When used as router for PHP built-in server: serve static files directly
if (php_sapi_name() === 'cli-server') {
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $file = __DIR__ . $uri;
    if ($uri !== '/' && is_file($file)) {
        return false; // Let PHP serve the static file as-is
    }
}

// Bootstrap the FlightPHP application
$bootstrapPath = __DIR__ . $ds . 'app' . $ds . 'config' . $ds . 'bootstrap.php';
if (!file_exists($bootstrapPath)) {
    $bootstrapPath = __DIR__ . $ds . '..' . $ds . 'app' . $ds . 'config' . $ds . 'bootstrap.php';
}
require($bootstrapPath);