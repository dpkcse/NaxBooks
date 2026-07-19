<?php

namespace App\Models\Tenant;

class CompanySetting extends TenantModel
{
    public const ALLOWED_KEYS = ['timezone', 'locale', 'date_format', 'number_format', 'base_currency_code'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['setting_value' => 'array'];
    }
}
