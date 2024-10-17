<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\SamaProductsModel;
use App\Models\ProductModel;
use App\Models\SamaProductGemstoneDetails;

class SamaProductsImport implements ToCollection, WithHeadingRow
{
    protected $importedData;
    protected $importStatus;

    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $input = $row->toArray();


                $is_exist = ProductModel::where('sama_sku',$input['sama_sku_preeti'])->first();
                if($is_exist)
                {

                    ProductModel::where('sama_sku',$input['sama_sku_preeti'])->update(['status'=>'actual']);
                    echo "OK";
                }
                // dd($input);










                // $insertToSamaProduct = [
                //     'sku' => $input['sama_internal_price_ref'],
                //     'on_parent_sku' => $input['on_parent_sku'],
                //     'sama_parent_sku' => $input['sama_parent_sku'],
                //     'sama_child_sku' => $input['sama_child_sku'],
                //     'sama_sku' => $input['sama_sku'],
                //     'fractionsemimount' => $input['fractionsemimount'],
                //     'metaltype' => $input['metaltype'],
                //     'metalcolor' => $input['metalcolor'],
                //     'diamondQuality' => $input['diamondquality'],
                //     'CenterShape' => $input['centershape'],
                //     'SideDiamondNumber' => $input['sidediamondnumber'],
                //     'SideDiamondNumber_Max' => $input['sidediamondnumber_max'],
                //     'SideDiamondNumber_Min' => $input['sidediamondnumber_min'],
                //     'TotalDiamondWeight' => $input['totaldiamondweight'],
                //     'metalWeight' => $input['metalweight'],
                //     'metalWeight_Min' => $input['metalweight_min'],
                //     'metalWeight_Max' => $input['metalweight_max'],
                //     'FingerSize' => $input['fingersize'],
                //     'bandwidth' => $input['bandwidth_mm'],
                //     'bandweight' => $input['bandweight'],
                //     'category' => $input['category'],
                //     'subcategory' => $input['subcategory'],
                //     'product_browse_pg_name' => $input['product_browse_pg_name'],
                //     'product_pg_name' => $input['product_pg_name'],
                //     'description' => $input['description'],
                //     'center_stone_options' => $input['center_stone_options'],
                //     'matching_wedding_band' => $input['matching_wedding_band'],
                //     'product' => $input['product'],
                //     'images' => isset($input['images']) ? $input['images'] : '',
                //     'videos' => isset($input['videos']) ? $input['videos'] : '',
                // ];
                // $where = ['sku' => $input['sama_internal_price_ref']];
                // $saved = SamaProductsModel::updateOrCreate($where, $insertToSamaProduct);
                // DB::commit();
                // if ($saved) {
                //     $last_id = $saved->id;
                //     $insertToGemstone = [
                //         'product_id' => $last_id,
                //         'GemstoneShape1' => $input['gemstoneshape1'],
                //         'NoOfGemstones1' => $input['noofgemstones1'],
                //         'NoOfGemstones1_Min' => $input['noofgemstones1_min'],
                //         'NoOfGemstones1_Max' => $input['noofgemstones1_max'],
                //         'GemstoneLotCode1' => $input['gemstonelotcode1'],
                //         'GemstoneWeight1' => $input['gemstoneweight1'],
                //         'GemstoneWeight1_Min' => $input['gemstoneweight1_min'],
                //         'GemstoneWeight1_Max' => $input['gemstoneweight1_max'],
                //         'GemstoneShape2' => $input['gemstoneshape2'],
                //         'NoOfGemstones2' => $input['noofgemstones2'],
                //         'NoOfGemstones2_Min' => $input['noofgemstones2_min'],
                //         'NoOfGemstones2_Max' => $input['noofgemstones2_max'],
                //         'GemstoneLotCode2' => $input['gemstonelotcode2'],
                //         'GemstoneWeight2' => $input['gemstoneweight2'],
                //         'GemstoneWeight2_Min' => $input['gemstoneweight2_min'],
                //         'GemstoneWeight2_Max' => $input['gemstoneweight2_max'],
                //         'GemstoneShape3' => $input['gemstoneshape3'],
                //         'NoOfGemstones3' => $input['noofgemstones3'],
                //         'NoOfGemstones3_Min' => $input['noofgemstones3_min'],
                //         'NoOfGemstones3_Max' => $input['noofgemstones3_max'],
                //         'GemstoneLotCode3' => $input['gemstonelotcode3'],
                //         'GemstoneWeight3' => $input['gemstoneweight3'],
                //         'GemstoneWeight3_Min' => $input['gemstoneweight3_min'],
                //         'GemstoneWeight3_Max' => $input['gemstoneweight3_max'],
                //         'GemstoneShape4' => $input['gemstoneshape4'],
                //         'NoOfGemstones4' =>  $input['noofgemstones4'],
                //         'NoOfGemstones4_Min'  =>  $input['noofgemstones4_min'],
                //         'NoOfGemstones4_Max'  =>  $input['noofgemstones4_max'],
                //         'GemstoneLotCode4'  =>  $input['gemstonelotcode4'],
                //         'GemstoneWeight4'  =>  $input['gemstoneweight4'],
                //         'GemstoneWeight4_Min'  =>  $input['gemstoneweight4_min'],
                //         'GemstoneWeight4_Max'  =>  $input['gemstoneweight4_max'],
                //         'GemstoneShape5'  =>  $input['gemstoneshape5'],
                //         'NoOfGemstones5'  =>  $input['noofgemstones5'],
                //         'NoOfGemstones5_Min'  =>  $input['noofgemstones5_min'],
                //         'NoOfGemstones5_Max'  => $input['noofgemstones5_max'],
                //         'GemstoneLotCode5'  => $input['gemstonelotcode5'],
                //         'GemstoneWeight5'  =>  $input['gemstoneweight5'],
                //         'GemstoneWeight5_Min'  => $input['gemstoneweight5_min'],
                //         'GemstoneWeight5_Max'  => $input['gemstoneweight5_max'],
                //         'GemstoneShape6'  => $input['gemstoneshape6'],
                //         'NoOfGemstones6'  => $input['noofgemstones6'],
                //         'NoOfGemstones6_Min'  => $input['noofgemstones6_min'],
                //         'NoOfGemstones6_Max'  => $input['noofgemstones6_max'],
                //         'GemstoneLotCode6' => $input['gemstonelotcode6'],
                //         'GemstoneWeight6' => $input['gemstoneweight6'],
                //         'GemstoneWeight6_Min' => $input['gemstoneweight6_min'],
                //         'GemstoneWeight6_Max' => $input['gemstoneweight6_max'],
                //         'GemstoneShape7' => $input['gemstoneshape7'],
                //         'NoOfGemstones7' => $input['noofgemstones7'],
                //         'NoOfGemstones7_Min' => $input['noofgemstones7_min'],
                //         'NoOfGemstones7_Max' => $input['noofgemstones7_max'],
                //         'GemstoneLotCode7' => $input['gemstonelotcode7'],
                //         'GemstoneWeight7' => $input['gemstoneweight7'],
                //         'GemstoneWeight7_Min' => $input['gemstoneweight7_min'],
                //         'GemstoneWeight7_Max' => $input['gemstoneweight7_max'],
                //         'GemstoneShape8' => $input['gemstoneshape8'],
                //         'NoOfGemstones8' => $input['noofgemstones8'],
                //         'NoOfGemstones8_Min' => $input['noofgemstones8_min'],
                //         'NoOfGemstones8_Max' => $input['noofgemstones8_max'],
                //         'GemstoneLotCode8' => $input['gemstonelotcode8'],
                //         'GemstoneWeight8' => $input['gemstoneweight8'],
                //         'GemstoneWeight8_Min' => $input['gemstoneweight8_min'],
                //         'GemstoneWeight8_Max' => $input['gemstoneweight8_max'],
                //         'GemstoneShape9' => $input['gemstoneshape9'],
                //         'NoOfGemstones9' => $input['noofgemstones9'],
                //         'NoOfGemstones9_Min' => $input['noofgemstones9_min'],
                //         'NoOfGemstones9_Max' => $input['noofgemstones9_max'],
                //         'GemstoneLotCode9' => $input['gemstonelotcode9'],
                //         'GemstoneWeight9_Min' => $input['gemstoneweight9_min'],
                //         'GemstoneWeight9_Max' => $input['gemstoneweight9_max'],
                //         'GemstoneShape10' => $input['gemstoneshape10'],
                //         'NoOfGemstones10' => $input['noofgemstones10'],
                //         'NoOfGemstones10_Min' => $input['noofgemstones10_min'],
                //         'NoOfGemstones10_Max' => $input['noofgemstones10_max'],
                //         'GemstoneLotCode10' => $input['gemstonelotcode10'],
                //         'GemstoneWeight10' => $input['gemstoneweight10'],
                //         'GemstoneWeight10_Min' => $input['gemstoneweight10_min'],
                //         'GemstoneWeight10_Max' => $input['gemstoneweight10_max']
                //     ];
                //     $saved = SamaProductGemstoneDetails::updateOrCreate(['product_id' => $last_id], $insertToGemstone);
                //     DB::commit();
                //     if (!$saved) {
                //         $stat = 'false';
                //     }
                // }
            }
        }
        // if ($stat == 'true') {
        //     $this->getImportedData(['is_updated' => 'true']);
        // } else {
        //     $this->getImportedData(['is_updated' => 'false']);
        // }
        // $this->importStatus = ['is_updated' => $stat ? 'true' : 'false'];
        // $this->importedData = $collection;
    }
    public function getImportedData()
    {
        return $this->importedData;
    }

    public function getImportStatus()
    {
        return $this->importStatus;
    }
}
