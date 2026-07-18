<?php

use App\Services\PlatformAuditService;

it('redacts sensitive values recursively, including credentials and session data', function (): void {
    $redacted = (new PlatformAuditService)->redact([
        'password' => 'secret',
        'profile' => ['authorization' => 'Bearer secret', 'name' => 'Safe'],
        'APP_KEY' => 'base64:key',
        'db_password' => 'database-secret',
        'session_id' => 'session-secret',
    ]);

    expect($redacted['password'])->toBe('[REDACTED]')
        ->and($redacted['profile']['authorization'])->toBe('[REDACTED]')
        ->and($redacted['profile']['name'])->toBe('Safe')
        ->and($redacted['APP_KEY'])->toBe('[REDACTED]')
        ->and($redacted['db_password'])->toBe('[REDACTED]')
        ->and($redacted['session_id'])->toBe('[REDACTED]');
});
