<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::connection('tenant')->create('tenant_system_metadata', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->unique();
            $table->uuid('installation_id')->unique();
            $table->string('database_identifier')->unique();
            $table->string('schema_version', 32);
            $table->dateTime('provisioned_at');
            $table->dateTime('last_migrated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::connection('tenant')->dropIfExists('tenant_system_metadata'); }
};
