<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App/Category');

        foreach (range(1, 10) as $i) {
            $categories = DB::table('categories')->select("id")->get();

            $parent_cat = null;
            if ($faker->boolean()) {
                $parent_cat = count($categories) ? $categories[$faker->numberBetween(0, count($categories) - 1)]->id : null;
            }

            DB::table('categories')->insert([
                'name' => strtoupper($faker->sentence(1)),
                'parent_category_id' => $parent_cat,
                'created_at' => Carbon::now(),
            ]);
        }
    }
}
