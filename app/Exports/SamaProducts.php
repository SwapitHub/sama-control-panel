<?php

namespace App\Exports;

use App\Models\SamaProductsModel;
use App\Models\SamaProductGemstoneDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;

class SamaProducts implements FromQuery, WithHeadings
{
    public function query()
    {
        return SamaProductsModel::query()
            ->select([
                'sama_products.*',
                'sama_product_gemstones.*',
            ])
            ->join('sama_product_gemstones', 'sama_product_gemstones.product_id', '=', 'sama_products.id');
    }

    public function headings(): array
    {
        // retrurn table coulmn name
        $productColumns = Schema::getColumnListing('sama_products');
        $gemstoneColumns = Schema::getColumnListing('sama_product_gemstones');
        // You can create headings using the column names
        $headings = array_merge(
            $productColumns,
            $gemstoneColumns // Adjust as necessary for clarity
        );

        return $headings;
    }
}
