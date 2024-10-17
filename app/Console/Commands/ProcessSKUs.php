<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InternalProducts;

class ProcessSKUs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sku:precess_sku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $data = InternalProducts::whereNotNull('parent_sku')->get();
        foreach ($data as $value) {
            $sku = $value['sku'];
            $parent_sku=  $value['parent_sku'];
            $parentsku_data = InternalProducts::where('sku',$parent_sku)->first();
            if($parentsku_data)
            {
                $updateData = ['sama_parent_sku'=>$parentsku_data['sama_sku']];
                InternalProducts::where('id',$value['id'])->update($updateData);
                $this->info('sama_sku field updated successfully.');
            }
            else{
                $this->info($parent_sku .'   not exist.');
            }
        }
    }
}
