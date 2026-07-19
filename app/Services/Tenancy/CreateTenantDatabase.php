<?php
namespace App\Services\Tenancy;
use App\Models\Central\Tenant; use Illuminate\Database\DatabaseManager; use RuntimeException;
/**
 * @deprecated Retained temporarily during the shared-schema tenancy transition.
 * Do not add new dependencies. Removal requires completion of the approved
 * transition plan and isolation tests.
 */
final class CreateTenantDatabase { public function __construct(private DatabaseManager $db,private TenantDatabaseName $names){} public function __invoke(Tenant $tenant):bool { $name=$this->names->for($tenant); if($tenant->database_name!==$name) throw new RuntimeException('Tenant database identity conflict.'); $connection=$this->db->connection('provisioning'); $exists=(bool)$connection->selectOne('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?',[$name]); if($exists)return false; $connection->unprepared('CREATE DATABASE '.$this->names->quote($name).' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); return true; } }
