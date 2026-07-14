<?php

test('application boots successfully', fn () => expect(app())->not->toBeNull());
test('environment is testing during tests', fn () => expect(app()->environment())->toBe('testing'));
test('database connectivity can be checked when configured', fn () => expect(config('database.default'))->not->toBeNull());
