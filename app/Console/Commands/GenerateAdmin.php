<?php

namespace App\Console\Commands;

use App\Models\AdminUser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:admin {username} {password} {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate admin user';

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
     */
    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->argument('password');
        $name = $this->argument('name');

        if ($username && $password) {
            $password = Hash::make($password);
            AdminUser::create(compact('username', 'password', 'name'));
            $this->info('success to generate admin user: ' . $username);
        }
    }
}
