<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FullCalendar;

class FullCalendarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-11-25',
            'end' =>'2021-11-27',
            'colorCode' => '#A9FB03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-11-25',
            'end' =>'2021-11-27',
            'colorCode' => '#A9FB03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-10-25',
            'end' =>'2021-11-02',
            'colorCode' => '#FB7F03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-12-20',
            'end' =>'2021-12-27',
            'colorCode' => '#FBEF03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-01-25',
            'end' =>'2022-01-27',
            'colorCode' => '#A9FB03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2021-11-15',
            'end' =>'2021-11-26',
            'colorCode' => '#FB7F03'
        ]);


        FullCalendar::create([
            'title' => 'Exam',
            'start' => '2022-11-25',
            'end' =>'2022-11-27',
            'colorCode' => '#FBEF03'
        ]);
    }
}
