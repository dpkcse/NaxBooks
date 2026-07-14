<x-layouts.app :title="$title ?? 'Authentication'" :heading="$heading ?? 'Authentication'"><div class="mx-auto max-w-md"><x-card>{{ $slot ?? '' }}@yield('content')</x-card></div></x-layouts.app>
