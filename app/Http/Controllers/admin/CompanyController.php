<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Company;
use App\Models\admin\PricingPlans;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\admin\StoreCompanyRequest;
use App\DataTables\CompanyDataTable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;
use PDO;

class CompanyController extends Controller
{
    public function index(CompanyDataTable $dataTable)
    {
        return $dataTable->render('admin.company.index');
    }

    public function createOrEdit($id = null)
    {
        $pricingPlans = PricingPlans::all();
        $company = $id ? Company::findOrFail($id) : new Company();
        return view('admin.company.form', compact('company', 'pricingPlans'));
        // use one blade `form.blade.php` for both create & edit
    }

    public function storeOrUpdate(StoreCompanyRequest $request)
    {
        $id = $request->id;

        if ($id) {
            // update
            $company = Company::findOrFail($id);
        } else {
            $company = $request->validated();
        }

        // Handle logo
        $logoPath = $company->logo ?? null;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $originalName = $request->file('logo')->getClientOriginalName();
            $timestampedName = time() . '_' . $originalName; // e.g., 1695297600_logo1.jpg
            $logoPath = $request->file('logo')->storeAs('company_logo', $timestampedName, 'public');
        }

        if ($id) {
            /** ------------------------
             * UPDATE COMPANY
             * ----------------------- */
            $ownerUser = $company->owner;

            // User update
            if ($ownerUser) {
                $ownerUser->update([
                    'name'  => $request->owner_name,
                    'email' => $request->owner_email,
                ]);
            }

            $company->update([
                'name' => $request->name,
                'logo' => $logoPath,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip' => $request->zip,
                'owner_name' => $request->owner_name,
                'owner_email' => $request->owner_email,
                'owner_mobile' => $request->owner_mobile,
                'owner_designation' => $request->owner_designation,
                'domain' => $request->domain,
                'status' => $request->status,
                'plan_id' => $request->plan_id,
            ]);
        } else {

            $user = User::create([
                'name'     => $request->owner_name,
                'email'    => $request->owner_email,
                'password' => Hash::make(Str::random(10)),
            ]);
            $user->assignRole('company'); // spatie role

            /** ------------------------
             * CREATE COMPANY
             * ----------------------- */
            $dbName = 'tenant_' . strtolower(preg_replace('/\s+/', '_', $request->name));

            $company = Company::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'slug' => null,
                'logo' => $logoPath,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zip' => $request->zip,
                'owner_name' => $request->owner_name,
                'owner_email' => $request->owner_email,
                'owner_mobile' => $request->owner_mobile,
                'owner_designation' => $request->owner_designation,
                'db_host' => '127.0.0.1',
                'db_port' => '3306',
                'db_name' => $dbName,
                'db_username' => 'tenant_admin', // fixed
                'db_password' => 'tenant123',   // fixed
                'domain' => $request->domain,
                'status' => $request->status,
                'plan_id' => $request->plan_id,
            ]);

            try {
                $this->createTenantDatabase($company);
                $this->runTenantMigrations($company);
                $this->createTenantOwner($company, $user->password ?? null);
            } catch (Exception $e) {
                if ($logoPath) Storage::disk('public')->delete($logoPath);
                $company->delete();
                return redirect()->route('companies.index')->with('error','ERROR: ' . $e->getMessage());
            }
        }

        $message = $company->wasRecentlyCreated ? 'created successfully' : 'updated successfully';
        return redirect()->route('companies.index')->with('success','Company ' . $message);
    }

    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        $company->delete();
        return back()->with('success', 'Company deleted.');
    }

    /** ========== Tenant Helpers ========== */
    protected function createTenantDatabase(Company $company)
    {
        $host = env('TENANT_DB_SUPER_HOST', '127.0.0.1');
        $port = env('TENANT_DB_SUPER_PORT', '3306');
        $user = env('TENANT_DB_SUPER_USERNAME');
        $pass = env('TENANT_DB_SUPER_PASSWORD');
        if (empty($user)) {
            throw new Exception("TENANT_DB_SUPER_USERNAME not configured.");
        }

        $charset = env('TENANT_DB_DEFAULT_CHARSET', 'utf8mb4');
        $collation = env('TENANT_DB_DEFAULT_COLLATION', 'utf8mb4_unicode_ci');

        $dsn = "mysql:host={$host};port={$port}";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $dbName = $company->db_name;
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET {$charset} COLLATE {$collation}");
    }

    protected function runTenantMigrations(Company $company)
    {
        config([
            'database.connections.tenant' => [
                'driver'    => 'mysql',
                'host'      => $company->db_host,
                'port'      => $company->db_port,
                'database'  => $company->db_name,
                'username'  => $company->db_username,
                'password'  => $company->db_password,
                'charset'   => env('TENANT_DB_DEFAULT_CHARSET', 'utf8mb4'),
                'collation' => env('TENANT_DB_DEFAULT_COLLATION', 'utf8mb4_unicode_ci'),
                'prefix'    => '',
                'strict'    => true,
                'engine'    => null,
            ]
        ]);

        DB::purge('tenant');

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path'     => 'database/migrations/tenant',
            '--force'    => true,
        ]);
    }

    protected function createTenantOwner($company, $password = null)
    {
        DB::connection('tenant')->table('users')->insert([
            'name' => $company->owner_name,
            'email' => $company->owner_email,
            'password' => $password,
            'phone' => $company->owner_mobile ?? null,
            'designation' => $company->owner_designation ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
