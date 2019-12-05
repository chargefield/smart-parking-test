<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Parking\RateManager;

class RateManagerTest extends TestCase
{
    /** @test */
    public function add_rates_to_the_collection()
    {
        $rates = (new RateManager)
            ->add(6, 250)
            ->add(3, 450)
            ->add(1, 300)
            ->add(6, 675)
            ->max(1015)
            ->all();

        $this->assertCount(4, $rates);

        $this->assertEquals('1hr - $3.00', $rates[0]->label());
        $this->assertEquals(1, $rates[0]->duration());
        $this->assertEquals(300, $rates[0]->amount());

        $this->assertEquals('3hr - $4.50', $rates[1]->label());
        $this->assertEquals(3, $rates[1]->duration());
        $this->assertEquals(450, $rates[1]->amount());

        $this->assertEquals('6hr - $6.75', $rates[2]->label());
        $this->assertEquals(6, $rates[2]->duration());
        $this->assertEquals(675, $rates[2]->amount());

        $this->assertEquals('All Day - $10.15', $rates[3]->label());
        $this->assertEquals(24, $rates[3]->duration());
        $this->assertEquals(1015, $rates[3]->amount());
        $this->assertTrue($rates[3]->isMax());
    }

    /** @test */
    public function get_the_correct_rate_from_a_given_duration()
    {
        $rates = (new RateManager)
            ->add(3, 450)
            ->add(1, 300)
            ->add(6, 675)
            ->max(1015);

        $rate = $rates->getRateFromDuration(5);

        $this->assertNotNull($rate);

        $this->assertEquals('6hr - $6.75', $rate->label());
        $this->assertEquals(6, $rate->duration());
        $this->assertEquals(675, $rate->amount());

        $rate = $rates->getRateFromDuration(1);

        $this->assertNotNull($rate);

        $this->assertEquals('1hr - $3.00', $rate->label());
        $this->assertEquals(1, $rate->duration());
        $this->assertEquals(300, $rate->amount());

        $rate = $rates->getRateFromDuration(2);

        $this->assertNotNull($rate);

        $this->assertEquals('3hr - $4.50', $rate->label());
        $this->assertEquals(3, $rate->duration());
        $this->assertEquals(450, $rate->amount());
    }

    /** @test */
    public function it_throws_an_exception_if_max_rate_is_not_set()
    {
        $this->expectException(Exception::class);

        $rates = (new RateManager)
            ->add(3, 450)
            ->add(1, 300)
            ->add(6, 675);

        $rates->getRateFromDuration(10);
    }

    /** @test */
    public function get_the_max_rate_from_a_given_duration_larger_than_max_hours()
    {
        $rates = (new RateManager)
            ->add(3, 450)
            ->add(1, 300)
            ->add(6, 675)
            ->max(1015);

        $rate = $rates->getRateFromDuration(50);

        $this->assertNotNull($rate);

        $this->assertEquals('All Day - $10.15', $rate->label());
        $this->assertEquals(24, $rate->duration());
        $this->assertEquals(1015, $rate->amount());
    }
}
