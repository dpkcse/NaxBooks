<x-layouts.app :title="$title ?? 'Tenant'" :heading="$heading ?? 'Tenant workspace'">{{ $slot ?? '' }}@yield('content')</x-layouts.app>
