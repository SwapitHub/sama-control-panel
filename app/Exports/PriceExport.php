<?php

namespace App\Exports;
use App\Models\ProductPrice;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\Schema;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldQueue as LaravelShouldQueue;
use Illuminate\Support\Facades\DB;

class PriceExport implements FromQuery, WithHeadings, WithChunkReading, ShouldAutoSize
{
    public function query()
    {
        return ProductPrice::query()
            // ->select('product_price.id,product_price.product_sku,product_price.metalType,product_price.metalColor,product_price.diamondQuality,product_price.finishLevel,product_price.diamond_type,product_price.reference_price,product_price.discount_percentage,product_price.price', 'menus.name as menu_name')
            ->select([
                'product_price.id',
                'product_price.product_sku',
                'product_price.metalType',
                'product_price.metalColor',
                'product_price.diamondQuality',
                'product_price.finishLevel',
                'product_price.diamond_type',
                'product_price.reference_price',
                'product_price.discount_percentage',
                'product_price.price',
                // 'products.parent_sku as parent_sku',
                DB::raw('COALESCE(products.parent_sku, products.sku) as sku_to_use'),
                'products.internal_sku as samasku',
                'products.fractionsemimount as fractionsemimount',
                'menus.name as menu_name'
            ])
            ->join('products', 'products.sku', '=', 'product_price.product_sku', 'inner')
            ->join('menus', 'menus.id', '=', 'products.menu', 'inner')
            ->where('product_price.reference_price', '!=', NULL)
            ->orderByRaw('CAST(product_price.product_sku AS UNSIGNED)');
    }

    public function headings(): array
    {
        // $columns = Schema::getColumnListing((new ProductPrice())->getTable());
        $columns = [
            'id',
            'product_sku',
            'metalType',
            'metalColor',
            'diamondQuality',
            'finishLevel',
            'diamond_type',
            'reference_price',
            'discount_percentage',
            'price',
            'parent_sku',
            'samaSku',
            'fractionsemimount',
            'category'
        ];
        return $columns;
    }
    public function chunkSize(): int
    {
        return 100;
    }
}
