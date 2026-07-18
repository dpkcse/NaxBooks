<?php
namespace App\Services\Tenancy;
use App\Models\Central\Tenant; use Illuminate\Database\DatabaseManager; use RuntimeException;
final class CreateTenantDatabase { public function __construct(private DatabaseManager $db,private TenantDatabaseName $names){} public function __invoke(Tenant $tenant):void { $name=$this->names->for($tenant); if($tenant->database_name!==$name) throw new RuntimeException('Tenant database identity conflict.'); $connection=$this->db->connection('provisioning'); $exists=(bool)$connection->selectOne('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?',[$name]); if($exists)return; $connection->unprepared('CREATE DATABASE '.$this->names->quote($name).' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'); } }
