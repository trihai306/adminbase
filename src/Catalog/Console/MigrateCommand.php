<?php

namespace Modules\Catalog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\InputOption;

class MigrateCommand extends Command
{
    protected function storeMediaImage($path)
    {
        if (!$path) return $path;

        try {
            $imagePath = "media/$path";

            if (!Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->put(
                    $imagePath,
                    file_get_contents("https://muakey.cdn.vccloud.vn/uploads/images/$path")
                );
            }
        } catch (\Exception $exception) {
            $imagePath = null;
        }

        return $imagePath.'?hash='.substr(hash_hmac('sha256', $imagePath, 'image'), 0, 8);
    }

    protected function setupOldDatabaseConnection()
    {
        config()->set('database.connections.old_mysql', [
            "driver" => "mysql",
            "url" => null,
            "host" => $this->option('host'),
            "port" => $this->option('port'),
            "database" => $this->option('database'),
            "username" => $this->option('username'),
            "password" => $this->option('password'),
            "unix_socket" => "",
            "charset" => "utf8mb4",
            "collation" => "utf8mb4_unicode_ci",
            "prefix" => "",
            "prefix_indexes" => true,
            "strict" => true,
            "engine" => null,
            "options" => []
        ]);
    }

    protected function getOptions()
    {
        return [
            ['host', null, InputOption::VALUE_OPTIONAL, 'Host', '127.0.0.1'],
            ['port', null, InputOption::VALUE_OPTIONAL, 'Port', '3306'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'Database', 'product'],
            ['username', null, InputOption::VALUE_OPTIONAL, 'Username', 'root'],
            ['password', null, InputOption::VALUE_OPTIONAL, 'Password', ''],
        ];
    }
}
