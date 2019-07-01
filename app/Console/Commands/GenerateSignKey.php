<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSignKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成随机 access_key 和 secret_key ';

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
        $this->info('access_key: ' . str_random(8));
        $this->info('secret_key: ' . str_random(32));
    }
}
