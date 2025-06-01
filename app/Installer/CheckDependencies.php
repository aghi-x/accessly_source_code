<?php

namespace App\Installer;

use Illuminate\Support\Facades\File;
use Inertia\Inertia;




class CheckDependencies
{
    public function checkSystem()
    {
        $checks = [
            'PHP >= 8.2' => version_compare(PHP_VERSION, '8.2', '>='),
            'Extension: pdo' => extension_loaded('pdo'),
            'Extension: mbstring' => extension_loaded('mbstring'),
            'Extension: openssl' => extension_loaded('openssl'),
            'Extension: bcmath' => extension_loaded('bcmath'),
            'Extension: ctype' => extension_loaded('ctype'),
            'Extension: tokenizer' => extension_loaded('tokenizer'),
            'Extension: json' => extension_loaded('json'),
            'Extension: fileinfo' => extension_loaded('fileinfo'),
            'Extension: curl' => extension_loaded('curl'),
            'Composer Installed' => $this->commandExists('composer'),
            'Node.js Installed' => $this->commandExists('node'),
            'NPM Installed' => $this->commandExists('npm'),
            'storage/ writable' => is_writable(storage_path()),
            'bootstrap/cache/ writable' => is_writable(base_path('bootstrap/cache')),
        ];

        return Inertia::render('Installer/CheckSystem', [
            'checks' => $checks
        ]);
    }




    protected function commandExists($command)
    {
        return !empty(shell_exec("which $command"));
    }
}
