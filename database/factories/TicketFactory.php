<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'paid_at' => null,
    ];
});

$factory->state(Ticket::class, 'paid', function (Faker $faker) {
    return [
        'paid_at' => now(),
    ];
});
