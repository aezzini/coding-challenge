<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Exception;
use Illuminate\Console\Command;

class CreateCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create category from command line';

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
        $name = $this->ask('Please proive the category name');
        if(empty($name)){
            $this->error("Not enough arguments (missing: \"category name\").");
            return 0;
        }

        $data = ["name" => $name];
        if($parent_category_id = $this->ask('Please proive the category parent id (optional)')){
            $data["parent_category_id"] = $parent_category_id;
        }

        $categoryRepository = new CategoryRepository(new Category());
        $categoryService = new CategoryService($categoryRepository);

        try{
            $category = $categoryService->store($data);
            $this->info("Category created successfully, id: ".$category->id);
        } catch (Exception $e) {
            $this->error("Error: ".$e->getMessage());
        }
    }
}
