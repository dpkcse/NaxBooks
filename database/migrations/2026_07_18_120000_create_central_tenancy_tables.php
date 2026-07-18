<?php

use App\Enums\DomainStatus;
use App\Enums\MembershipStatus;
use App\Enums\TenantStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('central')->create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('database_name')->unique();
            $table->string('status')->default(TenantStatus::PendingProvisioning->value)->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
        Schema::connection('central')->create('domains', function (Blueprint $table) {
            $table->id();$table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();$table->string('domain')->unique();$table->string('status')->default(DomainStatus::Pending->value)->index();$table->timestamp('verified_at')->nullable();$table->timestamps();
        });
        Schema::connection('central')->create('tenant_memberships', function (Blueprint $table) {
            $table->id();$table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();$table->foreignId('user_id')->constrained('users')->restrictOnDelete();$table->string('role');$table->string('status')->default(MembershipStatus::Invited->value)->index();$table->timestamp('accepted_at')->nullable();$table->timestamps();$table->unique(['tenant_id','user_id']);
        });
        Schema::connection('central')->create('tenant_invitations', function (Blueprint $table) {
            $table->id();$table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();$table->string('email')->index();$table->string('role');$table->string('token_hash')->unique();$table->foreignId('invited_by_user_id')->nullable()->constrained('users')->nullOnDelete();$table->timestamp('accepted_at')->nullable();$table->timestamp('expires_at');$table->timestamps();
        });
        Schema::connection('central')->create('provisioning_attempts', function (Blueprint $table) {
            $table->id();$table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();$table->string('status')->index();$table->unsignedInteger('attempt')->default(1);$table->text('message')->nullable();$table->json('context')->nullable();$table->timestamp('started_at')->nullable();$table->timestamp('finished_at')->nullable();$table->timestamps();
        });
        Schema::connection('central')->create('platform_audit_logs', function (Blueprint $table) {
            $table->id();$table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();$table->string('action')->index();$table->nullableMorphs('auditable');$table->string('ip_address',45)->nullable();$table->text('user_agent')->nullable();$table->string('request_id')->nullable()->index();$table->json('metadata')->nullable();$table->timestamp('created_at')->useCurrent();
        });
    }
    public function down(): void
    {foreach(['platform_audit_logs','provisioning_attempts','tenant_invitations','tenant_memberships','domains','tenants'] as $t){Schema::connection('central')->dropIfExists($t);}}
};
