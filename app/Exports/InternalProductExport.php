<?php

namespace App\Exports;

use App\Models\ProductModel;
use App\Models\InternalProducts;
use App\Models\InternalProductGemstones;
use App\Models\SamaProductGemstoneDetails;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Support\Facades\DB;

// class ProductExport implements FromCollection
class InternalProductExport implements FromQuery, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return InternalProducts::query()
            ->select([
                //     'tbl_products.id',
                //     'tbl_products.sku',
                //     'tbl_products.parent_sku',
                //     'tbl_products.sama_parent_sku',
                //     DB::raw(
                //         '
                //         REPLACE(REPLACE(REPLACE(COALESCE(tbl_products.fractionsemimount, "0"), " ct", ""), " tw", ""), "/", "") AS formatted_fraction'
                //     ),
                //    'tbl_products.sama_sku',
                //     'tbl_products.fractionsemimount',
                //     DB::raw(
                //         '
                //         CASE
                //             WHEN tbl_products.fractionsemimount LIKE "%/%"
                //             THEN CAST(SUBSTRING_INDEX(tbl_products.fractionsemimount, " ", 1) AS UNSIGNED) /
                //                  NULLIF(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_products.fractionsemimount, "/", -1), " ", 1) AS UNSIGNED), 0)
                //             ELSE 0
                //         END AS decimal_value'
                //     ),
                'tbl_products.parent_sku',
                'tbl_products.sama_parent_sku',
                DB::raw("CASE WHEN tbl_products.type = 'parent_product' THEN 'PARENT' ELSE 'CHILD' END AS type"),
                DB::raw(
                    '
                    TRIM(REPLACE(REPLACE(REPLACE(COALESCE(tbl_products.fractionsemimount, "0"), " ct", ""), " tw", ""), "/", "")) AS formatted_fraction
                    '
                ),
                'tbl_products.sama_sku',
                'tbl_products.fractionsemimount',
                DB::raw(
                    '
                    CASE
                        WHEN tbl_products.fractionsemimount LIKE "%/%"
                        THEN CAST(SUBSTRING_INDEX(tbl_products.fractionsemimount, " ", 1) AS UNSIGNED) /
                             NULLIF(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_products.fractionsemimount, "/", -1), " ", 1) AS UNSIGNED), 0)
                        ELSE 0
                    END AS decimal_value'
                ),
                'tbl_products.metalType',
                'tbl_products.metalColor',
                'tbl_products.diamondQuality',
                'tbl_products.CenterShape',
                'tbl_products.SideDiamondNumber',
                'tbl_products.SideDiamondNumber_Min',
                'tbl_products.SideDiamondNumber_Max',
                'tbl_products.TotalDiamondWeight',
                'tbl_products.metalWeight',
                'tbl_products.metalWeight_Min',
                'tbl_products.metalWeight_Max',

                'product_gemstone_details.GemstoneShape1',
                'product_gemstone_details.NoOfGemstones1',
                'product_gemstone_details.NoOfGemstones1_Min',
                'product_gemstone_details.NoOfGemstones1_Max',
                'product_gemstone_details.GemstoneCaratWeight1',
                'product_gemstone_details.GemstoneCaratWeight1_Min',
                'product_gemstone_details.GemstoneCaratWeight1_Max',

                'product_gemstone_details.GemstoneShape2',
                'product_gemstone_details.NoOfGemstones2',
                'product_gemstone_details.NoOfGemstones2_Min',
                'product_gemstone_details.NoOfGemstones2_Max',
                'product_gemstone_details.GemstoneCaratWeight2',
                'product_gemstone_details.GemstoneCaratWeight2_Min',
                'product_gemstone_details.GemstoneCaratWeight2_Max',


                'product_gemstone_details.GemstoneShape3',
                'product_gemstone_details.NoOfGemstones3',
                'product_gemstone_details.NoOfGemstones3_Min',
                'product_gemstone_details.NoOfGemstones3_Max',
                'product_gemstone_details.GemstoneCaratWeight3',
                'product_gemstone_details.GemstoneCaratWeight3_Min',
                'product_gemstone_details.GemstoneCaratWeight3_Max',

                'product_gemstone_details.GemstoneShape4',
                'product_gemstone_details.NoOfGemstones4',
                'product_gemstone_details.NoOfGemstones4_Min',
                'product_gemstone_details.NoOfGemstones4_Max',
                'product_gemstone_details.GemstoneCaratWeight4',
                'product_gemstone_details.GemstoneCaratWeight4_Min',
                'product_gemstone_details.GemstoneCaratWeight4_Max',

                'product_gemstone_details.GemstoneShape5',
                'product_gemstone_details.NoOfGemstones5',
                'product_gemstone_details.NoOfGemstones5_Min',
                'product_gemstone_details.NoOfGemstones5_Max',
                'product_gemstone_details.GemstoneCaratWeight5',
                'product_gemstone_details.GemstoneCaratWeight5_Min',
                'product_gemstone_details.GemstoneCaratWeight5_Max',

                'product_gemstone_details.GemstoneShape6',
                'product_gemstone_details.NoOfGemstones6',
                'product_gemstone_details.NoOfGemstones6_Min',
                'product_gemstone_details.NoOfGemstones6_Max',
                'product_gemstone_details.GemstoneCaratWeight6',
                'product_gemstone_details.GemstoneCaratWeight6_Min',
                'product_gemstone_details.GemstoneCaratWeight6_Max',

                'product_gemstone_details.GemstoneShape7',
                'product_gemstone_details.NoOfGemstones7',
                'product_gemstone_details.NoOfGemstones7_Min',
                'product_gemstone_details.NoOfGemstones7_Max',
                'product_gemstone_details.GemstoneCaratWeight7',
                'product_gemstone_details.GemstoneCaratWeight7_Min',
                'product_gemstone_details.GemstoneCaratWeight7_Max',


                'product_gemstone_details.GemstoneShape8',
                'product_gemstone_details.NoOfGemstones8',
                'product_gemstone_details.NoOfGemstones8_Min',
                'product_gemstone_details.NoOfGemstones8_Max',
                'product_gemstone_details.GemstoneCaratWeight8',
                'product_gemstone_details.GemstoneCaratWeight8_Min',
                'product_gemstone_details.GemstoneCaratWeight8_Max',


                'product_gemstone_details.GemstoneShape9',
                'product_gemstone_details.NoOfGemstones9',
                'product_gemstone_details.NoOfGemstones9_Min',
                'product_gemstone_details.NoOfGemstones9_Max',
                'product_gemstone_details.GemstoneCaratWeight9',
                'product_gemstone_details.GemstoneCaratWeight9_Min',
                'product_gemstone_details.GemstoneCaratWeight9_Max',

                'product_gemstone_details.GemstoneShape10',
                'product_gemstone_details.NoOfGemstones10',
                'product_gemstone_details.NoOfGemstones10_Min',
                'product_gemstone_details.NoOfGemstones10_Max',
                'product_gemstone_details.GemstoneCaratWeight10',
                'product_gemstone_details.GemstoneCaratWeight10_Min',
                'product_gemstone_details.GemstoneCaratWeight10_Max',

                'tbl_products.FingerSize',
                'tbl_products.bandwidth',
                'tbl_products.bandweight',
                'product_subcategory.name as category',
                DB::raw('
                CONCAT(
                    product_category.name, "/",
                    (SELECT GROUP_CONCAT(product_subcategory.name SEPARATOR "/")
                     FROM product_subcategory
                     WHERE FIND_IN_SET(product_subcategory.id, tbl_products.subcategory_ids))
                ) as subcategory_with_category
            '),
                'tbl_products.product_browse_pg_name',
                'tbl_products.name',
                'tbl_products.description',
                'tbl_products.center_stone_options',
                'tbl_products.matching_wedding_band',
                'menus.name as menu_name',
                'tbl_products.default_image_url',
                'tbl_products.images',
                'tbl_products.videos',
            ])
            ->join('product_gemstone_details', 'product_gemstone_details.product_id', '=', 'tbl_products.id')
            ->join('menus', 'menus.id', '=', 'tbl_products.menu')
            ->join('product_category', 'product_category.id', '=', 'tbl_products.category_id')
            ->join('product_subcategory', 'product_subcategory.id', '=', 'tbl_products.category_id');
    }

    public function headings(): array
    {
        return $columns = [
            // 'num',
            // 'SAMA INTERNAL PRICE REF',
            // 'ON PARENT SKU',
            // 'SAMA PARENT SKU',
            // 'SAMA CHILD SKU',
            // 'SAMA SKU',
            // 'fractionsemimount',
            // 'fractionsemimount_value',
            'PARENT SKU',
            'SAMA PARENT',
            'PARENT_CHILD',
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
            'GemstoneCaratWeight1',
            'GemstoneCaratWeight1_Min',
            'GemstoneCaratWeight1_Max',


            'GemstoneShape2',
            'NoOfGemstones2',
            'NoOfGemstones2_Min',
            'NoOfGemstones2_Max',
            'GemstoneCaratWeight2',
            'GemstoneCaratWeight2_Min',
            'GemstoneCaratWeight2_Max',

            'GemstoneShape3',
            'NoOfGemstones3',
            'NoOfGemstones3_Min',
            'NoOfGemstones3_Max',
            'GemstoneCaratWeight3',
            'GemstoneCaratWeight3_Min',
            'GemstoneCaratWeight3_Max',

            'GemstoneShape4',
            'NoOfGemstones4',
            'NoOfGemstones4_Min',
            'NoOfGemstones4_Max',
            'GemstoneCaratWeight4',
            'GemstoneCaratWeight4_Min',
            'GemstoneCaratWeight4_Max',

            'GemstoneShape5',
            'NoOfGemstones5',
            'NoOfGemstones5_Min',
            'NoOfGemstones5_Max',
            'GemstoneCaratWeight5',
            'GemstoneCaratWeight5_Min',
            'GemstoneCaratWeight5_Max',


            'GemstoneShape6',
            'NoOfGemstones6',
            'NoOfGemstones6_Min',
            'NoOfGemstones6_Max',
            'GemstoneCaratWeight6',
            'GemstoneCaratWeight6_Min',
            'GemstoneCaratWeight6_Max',


            'GemstoneShape7',
            'NoOfGemstones7',
            'NoOfGemstones7_Min',
            'NoOfGemstones7_Max',
            'GemstoneCaratWeight7',
            'GemstoneCaratWeight7_Min',
            'GemstoneCaratWeight7_Max',


            'GemstoneShape8',
            'NoOfGemstones8',
            'NoOfGemstones8_Min',
            'NoOfGemstones8_Max',
            'GemstoneCaratWeight8',
            'GemstoneCaratWeight8_Min',
            'GemstoneCaratWeight8_Max',


            'GemstoneShape9',
            'NoOfGemstones9',
            'NoOfGemstones9_Min',
            'NoOfGemstones9_Max',
            'GemstoneCaratWeight9',
            'GemstoneCaratWeight9_Min',
            'GemstoneCaratWeight9_Max',

            'GemstoneShape10',
            'NoOfGemstones10',
            'NoOfGemstones10_Min',
            'NoOfGemstones10_Max',
            'GemstoneCaratWeight10',
            'GemstoneCaratWeight10_Min',
            'GemstoneCaratWeight10_Max',



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
