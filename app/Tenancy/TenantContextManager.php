<?php
namespace App\Tenancy;
use App\Models\Central\Tenant;
use Illuminate\Database\DatabaseManager;
use Illuminate\Config\Repository;
final class TenantContextManager
{
    public function __construct(private TenantContext $context, private DatabaseManager $database, private Repository $config) {}
    public function initialize(Tenant $tenant): void { $this->context->initialize($tenant); $connection=config('tenancy.tenant_connection'); try { $this->database->purge($connection); $this->config->set("database.connections.{$connection}.database", $tenant->database_name); $this->database->reconnect($connection); } catch (\Throwable $exception) { $this->database->purge($connection); $this->config->set("database.connections.{$connection}.database", null); $this->context->clear(); throw $exception; } }
    public function clear(): void { $connection=config('tenancy.tenant_connection'); $this->database->purge($connection); $this->config->set("database.connections.{$connection}.database", null); $this->context->clear(); }
}
