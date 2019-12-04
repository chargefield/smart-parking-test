<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Parking\Rate;

class RateTest extends TestCase
{
    /** @test */
    public function it_outputs_duration()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals(3, $rate->duration());
    }

    /** @test */
    public function it_outputs_amount()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals(600, $rate->amount());
    }

    /** @test */
    public function it_outputs_hours()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals('3hr', $rate->hours());
    }

    /** @test */
    public function it_outputs_price()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals('$6.00', $rate->price());
    }

    /** @test */
    public function it_outputs_label()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals('3hr - $6.00', $rate->label());
    }

    /** @test */
    public function it_outputs_false_when_not_max_hours()
    {
        $rate = new Rate(3, 600);

        $this->assertFalse($rate->isMax());
    }

    /** @test */
    public function it_outputs_label_of_max_hours()
    {
        $rate = new Rate(24, 1000);

        $this->assertEquals('All Day - $10.00', $rate->label());
    }

    /** @test */
    public function it_outputs_true_when_not_max_hours()
    {
        $rate = new Rate(24, 1000);

        $this->assertTrue($rate->isMax());
    }

    /** @test */
    public function it_outputs_true_when_checking_correct_duration()
    {
        $rate = new Rate(3, 600);

        $this->assertTrue($rate->isDuration(3));
    }

    /** @test */
    public function it_outputs_false_when_checking_wrong_duration()
    {
        $rate = new Rate(3, 600);

        $this->assertFalse($rate->isDuration(5));
    }

    /** @test */
    public function it_outputs_true_when_checking_duration_less_than_or_equal_to_given()
    {
        $rate = new Rate(6, 1000);

        $this->assertTrue($rate->isDurationGreaterOrEqualTo(3));
    }

    /** @test */
    public function it_outputs_false_when_checking_duration_not_less_than_or_equal_to_given()
    {
        $rate = new Rate(6, 1000);

        $this->assertFalse($rate->isDurationGreaterOrEqualTo(10));
    }

    /** @test */
    public function it_output_json_serialize_array()
    {
        $rate = new Rate(3, 600);

        $this->assertEquals([
            'label' => '3hr - $6.00',
            'hours' => '3hr',
            'price' => '$6.00',
            'duration' => 3,
            'amount' => 600,
            'isMax' => false,
        ], $rate->jsonSerialize());
    }
}
