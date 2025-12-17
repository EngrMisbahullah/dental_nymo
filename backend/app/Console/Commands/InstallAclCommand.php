<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class InstallAclCommand extends Command
{
    protected $signature = 'nymo:install-acl';
    protected $description = 'Install complete ACL system for NymoDental';

    public function handle()
    {
        $this->info('========================================');
        $this->info('🚀 NymoDental ACL Installation');
        $this->info('========================================');
        $this->newLine();

        // Step 1: Install Laravel Sanctum
        $this->info('📦 Step 1/9: Installing Laravel Sanctum...');
        $this->installSanctum();

        // Step 2: Create Migrations
        $this->info('📦 Step 2/9: Creating migration files...');
        $this->createMigrations();

        // Step 3: Create Seeders
        $this->info('📦 Step 3/9: Creating seeder files...');
        $this->createSeeders();

        // Step 4: Create Models
        $this->info('📦 Step 4/9: Creating model files...');
        $this->createModels();

        // Step 5: Create Controllers
        $this->info('📦 Step 5/9: Creating controller files...');
        $this->createControllers();

        // Step 6: Create Middleware
        $this->info('📦 Step 6/9: Creating middleware files...');
        $this->createMiddleware();

        // Step 7: Update Routes
        $this->info('📦 Step 7/9: Updating API routes...');
        $this->updateRoutes();

        // Step 8: Run Migrations
        $this->info('📦 Step 8/9: Running migrations...');
        Artisan::call('migrate');
        $this->info('✅ Migrations completed');

        // Step 9: Seed Database
        $this->info('📦 Step 9/9: Seeding database...');
        $this->seedDatabase();

        $this->newLine();
        $this->info('========================================');
        $this->info('✅ ACL Installation Complete!');
        $this->info('========================================');
        $this->newLine();

        $this->displayTestUsers();

        return Command::SUCCESS;
    }

    protected function installSanctum()
    {
        if (!File::exists(base_path('vendor/laravel/sanctum'))) {
            $this->call('install:api');
            $this->info('✅ Laravel Sanctum installed');
        } else {
            $this->info('✅ Laravel Sanctum already installed');
        }
    }

    protected function createMigrations()
    {
        $migrations = [
            '2024_10_22_000001_create_practices_table.php',
            '2024_10_22_000002_create_roles_table.php',
            '2024_10_22_000003_create_permissions_table.php',
            '2024_10_22_000004_create_role_permissions_table.php',
            '2024_10_22_000005_modify_users_table.php',
            '2024_10_22_000006_create_user_roles_table.php',
            '2024_10_22_000007_create_audit_logs_table.php',
        ];

        foreach ($migrations as $migration) {
            $this->createMigrationFile($migration);
        }

        $this->info('✅ Created 7 migration files');
    }

    protected function createMigrationFile($filename)
    {
        $path = database_path('migrations/' . $filename);

        $content = match($filename) {
            '2024_10_22_000001_create_practices_table.php' => $this->getPracticesMigration(),
            '2024_10_22_000002_create_roles_table.php' => $this->getRolesMigration(),
            '2024_10_22_000003_create_permissions_table.php' => $this->getPermissionsMigration(),
            '2024_10_22_000004_create_role_permissions_table.php' => $this->getRolePermissionsMigration(),
            '2024_10_22_000005_modify_users_table.php' => $this->getModifyUsersMigration(),
            '2024_10_22_000006_create_user_roles_table.php' => $this->getUserRolesMigration(),
            '2024_10_22_000007_create_audit_logs_table.php' => $this->getAuditLogsMigration(),
            default => ''
        };

        File::put($path, $content);
    }

    protected function createSeeders()
    {
        $this->createSeederFile('RolesSeeder.php', $this->getRolesSeeder());
        $this->createSeederFile('PermissionsSeeder.php', $this->getPermissionsSeeder());
        $this->createSeederFile('RolePermissionsSeeder.php', $this->getRolePermissionsSeeder());
        $this->createSeederFile('TestUsersSeeder.php', $this->getTestUsersSeeder());

        $this->info('✅ Created 4 seeder files');
    }

    protected function createSeederFile($filename, $content)
    {
        $path = database_path('seeders/' . $filename);
        File::put($path, $content);
    }

    protected function createModels()
    {
        $this->createModelFile('Practice.php', $this->getPracticeModel());
        $this->createModelFile('Role.php', $this->getRoleModel());
        $this->createModelFile('Permission.php', $this->getPermissionModel());
        $this->createModelFile('AuditLog.php', $this->getAuditLogModel());

        // Update User model
        $this->updateUserModel();

        $this->info('✅ Created/Updated 5 model files');
    }

    protected function createModelFile($filename, $content)
    {
        $path = app_path('Models/' . $filename);
        File::put($path, $content);
    }

    protected function createControllers()
    {
        $this->createControllerFile('AuthController.php', $this->getAuthController());
        $this->createControllerFile('UserController.php', $this->getUserController());

        $this->info('✅ Created 2 controller files');
    }

    protected function createControllerFile($filename, $content)
    {
        $path = app_path('Http/Controllers/' . $filename);
        File::put($path, $content);
    }

    protected function createMiddleware()
    {
        $this->createMiddlewareFile('CheckPermission.php', $this->getCheckPermissionMiddleware());
        $this->createMiddlewareFile('LogActivity.php', $this->getLogActivityMiddleware());

        $this->info('✅ Created 2 middleware files');
    }

    protected function createMiddlewareFile($filename, $content)
    {
        $path = app_path('Http/Middleware/' . $filename);
        File::put($path, $content);
    }

    protected function updateRoutes()
    {
        $routesPath = base_path('routes/api.php');
        $content = $this->getApiRoutes();
        File::put($routesPath, $content);

        $this->info('✅ Updated API routes');
    }

    protected function seedDatabase()
    {
        Artisan::call('db:seed', ['--class' => 'RolesSeeder']);
        $this->info('✅ Roles seeded');

        Artisan::call('db:seed', ['--class' => 'PermissionsSeeder']);
        $this->info('✅ Permissions seeded');

        Artisan::call('db:seed', ['--class' => 'RolePermissionsSeeder']);
        $this->info('✅ Role permissions seeded');

        Artisan::call('db:seed', ['--class' => 'TestUsersSeeder']);
        $this->info('✅ Test users created');
    }

    protected function displayTestUsers()
    {
        $this->info('🎯 Test User Credentials:');
        $this->newLine();

        $users = [
            ['Role' => 'Admin', 'Email' => 'admin@nymodental.com', 'Password' => 'password'],
            ['Role' => 'Dentist', 'Email' => 'dentist@nymodental.com', 'Password' => 'password'],
            ['Role' => 'Hygienist', 'Email' => 'hygienist@nymodental.com', 'Password' => 'password'],
            ['Role' => 'Front Desk', 'Email' => 'frontdesk@nymodental.com', 'Password' => 'password'],
            ['Role' => 'Patient', 'Email' => 'patient@nymodental.com', 'Password' => 'password'],
        ];

        $this->table(['Role', 'Email', 'Password'], $users);

        $this->newLine();
        $this->info('🚀 Next Steps:');
        $this->info('1. Start server: php artisan serve');
        $this->info('2. Test login: POST http://localhost:8000/api/login');
        $this->info('3. Use credentials above');
    }

    // Migration content methods
    protected function getPracticesMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->default('United Kingdom');
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('logo_url', 500)->nullable();
            $table->string('timezone', 50)->default('Europe/London');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('practices');
    }
};
PHP;
    }

    protected function getRolesMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->integer('hierarchy_level')->default(3);
            $table->boolean('is_staff')->default(true);
            $table->boolean('is_provider')->default(false);
            $table->boolean('is_external')->default(false);
            $table->string('color', 7)->default('#6B7280');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
PHP;
    }

    protected function getPermissionsMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('permission_key', 100)->unique();
            $table->string('module', 50);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('module');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
PHP;
    }

    protected function getRolePermissionsMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('role_id', 50);
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(['role_id', 'permission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
PHP;
    }

    protected function getModifyUsersMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('practice_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('phone', 20)->nullable();
            $table->string('avatar_url', 500)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_locked')->default(false);
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('last_login_at')->nullable();

            $table->index(['practice_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['practice_id']);
            $table->dropColumn([
                'practice_id',
                'phone',
                'avatar_url',
                'is_active',
                'is_locked',
                'failed_login_attempts',
                'last_login_at'
            ]);
        });
    }
};
PHP;
    }

    protected function getUserRolesMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role_id', 50);
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(['user_id', 'role_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
PHP;
    }

    protected function getAuditLogsMigration()
    {
        return <<<'PHP'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action', 100);
            $table->string('resource_type', 100)->nullable();
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'action', 'created_at']);
            $table->index(['resource_type', 'resource_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
PHP;
    }

    // Seeder content methods will continue...
    protected function getRolesSeeder()
    {
        return <<<'PHP'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 'ROLE_ADMIN',
                'name' => 'Practice Owner/Admin',
                'description' => 'Full system access, practice management, and configuration',
                'hierarchy_level' => 1,
                'is_staff' => true,
                'is_provider' => false,
                'is_external' => false,
                'color' => '#DC2626',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'ROLE_DENTIST',
                'name' => 'Dentist',
                'description' => 'Clinical provider with full patient care access',
                'hierarchy_level' => 2,
                'is_staff' => true,
                'is_provider' => true,
                'is_external' => false,
                'color' => '#2563EB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'ROLE_HYGIENIST',
                'name' => 'Dental Hygienist',
                'description' => 'Hygiene provider with limited clinical access',
                'hierarchy_level' => 3,
                'is_staff' => true,
                'is_provider' => true,
                'is_external' => false,
                'color' => '#059669',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'ROLE_FRONT_DESK',
                'name' => 'Front Desk/Receptionist',
                'description' => 'Administrative staff with scheduling and billing access',
                'hierarchy_level' => 4,
                'is_staff' => true,
                'is_provider' => false,
                'is_external' => false,
                'color' => '#7C3AED',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'ROLE_PATIENT',
                'name' => 'Patient',
                'description' => 'External user with limited self-service access',
                'hierarchy_level' => 5,
                'is_staff' => false,
                'is_provider' => false,
                'is_external' => true,
                'color' => '#6B7280',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('roles')->insert($roles);
    }
}
PHP;
    }

    protected function getPermissionsSeeder()
    {
        return <<<'PHP'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Patient Management
            ['permission_key' => 'patients.view', 'module' => 'patients', 'description' => 'View patient records'],
            ['permission_key' => 'patients.create', 'module' => 'patients', 'description' => 'Create new patients'],
            ['permission_key' => 'patients.edit', 'module' => 'patients', 'description' => 'Edit patient information'],
            ['permission_key' => 'patients.delete', 'module' => 'patients', 'description' => 'Delete patient records'],

            // Appointments
            ['permission_key' => 'appointments.view', 'module' => 'appointments', 'description' => 'View appointments'],
            ['permission_key' => 'appointments.create', 'module' => 'appointments', 'description' => 'Create appointments'],
            ['permission_key' => 'appointments.edit', 'module' => 'appointments', 'description' => 'Edit appointments'],
            ['permission_key' => 'appointments.delete', 'module' => 'appointments', 'description' => 'Delete appointments'],

            // Treatment Plans
            ['permission_key' => 'treatment_plans.view', 'module' => 'treatment_plans', 'description' => 'View treatment plans'],
            ['permission_key' => 'treatment_plans.create', 'module' => 'treatment_plans', 'description' => 'Create treatment plans'],
            ['permission_key' => 'treatment_plans.edit', 'module' => 'treatment_plans', 'description' => 'Edit treatment plans'],
            ['permission_key' => 'treatment_plans.approve', 'module' => 'treatment_plans', 'description' => 'Approve treatment plans'],

            // Clinical Notes
            ['permission_key' => 'clinical_notes.view', 'module' => 'clinical_notes', 'description' => 'View clinical notes'],
            ['permission_key' => 'clinical_notes.create', 'module' => 'clinical_notes', 'description' => 'Create clinical notes'],
            ['permission_key' => 'clinical_notes.edit', 'module' => 'clinical_notes', 'description' => 'Edit clinical notes'],

            // Billing
            ['permission_key' => 'billing.view', 'module' => 'billing', 'description' => 'View billing information'],
            ['permission_key' => 'billing.create', 'module' => 'billing', 'description' => 'Create invoices'],
            ['permission_key' => 'billing.edit', 'module' => 'billing', 'description' => 'Edit billing records'],
            ['permission_key' => 'billing.process_payments', 'module' => 'billing', 'description' => 'Process payments'],

            // NHS Claims
            ['permission_key' => 'nhs_claims.view', 'module' => 'nhs_claims', 'description' => 'View NHS claims'],
            ['permission_key' => 'nhs_claims.create', 'module' => 'nhs_claims', 'description' => 'Create NHS claims'],
            ['permission_key' => 'nhs_claims.submit', 'module' => 'nhs_claims', 'description' => 'Submit NHS claims'],

            // Reports
            ['permission_key' => 'reports.view', 'module' => 'reports', 'description' => 'View reports'],
            ['permission_key' => 'reports.financial', 'module' => 'reports', 'description' => 'View financial reports'],
            ['permission_key' => 'reports.clinical', 'module' => 'reports', 'description' => 'View clinical reports'],

            // User Management
            ['permission_key' => 'users.view', 'module' => 'users', 'description' => 'View users'],
            ['permission_key' => 'users.create', 'module' => 'users', 'description' => 'Create users'],
            ['permission_key' => 'users.edit', 'module' => 'users', 'description' => 'Edit users'],
            ['permission_key' => 'users.delete', 'module' => 'users', 'description' => 'Delete users'],

            // Practice Settings
            ['permission_key' => 'settings.view', 'module' => 'settings', 'description' => 'View practice settings'],
            ['permission_key' => 'settings.edit', 'module' => 'settings', 'description' => 'Edit practice settings'],

            // Audit Logs
            ['permission_key' => 'audit_logs.view', 'module' => 'audit_logs', 'description' => 'View audit logs'],
        ];

        foreach ($permissions as &$permission) {
            $permission['created_at'] = now();
            $permission['updated_at'] = now();
        }

        DB::table('permissions')->insert($permissions);
    }
}
PHP;
    }

    protected function getRolePermissionsSeeder()
    {
        return <<<'PHP'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Admin gets all permissions
        $allPermissions = DB::table('permissions')->pluck('id');
        foreach ($allPermissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => 'ROLE_ADMIN',
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Dentist permissions
        $dentistPermissions = [
            'patients.view', 'patients.create', 'patients.edit',
            'appointments.view', 'appointments.create', 'appointments.edit',
            'treatment_plans.view', 'treatment_plans.create', 'treatment_plans.edit', 'treatment_plans.approve',
            'clinical_notes.view', 'clinical_notes.create', 'clinical_notes.edit',
            'billing.view',
            'nhs_claims.view', 'nhs_claims.create',
            'reports.view', 'reports.clinical',
        ];
        $this->assignPermissions('ROLE_DENTIST', $dentistPermissions);

        // Hygienist permissions
        $hygienistPermissions = [
            'patients.view',
            'appointments.view',
            'treatment_plans.view',
            'clinical_notes.view', 'clinical_notes.create',
        ];
        $this->assignPermissions('ROLE_HYGIENIST', $hygienistPermissions);

        // Front Desk permissions
        $frontDeskPermissions = [
            'patients.view', 'patients.create', 'patients.edit',
            'appointments.view', 'appointments.create', 'appointments.edit', 'appointments.delete',
            'billing.view', 'billing.create', 'billing.process_payments',
            'reports.view',
        ];
        $this->assignPermissions('ROLE_FRONT_DESK', $frontDeskPermissions);

        // Patient permissions
        $patientPermissions = [
            'appointments.view',
            'billing.view',
        ];
        $this->assignPermissions('ROLE_PATIENT', $patientPermissions);
    }

    protected function assignPermissions($roleId, $permissionKeys)
    {
        foreach ($permissionKeys as $key) {
            $permission = DB::table('permissions')->where('permission_key', $key)->first();
            if ($permission) {
                DB::table('role_permissions')->insert([
                    'role_id' => $roleId,
                    'permission_id' => $permission->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
PHP;
    }

    protected function getTestUsersSeeder()
    {
        return <<<'PHP'
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create default practice
        $practiceId = DB::table('practices')->insertGetId([
            'name' => 'NymoDental Demo Practice',
            'address' => '123 High Street',
            'city' => 'London',
            'state' => 'Greater London',
            'postal_code' => 'W1A 1AA',
            'country' => 'United Kingdom',
            'phone' => '+44 20 1234 5678',
            'email' => 'contact@nymodental.com',
            'timezone' => 'Europe/London',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@nymodental.com',
                'role_id' => 'ROLE_ADMIN',
            ],
            [
                'name' => 'Dr. John Smith',
                'email' => 'dentist@nymodental.com',
                'role_id' => 'ROLE_DENTIST',
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'hygienist@nymodental.com',
                'role_id' => 'ROLE_HYGIENIST',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'frontdesk@nymodental.com',
                'role_id' => 'ROLE_FRONT_DESK',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'patient@nymodental.com',
                'role_id' => 'ROLE_PATIENT',
            ],
        ];

        foreach ($users as $userData) {
            $userId = DB::table('users')->insertGetId([
                'practice_id' => $practiceId,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'is_active' => true,
                'is_locked' => false,
                'failed_login_attempts' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $userData['role_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
PHP;
    }

    // Model content methods
    protected function getPracticeModel()
    {
        return <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Practice extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'phone',
        'email',
        'website',
        'logo_url',
        'timezone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
PHP;
    }

    protected function getRoleModel()
    {
        return <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'hierarchy_level',
        'is_staff',
        'is_provider',
        'is_external',
        'color',
    ];

    protected $casts = [
        'hierarchy_level' => 'integer',
        'is_staff' => 'boolean',
        'is_provider' => 'boolean',
        'is_external' => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
PHP;
    }

    protected function getPermissionModel()
    {
        return <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'permission_key',
        'module',
        'description',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
PHP;
    }

    protected function getAuditLogModel()
    {
        return <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'resource_type',
        'resource_id',
        'description',
        'metadata',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
PHP;
    }

    protected function updateUserModel()
    {
        $content = <<<'PHP'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'practice_id',
        'name',
        'email',
        'password',
        'phone',
        'avatar_url',
        'is_active',
        'is_locked',
        'failed_login_attempts',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_locked' => 'boolean',
        'failed_login_attempts' => 'integer',
    ];

    public function practice(): BelongsTo
    {
        return $this->belongsTo(Practice::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('permission_key', $permission);
            })
            ->exists();
    }

    public function hasRole(string $roleId): bool
    {
        return $this->roles()->where('id', $roleId)->exists();
    }

    public function getPermissions(): array
    {
        return $this->roles()
            ->with('permissions')
            ->get()
            ->pluck('permissions')
            ->flatten()
            ->pluck('permission_key')
            ->unique()
            ->values()
            ->toArray();
    }
}
PHP;

        $path = app_path('Models/User.php');
        File::put($path, $content);
    }

    // Controller content methods
    protected function getAuthController()
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->is_locked) {
            throw ValidationException::withMessages([
                'email' => ['Account is locked. Please contact administrator.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Account is inactive. Please contact administrator.'],
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            $user->increment('failed_login_attempts');

            if ($user->failed_login_attempts >= 5) {
                $user->update(['is_locked' => true]);
            }

            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Reset failed attempts
        $user->update([
            'failed_login_attempts' => 0,
            'last_login_at' => now(),
        ]);

        // Create token
        $token = $user->createToken('auth-token')->plainTextToken;

        // Load relationships
        $user->load(['roles.permissions', 'practice']);

        // Log activity
        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login',
            'description' => 'User logged in',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'practice' => $user->practice,
                'roles' => $user->roles,
                'permissions' => $user->getPermissions(),
            ],
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'logout',
            'description' => 'User logged out',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user()->load(['roles.permissions', 'practice']);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'practice' => $user->practice,
                'roles' => $user->roles,
                'permissions' => $user->getPermissions(),
            ],
        ]);
    }
}
PHP;
    }

    protected function getUserController()
    {
        return <<<'PHP'
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['roles', 'practice'])
            ->when($request->practice_id, function ($query, $practiceId) {
                $query->where('practice_id', $practiceId);
            })
            ->paginate(20);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'practice_id' => 'required|exists:practices,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|string|max:20',
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'practice_id' => $validated['practice_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'is_active' => true,
        ]);

        $user->roles()->attach($validated['role_ids']);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->load('roles'),
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json($user->load(['roles.permissions', 'practice']));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'sometimes|boolean',
            'role_ids' => 'sometimes|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        if (isset($validated['role_ids'])) {
            $user->roles()->sync($validated['role_ids']);
            unset($validated['role_ids']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->load('roles'),
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully',
        ]);
    }
}
PHP;
    }

    // Middleware content methods
    protected function getCheckPermissionMiddleware()
    {
        return <<<'PHP'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!$request->user()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        if (!$request->user()->hasPermission($permission)) {
            return response()->json([
                'message' => 'Forbidden',
                'error' => "You do not have permission: {$permission}",
            ], 403);
        }

        return $next($request);
    }
}
PHP;
    }

    protected function getLogActivityMiddleware()
    {
        return <<<'PHP'
<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->user()) {
            AuditLog::create([
                'user_id' => $request->user()->id,
                'action' => $request->method() . ' ' . $request->path(),
                'description' => 'API request',
                'metadata' => [
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'status_code' => $response->status(),
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        return $response;
    }
}
PHP;
    }

    // Routes content
    protected function getApiRoutes()
    {
        return <<<'PHP'
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Users
    Route::middleware('can:users.view')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
    });

    Route::middleware('can:users.create')->group(function () {
        Route::post('/users', [UserController::class, 'store']);
    });

    Route::middleware('can:users.edit')->group(function () {
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::patch('/users/{user}', [UserController::class, 'update']);
    });

    Route::middleware('can:users.delete')->group(function () {
        Route::delete('/users/{user}', [UserController::class, 'destroy']);
    });
});

Route::get('/', function () {
    return response()->json([
        'message' => 'NymoDental API',
        'version' => '1.0.0',
        'status' => 'active',
    ]);
});
PHP;
    }
}
