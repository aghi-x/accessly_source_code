<?php

namespace App\Installer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CheckDatabase
{
public function checkMigrations(): array
{
    try {

        $tables = ['users', 'roles', 'permissions', 'settings'];
        $results = [];


        foreach ($tables as $table) {
            $results[$table] = Schema::hasTable($table);
        }
        return [
            'success' => true,
            'results' => $results
        ];



    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Database not configured or unreachable: ' . $e->getMessage()
        ];
    }
}


}