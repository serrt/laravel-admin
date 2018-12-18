<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ModelFillable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:fillable {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get model fillable ';

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
        $table = $this->argument('table');

        if (Schema::hasTable($table)) {
            $list = Schema::getColumnListing($table);
            $this->info("protected \$fillable = ['".implode('\', \'', $list)."'];");
        }
    }
}
