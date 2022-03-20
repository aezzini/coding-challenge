<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Service from command line';

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
        $name = $this->ask('Please proive the service name (Ex. Product)');

        if(empty($name)){
            $this->error("Not enough arguments (missing: \"service name\").");
            return 0;
        }

        $serviceName = ucfirst($name);
        if(!str_contains($name, "Service")){
            $serviceName = ucfirst(strtolower($name));
            $serviceName.= "Service";
        }

        $filesystem = new Filesystem();
        $serviceDir = app_path().DIRECTORY_SEPARATOR."Services".DIRECTORY_SEPARATOR;
        $serviceFilePath = $serviceDir.$serviceName.".php";

        /**
         * Check if service exists already
         */
        if($filesystem->exists($serviceFilePath)){
            $this->error("Service file exists already... ($serviceFilePath)");
            return 0;
        }

        /**
         * Create the service file from Mock
         */
        $mockDir = __DIR__.DIRECTORY_SEPARATOR."Mocks".DIRECTORY_SEPARATOR;
        $filesystem->copy($mockDir."Service.mock",$serviceFilePath);
        $filesystem->replaceInFile(["#NAME#", "#sNAME#"],[$name, lcfirst($name)],$serviceFilePath);

        $this->info("Service file created successfully... ($serviceFilePath)");

        return 0;
    }
}
