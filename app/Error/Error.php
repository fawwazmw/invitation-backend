<?php

namespace App\Error;

use Core\Support\Error as BaseError;

class Error extends BaseError
{
    /**
     * Tampilkan errornya.
     *
     * @return mixed
     */
    public function render(): mixed
    {
        // Pastikan log file diarahkan ke lokasi yang diizinkan di Vercel
        $this->setLogPath('/tmp/error.log');

        return parent::render();
    }

    /**
     * Set log path ke direktori tertentu.
     *
     * @param string $path
     * @return void
     */
    private function setLogPath(string $path): void
    {
        if (property_exists($this, 'logPath')) {
            $this->logPath = $path; // Atur path log file
        } else {
            // Jika logPath tidak tersedia, mungkin perlu mekanisme lain
            error_log("Log path property does not exist in BaseError class.");
        }
    }
}
