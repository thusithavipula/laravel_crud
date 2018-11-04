<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject_categories = [
            ['id' => '1', 'name' => 'Semester 1', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '2', 'name' => 'Semester 2', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '3', 'name' => 'Semester 3', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '4', 'name' => 'Semester 4', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '5', 'name' => 'Semester 5', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => '6', 'name' => 'Semester 6', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ];
 
        DB::table('subject_categories')->insert($subject_categories);
    }
}
