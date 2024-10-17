<?php

namespace App\Exports;

use App\Models\ProductModel;
use App\Models\SamaProductsModel;
use App\Models\SamaProductGemstoneDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;

// class ProductExport implements FromCollection
class ProductExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return ProductModel::query()
            ->select([
                'products.id',
                'products.sku',
                'products.parent_sku',
                // 'products.internal_sku',
                DB::raw("CONCAT('SA', products.parent_sku) AS prefixed_parent_sku"),
                DB::raw(
                    '
                    REPLACE(REPLACE(REPLACE(COALESCE(products.fractionsemimount, "0"), " ct", ""), " tw", ""), "/", "") AS formatted_fraction'
                ),
                DB::raw("CONCAT('SA', products.sku, '-', REPLACE(REPLACE(REPLACE(COALESCE(products.fractionsemimount, '0'), ' ct', ''), ' tw', ''), '/','')) AS sku_with_fraction"),
                // 'products.internal_sku as internal_sku_copy',
                'products.fractionsemimount',
                DB::raw(
                    '
                    CASE
                        WHEN products.fractionsemimount LIKE "%/%"
                        THEN CAST(SUBSTRING_INDEX(products.fractionsemimount, " ", 1) AS UNSIGNED) /
                             NULLIF(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(products.fractionsemimount, "/", -1), " ", 1) AS UNSIGNED), 0)
                        ELSE 0
                    END AS decimal_value'
                ),
                'products.metalType',
                'products.metalColor',
                'products.diamondQuality',
                'products.CenterShape',
                'products.SideDiamondNumber',
                'products.SideDiamondNumber_Min',
                'products.SideDiamondNumber_Max',
                'products.TotalDiamondWeight',
                'products.metalWeight',
                'products.metalWeight_Min',
                'products.metalWeight_Max',
                'products.GemstoneShape1',
                'products.NoOfGemstones1',
                'products.NoOfGemstones1_Min',
                'products.NoOfGemstones1_Max',
                'products.GemstoneLotCode1',
                'products.GemstoneWeight1',
                'products.GemstoneWeight1_Min',
                'products.GemstoneWeight1_Max',
                'products.GemstoneShape2',
                'products.NoOfGemstones2',
                'products.NoOfGemstones2_Min',
                'products.NoOfGemstones2_Max',
                'products.GemstoneLotCode2',
                'products.GemstoneWeight2',
                'products.GemstoneWeight2_Min',
                'products.GemstoneWeight2_Max',
                'products.GemstoneShape3',
                'products.NoOfGemstones3',
                'products.NoOfGemstones3_Min',
                'products.NoOfGemstones3_Max',
                'products.GemstoneLotCode3',
                'products.GemstoneWeight3',
                'products.GemstoneWeight3_Min',
                'products.GemstoneWeight3_Max',
                'products.GemstoneShape4',
                'products.NoOfGemstones4',
                'products.NoOfGemstones4_Min',
                'products.NoOfGemstones4_Max',
                'products.GemstoneLotCode4',
                'products.GemstoneWeight4',
                'products.GemstoneWeight4_Min',
                'products.GemstoneWeight4_Max',
                'products.GemstoneShape5',
                'products.NoOfGemstones5',
                'products.NoOfGemstones5_Min',
                'products.NoOfGemstones5_Max',
                'products.GemstoneLotCode5',
                'products.GemstoneWeight5',
                'products.GemstoneWeight5_Min',
                'products.GemstoneWeight5_Max',
                'products.GemstoneShape6',
                'products.NoOfGemstones6',
                'products.NoOfGemstones6_Min',
                'products.NoOfGemstones6_Max',
                'products.GemstoneLotCode6',
                'products.GemstoneWeight6',
                'products.GemstoneWeight6_Min',
                'products.GemstoneWeight6_Max',
                'products.GemstoneShape7',
                'products.NoOfGemstones7',
                'products.NoOfGemstones7_Min',
                'products.NoOfGemstones7_Max',
                'products.GemstoneLotCode7',
                'products.GemstoneWeight7',
                'products.GemstoneWeight7_Min',
                'products.GemstoneWeight7_Max',
                'products.GemstoneShape8',
                'products.NoOfGemstones8',
                'products.NoOfGemstones8_Min',
                'products.NoOfGemstones8_Max',
                'products.GemstoneLotCode8',
                'products.GemstoneWeight8',
                'products.GemstoneWeight8_Min',
                'products.FingerSize',
                'products.bandwidth',
                'products.bandweight',
                'product_subcategory.name as category',
                DB::raw('
                CONCAT(
                    product_category.name, "/",
                    (SELECT GROUP_CONCAT(product_subcategory.name SEPARATOR "/")
                     FROM product_subcategory
                     WHERE FIND_IN_SET(product_subcategory.id, products.subcategory_ids))
                ) as subcategory_with_category
            '),
                'products.product_browse_pg_name',
                'products.name',
                'products.description',
                'products.center_stone_options',
                'products.matching_wedding_band',
                'menus.name as menu_name',
                'products.default_image_url',
                'products.images',
                'products.videos',
            ])
            ->join('menus', 'menus.id', '=', 'products.menu')
            ->join('product_category', 'product_category.id', '=', 'products.category_id')
            ->join('product_subcategory', 'product_subcategory.id', '=', 'products.category_id');
    }

    public function headings(): array
    {
        return $columns = [
            'num',
            'SAMA INTERNAL PRICE REF',
            'ON PARENT SKU',
            'SAMA PARENT SKU',
            'SAMA CHILD SKU',
            'SAMA SKU',
            'fractionsemimount',
            'fractionsemimount_value',
            'metaltype',
            'metalcolor',
            'diamondQuality',
            'CenterShape',
            'SideDiamondNumber',
            'SideDiamondNumber_Min',
            'SideDiamondNumber_Max',
            'TotalDiamondWeight',
            'metalWeight',
            'metalWeight_Min',
            'metalWeight_Max',
            'GemstoneShape1',
            'NoOfGemstones1',
            'NoOfGemstones1_Min',
            'NoOfGemstones1_Max',
            'GemstoneLotCode1',
            'GemstoneWeight1',
            'GemstoneWeight1_Min',
            'GemstoneWeight1_Max',
            'GemstoneShape2',
            'NoOfGemstones2',
            'NoOfGemstones2_Min',
            'NoOfGemstones2_Max',
            'GemstoneLotCode2',
            'GemstoneWeight2',
            'GemstoneWeight2_Min',
            'GemstoneWeight2_Max',
            'GemstoneShape3',
            'NoOfGemstones3',
            'NoOfGemstones3_Min',
            'NoOfGemstones3_Max',
            'GemstoneLotCode3',
            'GemstoneWeight3',
            'GemstoneWeight3_Min',
            'GemstoneWeight3_Max',
            'GemstoneShape4',
            'NoOfGemstones4',
            'NoOfGemstones4_Min',
            'NoOfGemstones4_Max',
            'GemstoneLotCode4',
            'GemstoneWeight4',
            'GemstoneWeight4_Min',
            'GemstoneWeight4_Max',
            'GemstoneShape5',
            'NoOfGemstones5',
            'NoOfGemstones5_Min',
            'NoOfGemstones5_Max',
            'GemstoneLotCode5',
            'GemstoneWeight5',
            'GemstoneWeight5_Min',
            'GemstoneWeight5_Max',
            'GemstoneShape6',
            'NoOfGemstones6',
            'NoOfGemstones6_Min',
            'NoOfGemstones6_Max',
            'GemstoneLotCode6',
            'GemstoneWeight6',
            'GemstoneWeight6_Min',
            'GemstoneWeight6_Max',
            'GemstoneShape7',
            'NoOfGemstones7',
            'NoOfGemstones7_Min',
            'NoOfGemstones7_Max',
            'GemstoneLotCode7',
            'GemstoneWeight7',
            'GemstoneWeight7_Min',
            'GemstoneWeight7_Max',
            'GemstoneShape8',
            'NoOfGemstones8',
            'NoOfGemstones8_Min',
            'NoOfGemstones8_Max',
            'GemstoneLotCode8',
            'GemstoneWeight8',
            'GemstoneWeight8_Min',
            'FingerSize',
            'bandwidth (mm)',
            'bandweight',
            'CATEGORY',
            'SUBCATEGORY',
            'PRODUCT BROWSE PG NAME',
            'PRODUCT PG NAME',
            'DESCRIPTION',
            'CENTER STONE OPTIONS',
            'MATCHING WEDDING BAND',
            'PRODUCT',
            'default_image_url',
            'images',
            'videos',
        ];
    }
}
