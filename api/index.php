<?php

/**
 * Entry point khusus untuk API.
 *
 * Mengarahkan permintaan API ke kernel API.
 */

require_once __DIR__ . '/../vendor/autoload.php';

\Core\Kernel\Kernel::api(
    new \App\Kernel()
)->run();
