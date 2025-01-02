<?php

/**
 * Entry point utama untuk aplikasi non-API.
 */

require_once __DIR__ . '/../vendor/autoload.php';

\Core\Kernel\Kernel::web(
    new \App\Kernel()
)->run();
