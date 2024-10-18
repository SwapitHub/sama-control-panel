<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductModel;

class process_sku extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:skus';

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
        $products = ProductModel::get();
        foreach($products as $product)
        {
           $res = $this->changeSamaSKU($product['sku'],$product['fractionsemimount']);
           ProductModel::where('sku',$product['sku'])->update(['sama_sku'=>$res]);
           $this->info($product['sku'].' updated to ' .$res. ' sama_sku sku  updated successfully.');
        }
    }


    public function changeSamaSKU($sku, $fractionsemimount)
    {
        if ($fractionsemimount != NULL) {
            $fractionsemimount_cleaned = str_replace(['ct', 'tw', '/'], '', $fractionsemimount);
            $fractionsemimount_cleaned = trim($fractionsemimount_cleaned);
        } else {
            $fractionsemimount_cleaned = '000';
        }

        $sama_parts = explode('-', $sku);

        if (count($sama_parts) == 4) {
            return 'SA'.$sama_parts[0] . '-' . $sama_parts[1] . '-' . $fractionsemimount_cleaned;

        } elseif (count($sama_parts) == 3) {
            return 'SA'.$sama_parts[0] . '-' . $sama_parts[1] . '-' . $fractionsemimount_cleaned;

        } elseif (count($sama_parts) == 2 && preg_match('/[a-zA-Z]/', $sama_parts[1])) {
            return 'SA'.$sama_parts[0] . '-' . $sama_parts[1] . '-' . $fractionsemimount_cleaned;

        } elseif (count($sama_parts) == 2) {
            return 'SA'.$sama_parts[0] . '-' . $fractionsemimount_cleaned;
        } else {
            return 'SA'.$sku;
        }
    }
}
