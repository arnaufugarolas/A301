<?php

namespace Tests\Unit;

use Tests\TestCase;

class BookingTest extends TestCase
{

    const mockData = [
        [
            'start_date' => '2023-03-03',
            'start_time' => '10:00',
            'end_date' => '2023-03-03',
            'end_time' => '12:00',
            'result' => 201
        ],
        [
            'start_date' => '2023-03-03',
            'start_time' => '10:00',
            'end_date' => '2023-03-03',
            'end_time' => '09:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-01',
            'start_time' => '10:00',
            'end_date' => '2023-03-13',
            'end_time' => '12:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-04',
            'start_time' => '08:00',
            'end_date' => '2023-03-04',
            'end_time' => '09:00',
            'result' => 201
        ],
        [
            'start_date' => '2023-03-04',
            'start_time' => '10:00',
            'end_date' => '2023-03-04',
            'end_time' => '12:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-04',
            'start_time' => '08:00',
            'end_date' => '2023-03-05',
            'end_time' => '09:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-06',
            'start_time' => '08:00',
            'end_date' => '2023-03-06',
            'end_time' => '09:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-10',
            'start_time' => '16:00',
            'end_date' => '2023-03-10',
            'end_time' => '18:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-10',
            'start_time' => '21:00',
            'end_date' => '2023-03-10',
            'end_time' => '22:00',
            'result' => 201
        ],
        [
            'start_date' => '2023-03-10',
            'start_time' => '5:00',
            'end_date' => '2023-03-11',
            'end_time' => '01:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-10',
            'start_time' => '21:00',
            'end_date' => '2023-03-11',
            'end_time' => '01:00',
            'result' => 201
        ],
        [
            'start_date' => '2023-03-11',
            'start_time' => '10:00',
            'end_date' => '2023-03-11',
            'end_time' => '12:00',
            'result' => 201
        ],
        [
            'start_date' => '2023-03-11',
            'start_time' => '10:01',
            'end_date' => '2023-03-11',
            'end_time' => '12:00',
            'result' => 400
        ],
        [
            'start_date' => '2023-03-10',
            'start_time' => '19:00',
            'end_date' => '2023-03-10',
            'end_time' => '20:00',
            'result' => 201
        ],
    ];

    public function test01()
    {
        $this->doTest(self::mockData[0]);
    }

    public function doTest($data): void
    {
        $response = $this->postJson('/api/bookings', [
            'start_date' => $data['start_date'],
            'start_time' => $data['start_time'],
            'end_date' => $data['end_date'],
            'end_time' => $data['end_time'],
            'user_id' => 1,
        ]);

        $this->delete('/api/bookings/' . $response->json('id'));

        $response->assertStatus($data['result']);
    }

    public function test02()
    {
        $this->doTest(self::mockData[1]);
    }

    public function test03()
    {
        $this->doTest(self::mockData[2]);
    }

    public function test04()
    {
        $this->doTest(self::mockData[3]);
    }

    public function test05()
    {
        $this->doTest(self::mockData[4]);
    }

    public function test06()
    {
        $this->doTest(self::mockData[5]);
    }

    public function test07()
    {
        $this->doTest(self::mockData[6]);
    }

    public function test08()
    {
        $this->doTest(self::mockData[7]);
    }

    public function test09()
    {
        $this->doTest(self::mockData[8]);
    }

    public function test10()
    {
        $this->doTest(self::mockData[9]);
    }

    public function test11()
    {
        $this->doTest(self::mockData[10]);
    }

    public function test12()
    {
        $this->doTest(self::mockData[11]);
    }

    public function test13()
    {
        $this->doTest(self::mockData[12]);
    }

    public function test14()
    {
        $this->doTest(self::mockData[13]);
    }
}
