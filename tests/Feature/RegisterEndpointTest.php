<?php
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->path = '/api/register';
    $this->method = 'post';
});

it('registers a new user in database', function (){
   $email = fake()->email;

    postJson($this->path, [
       'name' => fake()->name,
       'email' => $email,
       'password' => 'password',
       'password_confirmation' => 'password',
    ]);

    assertDatabaseHas('users', [
        'email' => $email,
    ]);
});


