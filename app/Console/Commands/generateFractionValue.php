<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ProductModel;

class generateFractionValue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:fraction';

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

        foreach($products as $products)
        {
            if($products['fractionsemimount'] != NULL || !empty($products['fractionsemimount']))
            {
                $fraction = $products['fractionsemimount'];
                $fraction =str_replace('ct tw', '', $fraction);
                $fraction = $fraction = str_replace(' ', '', $fraction);
                if($fraction == 1)
                {
                    $decimal_value = 1;
                }
                else
                {
                    // find the decimal value
                }


            }
        }
    }
}
