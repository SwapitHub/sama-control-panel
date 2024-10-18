<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSamaSku extends Command
{

    protected $signature = 'update:sama_sku';
    protected $description = 'Update the sama_sku field based on custom logic';

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
        DB::table('products')
            ->update([
                'sama_sku' => DB::raw("CONCAT('SA', products.sku, '-', REPLACE(REPLACE(REPLACE(COALESCE(products.fractionsemimount, '0'), ' ct', ''), ' tw', ''), '/',''))")
                // 'sama_sku' => DB::raw("TRIM(CONCAT('SA', products.sku, '-', REPLACE(REPLACE(REPLACE(COALESCE(products.fractionsemimount, '0'), ' ct', ''), ' tw', ''), '/','')))")
            ]);
        $this->info('sama_sku field updated successfully.');
        return 0;
    }
}
