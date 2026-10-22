<?php

test('guest users see a branded landing page with login and registration links', function () {
    $response = $this->get(route('home'));

    $response
        ->assertOk()
        ->assertSee('Gym Body Tracker')
        ->assertSee('Bangun progres.')
        ->assertSee('Masuk')
        ->assertSee('Buat akun')
        ->assertDontSee('Laravel');
});
