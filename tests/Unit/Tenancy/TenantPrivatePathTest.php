<?php
use App\Support\TenantPrivatePath;
it('rejects traversal before resolving a tenant path', function () { (new TenantPrivatePath)->path('../outside'); })->throws(InvalidArgumentException::class);
