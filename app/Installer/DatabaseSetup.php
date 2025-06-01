<?php

namespace App\Installer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;

class DatabaseSetup
{
    public function showDatabaseSetup()
    {
        return inertia('Installer/DatabaseSetup');
    }



    
    public function saveDatabaseConfig(Request $request)
    {  
        
        $validator = Validator::make($request->all(), [
            'db_host' => 'required',
            'db_port' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 'validation_failed'
            ], 200);
        }

        



        // Try DB connection
        config([
            'database.connections.temp' => [
                'driver' => 'mysql',
                'host' => $request->db_host,
                'port' => $request->db_port,
                'database' => $request->db_name,
                'username' => $request->db_user,
                'password' => $request->db_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);



        try {
            DB::connection('temp')->getPdo();
            // return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'db_error' => ['Database connection failed: ' . $e->getMessage()]
                ]
            ], 200);
        }

        // 👇 Force Laravel to use new DB config NOW
        config([
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $request->db_host,
            'database.connections.mysql.port' => $request->db_port,
            'database.connections.mysql.database' => $request->db_name,
            'database.connections.mysql.username' => $request->db_user,
            'database.connections.mysql.password' => $request->db_password,
        ]);


        DB::purge('mysql');
        DB::reconnect('mysql');

        Artisan::call('config:clear');



        


    try {
        Artisan::call('migrate', ['--force' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'already_exists',
            'message' => 'Database already exists or migrations already run.',
            'error' => $e->getMessage(),
        ], 200);
    }

    try {
        Artisan::call('db:seed', ['--force' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'seeding_failed',
            'message' => 'Seeding failed.',
            'error' => $e->getMessage(),
        ], 200);
    }


















        // Artisan::call('migrate', ['--force' => true]);

        //         // Run seeders
        // Artisan::call('db:seed', ['--force' => true]);



        // 🔐 Generate APP_KEY
        Artisan::call('key:generate', ['--force' => true]);



                // Write to .env
        $this->setEnvValues([
            'DB_HOST' => $request->db_host,
            'DB_PORT' => $request->db_port,
            'DB_DATABASE' => $request->db_name,
            'DB_USERNAME' => $request->db_user,
            'DB_PASSWORD' => $request->db_password,
        ]);

        return response()->json([
            'success' => true,
        ]);
    
    }

    protected function setEnvValues(array $values)
    {
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        foreach ($values as $key => $value) {
            $pattern = "/^{$key}=.*/m";
            $replace = "{$key}=\"{$value}\"";

            if (preg_match($pattern, $envContent)) {
                $envContent = preg_replace($pattern, $replace, $envContent);
            } else {
                $envContent .= "\n{$replace}";
            }
        }

        file_put_contents($envPath, $envContent);
    }
}
