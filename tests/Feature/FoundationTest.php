<?php

test('welcome page returns success', fn () => $this->get('/')->assertOk());
test('health endpoint returns success', fn () => $this->get('/health')->assertOk());
test('dashboard placeholder returns success', fn () => $this->get('/dashboard')->assertOk());
test('health output hides secrets', fn () => $this->get('/health')->assertJsonMissing(['DB_PASSWORD', 'APP_KEY']));
test('core layout renders navigation markup', fn () => $this->get('/dashboard')->assertSee('Tenant')->assertSee('Company')->assertSee('Accounting'));
