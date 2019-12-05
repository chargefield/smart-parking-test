<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'paid_at' => null,
        'valid' => 1,
    ];
});

$factory->state(Ticket::class, 'paid', function (Faker $faker) {
    return [
        'paid_at' => now(),
    ];
});

$factory->state(Ticket::class, 'invalid', function (Faker $faker) {
    return [
        'valid' => 0,
    ];
});
