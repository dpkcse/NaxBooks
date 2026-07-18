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
        Schema::connection('central')->create('tenants', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('database_name')->unique();
            $table->foreignId('owner_user_id')->constrained('users')->restrictOnDelete();
            $table->string('status')->default(TenantStatus::Pending->value)->index();
            $table->dateTime('trial_starts_at')->nullable();
            $table->dateTime('trial_ends_at')->nullable();
            $table->dateTime('activated_at')->nullable();
            $table->dateTime('suspended_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->dateTime('provisioning_completed_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        Schema::connection('central')->create('domains', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->string('domain')->unique();
            $table->string('type')->default('platform')->index();
            $table->string('status')->default(DomainStatus::Pending->value)->index();
            $table->boolean('is_primary')->default(false)->index();
            $table->boolean('is_verified')->default(false)->index();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::connection('central')->create('tenant_memberships', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('role_key');
            $table->string('status')->default(MembershipStatus::Invited->value)->index();
            $table->dateTime('joined_at')->nullable();
            $table->dateTime('suspended_at')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'user_id']);
        });

        Schema::connection('central')->create('tenant_invitations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->string('email')->index();
            $table->string('token_hash')->unique();
            $table->string('intended_role_key');
            $table->foreignId('invited_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            // dateTime avoids MariaDB 10.4's invalid implicit TIMESTAMP default behavior.
            $table->dateTime('expires_at');
            $table->dateTime('accepted_at')->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->timestamps();
            $table->index(['tenant_id', 'expires_at']);
        });

        Schema::connection('central')->create('provisioning_attempts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->unsignedInteger('attempt_number');
            $table->string('status')->index();
            $table->string('current_step')->nullable();
            $table->json('completed_steps')->nullable();
            $table->string('error_code')->nullable();
            $table->text('sanitized_error_message')->nullable();
            $table->foreignId('initiated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('request_id')->nullable()->index();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('failed_at')->nullable();
            $table->timestamps();
            $table->unique(['tenant_id', 'attempt_number']);
        });

        Schema::connection('central')->create('platform_audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->nullOnDelete();
            $table->string('action')->index();
            $table->string('entity_type')->nullable();
            $table->string('entity_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('reason')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('request_id')->nullable()->index();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['tenant_id', 'action', 'created_at']);
        });
    }

    public function down(): void
    {
        foreach (['platform_audit_logs', 'provisioning_attempts', 'tenant_invitations', 'tenant_memberships', 'domains', 'tenants'] as $table) {
            Schema::connection('central')->dropIfExists($table);
        }
    }
};
