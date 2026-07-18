<?php
use App\Services\Tenancy\NormalizeHost;
it('normalizes a host and strips its port', function () { expect((new NormalizeHost)('DEMO.NAXBOOKS.TEST:8080'))->toBe('demo.naxbooks.test'); });
it('rejects malformed hosts', function () { (new NormalizeHost)('demo.naxbooks.test/evil'); })->throws(InvalidArgumentException::class);
