<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductModel;
use App\Models\InternalProducts;
use Illuminate\Support\Facades\DB;

class generateEntityId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:entity_id';

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
        $products = InternalProducts::get();
        foreach ($products as $product) {
            $overmountsku = $product['sku'];
            if ($overmountsku != NULL) {
                // get entity id from products table and update it in tbl_products entity ig
               $values =  ProductModel::where('sku',$overmountsku)->first();
               $entity_id = $values['entity_id'];
               InternalProducts::where('sku',$overmountsku)->update(['entity_id'=>$entity_id]);
               $this->info('fetched and updated the entity_id from overmount'.$overmountsku .' => ' .$entity_id );
            }
            else
            {
                $entity_id = $this->generateUniqueNumber();
                InternalProducts::where('id',$product['id'])->update(['entity_id'=>$entity_id]);

                // generete unique entity id of 5 digit
                $this->info('generated new entity_id'.$product['sama_sku'] .' => ' .$entity_id );
            }
        }
    }


    private function generateUniqueNumber()
    {
        do {
            $uniqueNumber = mt_rand(10000, 99999);
            $exists = DB::table('tbl_products')->where('entity_id', $uniqueNumber)->exists();

        } while ($exists);

        return $uniqueNumber;
    }
}
