<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PermissionImportCommand extends Command
{
    protected $signature = 'permissions:import';
    protected $description = 'Sistemde kullanılacak izinleri import eder';

    private $actions = [
        'view_any',
        'view',
        'create',
        'update',
        'delete',
    ];

    private $models = [
        'posts',
        'categories'
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach ($this->models as $model) {
            foreach ($this->actions as $action) {
                \Spatie\Permission\Models\Permission::create([
                    'name' => $model . '.' . $action,
                    'guard_name' => 'web',
                ]);
            }
        }
    }
}
