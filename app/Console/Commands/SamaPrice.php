<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductModel;
use App\Models\InternalProducts;
use App\Models\ProductPrice;
use App\Models\SamaPrices;

class SamaPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:sama-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch price from overmounting and convert it in sama price ';

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
            $product_id = $product['id'];
            $sama_sku = $product['sama_sku'];
            $modified_sku = $this->replaceIfEndsWith1000($sama_sku);


            $overmounting = ProductModel::where('sama_sku', $modified_sku);
            if ($overmounting->exists()) {
                $overmounting = $overmounting->first();
                $overmounting_sku = $overmounting['sku'];
                $all_prices = ProductPrice::where('product_sku', $overmounting_sku);
                if ($all_prices->exists()) {
                    $prices = $all_prices->get();
                    foreach ($prices as $price) {
                        $insertData = [
                            'product_id' => $product_id,
                            'sku' => $sama_sku,
                            'metalType' => $price['metalType'],
                            'metalColor' => $price['metalColor'],
                            'diamondQuality' => $price['diamondQuality'],
                            'finishLevel' => $price['finishLevel'],
                            'diamond_type' => $price['diamond_type'],
                            'reference_price' => $price['reference_price'],
                            'discount_percentage' => $price['discount_percentage'],
                            'price' => $price['price'],
                        ];
                        SamaPrices::create($insertData);
                    }
                }
                else
                {
                    $this->info($sama_sku .' PRICE NOT EXIST OF THIS SKU');
                }
            }
            else
            {
                $this->info($sama_sku .' PRODUCT NOT EXIST OF THIS SKU');
            }

            $this->info($sama_sku .' PRICE inserted into new table');
        }
    }

    private function replaceIfEndsWith1000($string)
    {
        if (substr($string, -4) === "1000") {
            return substr($string, 0, -4) . "1";
        }

        return $string;
    }
}
