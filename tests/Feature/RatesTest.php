<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Parking\Facades\Rates;

class RatesTest extends TestCase
{
    /** @test */
    public function get_rates()
    {
        Rates::fake()
            ->add(1, 300)
            ->add(3, 450)
            ->add(6, 675)
            ->max(1015);

        $response = $this->get(route('api.rates'));

        $response->assertOk();
        $response->assertExactJson([
            [
                'label' => '1hr - $3.00',
                'hours' => '1hr',
                'price' => '$3.00',
                'duration' => 1,
                'amount' => 300,
                'isMax' => false,
            ],
            [
                'label' => '3hr - $4.50',
                'hours' => '3hr',
                'price' => '$4.50',
                'duration' => 3,
                'amount' => 450,
                'isMax' => false,
            ],
            [
                'label' => '6hr - $6.75',
                'hours' => '6hr',
                'price' => '$6.75',
                'duration' => 6,
                'amount' => 675,
                'isMax' => false,
            ],
            [
                'label' => 'All Day - $10.15',
                'hours' => '24hr',
                'price' => '$10.15',
                'duration' => 24,
                'amount' => 1015,
                'isMax' => true,
            ],
        ]);
    }
}
