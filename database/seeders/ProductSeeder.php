<?php

namespace Database\Seeders;

use App\Models\Product;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App/Product');
        $categories = DB::table('categories')->select("id")->get();

        foreach (range(1, 20) as $i) {
            $product_categories = [];
            if ($faker->boolean()) {
                foreach (range(0, $faker->numberBetween(0, 5)) as $j) {
                    $product_categories[] = $categories[$faker->numberBetween(0, count($categories) - 1)]->id;
                }
            }

            $product = Product::create([
                'name' => strtoupper($faker->sentence(1)),
                'description' => $faker->sentence(3),
                'price' => $faker->randomFloat(3, 0, 1000),
                'created_at' => Carbon::now(),
            ]);

            if ($faker->boolean()) {
                $img = $faker->numberBetween(1, 5) . ".png";
                $from = public_path("seeds_images" . DIRECTORY_SEPARATOR . $img);

                $upload_dir = storage_path("app" . DIRECTORY_SEPARATOR . "uploads");
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir);
                }

                $to = $upload_dir . DIRECTORY_SEPARATOR . md5($img . rand() . uniqid()) . "." . pathinfo($from, PATHINFO_EXTENSION);
                copy($from, $to);
                $product->setImageAttribute(basename($to), false);
            }

            if ($categories) {
                $product->categories()->sync($product_categories);
                $product->save();
            }
        }
    }
}
