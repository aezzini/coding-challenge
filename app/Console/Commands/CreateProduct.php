<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Exception;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create product from command line';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Please proive the product name* (required)');
        if(empty($name)){
            $this->error("Not enough arguments (missing: \"product name\").");
            return 0;
        }

        $data = ["name" => $name];
        if($description = $this->ask('Please proive the product description (optional)')){
            $data["description"] = $description;
        }
        if($price = $this->ask('Please proive the product price (optional)')){
            $data["price"] = $price;
        }
        if($categories = $this->ask('Please proive the product categories (separated by ,) [ex: 1,2,3] (optional)')){
            $data["categories"] = explode(",", $categories);
        }

        $productRepository = new ProductRepository(new Product());
        $productService = new ProductService($productRepository);

        try{
            $product = $productService->store($data);
            $this->info("Product created successfully, id: ".$product->id);
        } catch (Exception $e) {
            $this->error("Error: ".$e->getMessage());
        }
    }
}
