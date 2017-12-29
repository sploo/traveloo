<?php

namespace App\Console\Commands;

use Artisan;

use Illuminate\Console\Command;

class AppDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform Application Deployment';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('Detecting environment via GIT branch');
        $env = shell_exec('sudo git rev-parse --abbrev-ref HEAD');
        $this->info('Environment detected:' . $env);

        $proceedDeploy = $this->ask('Proceed with the Deployment (Yes/n)?');
        if($proceedDeploy != 'Yes'){
          return;
        }

        $this->info('Pull latest source code from GIT');
        $status = shell_exec('sudo git pull');
        $this->info($status);

        $this->info('Update environment file');
        $status = shell_exec("sudo cp .env.$env .env");
        $this->info($status);

        $this->info('Perform Composer install');
        $status = shell_exec('composer install');
        $this->info($status);

        $this->info('Perform Package discovery');
        $status = Artisan::call('package:discover');
        $this->info($status);

        $this->info('Perform Database Migrations');
        $status = Artisan::call('migrate');
        $this->info($status);

        $this->info('Set Folder permission');
        $status = shell_exec('sudo chmod -R 777 bootstrap storage vendor');
        $this->info($status);

    }
}
