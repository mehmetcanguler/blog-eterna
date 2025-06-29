<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use Illuminate\Console\Command;

class RoleImportCommand extends Command
{
    protected $signature = 'roles:import';
    protected $description = 'Sistemde kullanılacak rolleri import eder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $roles = RoleEnum::cases();

        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create([
                'name' => $role->value,
                'guard_name' => 'web',
            ]);
        }
    }
}
