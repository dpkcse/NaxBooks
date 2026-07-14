<x-layouts.app :title="$title ?? 'Platform'" :heading="$heading ?? 'Platform workspace'">{{ $slot ?? '' }}@yield('content')</x-layouts.app>
