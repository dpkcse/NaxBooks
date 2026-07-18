<?php
namespace App\Support;
use App\Tenancy\TenantContext;
final class TenantPrivatePath { public function path(string $subpath=''): string { $parts=array_filter(explode('/',str_replace('\\','/',$subpath)),fn($part)=>$part!=='' && $part!=='.'); if(in_array('..',$parts,true)) throw new \InvalidArgumentException('Invalid tenant path.'); return storage_path(config('tenancy.private_root').'/'.app(TenantContext::class)->id().($parts ? '/'.implode('/',$parts) : '')); } }
