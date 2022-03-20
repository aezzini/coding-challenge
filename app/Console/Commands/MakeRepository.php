<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Repository from command line';

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
        $name = $this->ask('Please proive the repository name (Ex. Product)');

        if(empty($name)){
            $this->error("Not enough arguments (missing: \"repository name\").");
            return 0;
        }

        $repositoryName = ucfirst($name);
        if(!str_contains($name, "Repository")){
            $repositoryName = ucfirst(strtolower($name));
            $repositoryName.= "Repository";
        }

        $filesystem = new Filesystem();
        $repositoryDir = app_path().DIRECTORY_SEPARATOR."repositories".DIRECTORY_SEPARATOR;
        $repositoryFilePath = $repositoryDir.$repositoryName.".php";

        /**
         * Check if repository exists already
         */
        if($filesystem->exists($repositoryFilePath)){
            $this->error("Repository file exists already... ($repositoryFilePath)");
            return 0;
        }

        /**
         * Create the repository file from Mock
         */
        $mockDir = __DIR__.DIRECTORY_SEPARATOR."Mocks".DIRECTORY_SEPARATOR;
        $filesystem->copy($mockDir."Repository.mock",$repositoryFilePath);
        $filesystem->replaceInFile(["#NAME#", "#sNAME#"],[$name, lcfirst($name)],$repositoryFilePath);

        $this->info("Repository file created successfully... ($repositoryFilePath)");

        return 0;
    }
}
