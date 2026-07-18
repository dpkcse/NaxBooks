<?php
namespace App\Services\Tenancy;
use InvalidArgumentException;
final class NormalizeHost
{
 public function __invoke(string $host): string { $host=strtolower(trim($host)); if (str_contains($host, ':')) { if (preg_match('/^\[([^]]+)\](?::\d+)?$/', $host, $m)) $host=$m[1]; else $host=preg_replace('/:\d+$/', '', $host) ?? ''; } $host=rtrim($host, '.'); if ($host === '' || strlen($host)>253 || !preg_match('/^(localhost|(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,63})$/', $host)) throw new InvalidArgumentException('Invalid host.'); return $host; }
}
