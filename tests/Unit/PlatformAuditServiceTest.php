<?php
use App\Services\PlatformAuditService;
it('redacts sensitive fields recursively',function(){$redacted=(new PlatformAuditService)->redact(['password'=>'secret','profile'=>['token'=>'raw','name'=>'Safe']]);expect($redacted['password'])->toBe('[REDACTED]')->and($redacted['profile']['token'])->toBe('[REDACTED]')->and($redacted['profile']['name'])->toBe('Safe');});
