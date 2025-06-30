<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class RolePermissionImportCommand extends Command
{
    protected $signature = 'role-permissions:import';

    protected $description = 'Sistemde kullanılacak Rol ve izinleri import eder ve atamasını yapar';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $roles = collect(File::allFiles(config_path('roles')))
            ->mapWithKeys(fn ($file) => [
                pathinfo($file->getFilename(), PATHINFO_FILENAME) => require $file->getPathname(),
            ]);

        $this->info('Rol ve İzinler config/roles dizininden çekildi');

        foreach ($roles as $key => $value) {
            \Spatie\Permission\Models\Role::create([
                'name' => $key,
                'guard_name' => 'sanctum',
            ]);
        }

        $permissions = $roles['admin']['permissions']; // all permissions

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create([
                'name' => $permission,
                'guard_name' => 'sanctum',
            ]);
        }

        $this->info('Rol ve izinler başarıyla import edildi.');

        foreach ($roles as $key => $value) {
            $role = \Spatie\Permission\Models\Role::where('name', $key)->first();

            foreach ($value['permissions'] as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        $this->info('Rol ve izinler başarıyla atandı.');

    }
}
