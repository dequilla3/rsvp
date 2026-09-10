<?php

it('saves a guest RSVP', function () {
    $response = $this->post(route('guests.store'), [
        'name' => 'KIM DELA CRUZ',
    ]);

    $response->assertRedirect('/');
    $response->assertSessionHas('rsvp_success');
    $this->assertDatabaseHas('guests', [
        'name' => 'KIM DELA CRUZ',
    ]);
});

it('requires a guest name', function () {
    $response = $this->post(route('guests.store'), [
        'name' => '',
    ]);

    $response->assertSessionHasErrors('name');
    $this->assertDatabaseCount('guests', 0);
});
