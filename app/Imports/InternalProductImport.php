<?php

namespace App\Imports;


use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductImageModel;
use App\Models\ProductVideosModel;
use App\Models\MetalColor;
use App\Models\RingMetal;
use App\Models\ProductModel;
use App\Models\ProductCategory;
use App\Models\ProductSubcategory;
use App\Models\InternalProducts;
use App\Models\InternalProductGemstones;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class InternalProductImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    protected $menu;
    protected $importedData;
    protected $importStatus;

    public function __construct($menu)
    {
        $this->menu = $menu;
        $this->menu_id = Menu::where('name', $menu)->first()['id'];
    }

    public function collection(Collection $collection)
    {
        $product = new InternalProducts;
        $stat = 'true';
        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $input = $row->toArray();
                ## insert category and subcategory
                $categories = explode('/', $input['subcategory']);
                $mainMenu = $categories[0];
                $subMenus = array_slice($categories, 1);

                ## Create or get the main category
                $ProductCategory = new  ProductCategory;
                $category = DB::table('product_category')->where('name', $mainMenu)->first();
                if (!$category) {
                    $categoryId = DB::table('product_category')->insertGetId(['name' => $mainMenu, 'slug' => $ProductCategory->generateUniqueSlug($mainMenu)]);
                } else {
                    $categoryId = $category->id;
                }

                ## Create or get the subcategories
                $ProductSubcategory = new  ProductSubcategory;
                $subcategoryIds = [];
                foreach ($subMenus as $subMenu) {
                    $subcategory = DB::table('product_subcategory')
                        ->where('category_id', $categoryId)
                        ->where('name', $subMenu)
                        ->first();

                    if (!$subcategory) {
                        $subcategoryId = DB::table('product_subcategory')->insertGetId([
                            'category_id' => $categoryId,
                            'name' => $subMenu,
                            'slug' => $ProductSubcategory->generateUniqueSlug($subMenu)
                        ]);
                    } else {
                        $subcategoryId = $subcategory->id;
                    }
                    $subcategoryIds[] = $subcategoryId;
                }
                $subcategory_ids = implode(',', $subcategoryIds);

                if (isset($input['category'])) {
                    $sub_category = $this->getSubcategoryId($input['category']);
                } else {
                    $sub_category = '';
                }
                $category = 7;
                $metalColor_id = $this->getMetalColorIdByName($input['metalcolor']);
                $metalType_id = $this->getMetalTypeIdByName($input['metaltype']);

                if ($input['sama_parent_sku'] == NULL) {
                    $type = 'parent_product';
                } else {
                    $type = 'child_product';
                }
                // $images_arr = [];
                // $images = explode(',', $input['images']);
                // foreach ($images as $img) {
                //     $images_arr[] = $img;
                // }

                $generateSlug = new InternalProducts;
                $slug = $generateSlug->generateUniqueSlug(!empty($input['product_browse_pg_name']) ? $input['product_browse_pg_name'] : $input['name']);

                $insertToProduct = [
                    'internal_sku' => $input['sama_sku_preeti'],
                    'parent_sku' => $input['parent_sku'],
                    'sama_sku' => $input['sama_sku'],
                    'sama_parent_sku' => $input['sama_parent_sku'],
                    'sama_child_sku' => $input['sama_child_sku'],
                    'fractionsemimount' => $input['fractionsemimount'],
                    'fractionsemimount_value' => $input['fractionsemimount_value'],
                    'metalType' => $input['metaltype'],
                    'metalColor' => $input['metalcolor'],
                    'diamondQuality' => $input['diamondquality'],
                    'centerShape' => $input['centershape'],
                    'SideDiamondNumber' => $input['sidediamondnumber'],
                    'SideDiamondNumber_Min' => isset($input['sidediamondnumber_min']) ? $input['sidediamondnumber_min'] : '',
                    'SideDiamondNumber_Max' => isset($input['sidediamondnumber_max']) ? $input['sidediamondnumber_max'] : '',
                    'TotalDiamondWeight' => isset($input['totaldiamondweight'])?$input['totaldiamondweight']:'',
                    'TotalDiamondWeight' => isset($input['totaldiamondweight'])?$input['totaldiamondweight']:'',
                    'metalWeight' => isset($input['metalweight'])?$input['metalweight']:'',
                    'FingerSize' => $input['fingersize'],
                    'bandwidth' => isset($input['bandwidth_mm'])?$input['bandwidth_mm']:'',
                    'bandweight' => $input['bandweight'],
                    'category' => $category,
                    'product_browse_pg_name' => $input['product_browse_pg_name'],
                    'name' => $input['product_pg_name'],
                    'description' => $input['description'],
                    'center_stone_options' => $input['center_stone_options'],
                    'matching_wedding_band' => ($input['matching_wedding_band'] =='#N/A')?'':$input['matching_wedding_band'],
                    'default_image_url' => $input['default_image_url'] ?? '',
                    // 'images' => json_encode($images) ?? null,
                    'images' => trim($input['images'])?? null,
                    // 'videos' => isset($input['videos']) ? $this->sortVideos($input['videos']) : null,
                    'videos' => trim($input['videos'])??null,
                    'category_id' => $categoryId,
                    'subcategory_ids' => $subcategory_ids,
                    'menu' => $this->menu_id,
                    'sub_category' => $sub_category,
                    'metalColor_id' => $metalColor_id,
                    'metalType_id' => $metalType_id,
                    'type' => $type,
                    'slug' => $slug,
                ];


                // dd($input);
                // check if price exist in overmount data then update it
                $overmountProduct = ProductModel::where('sama_sku',$input['sama_sku_preeti']);
                if($overmountProduct->exists())
                {
                    $overmounting  = $overmountProduct->first();
                    $insertToProduct['white_gold_price']  = $overmounting['white_gold_price'];
                    $insertToProduct['yellow_gold_price']  = $overmounting['yellow_gold_price'];
                    $insertToProduct['rose_gold_price']  = $overmounting['rose_gold_price'];
                    $insertToProduct['platinum_price']  = $overmounting['platinum_price'];
                }

                $condition = ['sama_sku' => $input['sama_sku']];
                $product = InternalProducts::updateOrCreate($condition, $insertToProduct);
                if ($product) {
                    $last_insert_id = $product->id;
                    $gemInsertOrUpdate = [
                        'product_id' => $last_insert_id,

                        'GemstoneShape1' => isset($input['gemstoneshape1'])?$input['gemstoneshape1']:'',
                        'NoOfGemstones1' => isset($input['noofgemstones1'])?$input['noofgemstones1']:'',
                        'NoOfGemstones1_Min' => isset($input['noofgemstones1_min'])?$input['noofgemstones1_min']:'',
                        'NoOfGemstones1_Max' => isset($input['noofgemstones1_max'])?$input['noofgemstones1_max']:'',
                        'GemstoneCaratWeight1' => isset($input['gemstonecaratweight1']) ? $input['gemstonecaratweight1'] : '',
                        'GemstoneCaratWeight1_Min' => isset($input['gemstonecaratweight1_min']) ? $input['gemstonecaratweight1_min'] : '',
                        'GemstoneCaratWeight1_Max' => isset($input['gemstonecaratweight1_max']) ? $input['gemstonecaratweight1_max'] : '',

                        'GemstoneShape2' => $input['gemstoneshape2'],
                        'NoOfGemstones2' => $input['noofgemstones2'],
                        'NoOfGemstones2_Min' => $input['noofgemstones2_min'],
                        'NoOfGemstones2_Max' => $input['noofgemstones2_max'],
                        'GemstoneCaratWeight2'=>isset($input['gemstonecaratweight1'])?$input['gemstonecaratweight1']:'',
                        'GemstoneCaratWeight2_Min'=>$input['gemstonecaratweight2_min'],
                        'GemstoneCaratWeight2_Max'=>$input['gemstonecaratweight2_max'],

                        'GemstoneShape3' => $input['gemstoneshape3'],
                        'NoOfGemstones3' => $input['noofgemstones3'],
                        'NoOfGemstones3_Min' => $input['noofgemstones3_min'],
                        'NoOfGemstones3_Max' => $input['noofgemstones3_max'],
                        'GemstoneCaratWeight3'=>$input['gemstonecaratweight3'],
                        'GemstoneCaratWeight3_Min'=>$input['gemstonecaratweight3_min'],
                        'GemstoneCaratWeight3_Max'=>$input['gemstonecaratweight3_max'],

                        'GemstoneShape4' => $input['gemstoneshape4'],
                        'NoOfGemstones4' => $input['noofgemstones4'],
                        'NoOfGemstones4_Min' => $input['noofgemstones4_min'],
                        'NoOfGemstones4_Max' => $input['noofgemstones4_max'],
                        'GemstoneCaratWeight4'=>$input['gemstonecaratweight4'],
                        'GemstoneCaratWeight4_Min'=>$input['gemstonecaratweight4_min'],
                        'GemstoneCaratWeight4_Max'=>$input['gemstonecaratweight4_max'],

                        'GemstoneShape5' => $input['gemstoneshape5'],
                        'NoOfGemstones5' => $input['noofgemstones5'],
                        'NoOfGemstones5_Min' => $input['noofgemstones5_min'],
                        'NoOfGemstones5_Max' => $input['noofgemstones5_max'],
                        'GemstoneCaratWeight5'=>$input['gemstonecaratweight5'],
                        'GemstoneCaratWeight5_Min'=>$input['gemstonecaratweight5_min'],
                        'GemstoneCaratWeight5_Max'=>$input['gemstonecaratweight5_max'],

                        'GemstoneShape6' => $input['gemstoneshape6'],
                        'NoOfGemstones6' => $input['noofgemstones6'],
                        'NoOfGemstones6_Min' => $input['noofgemstones6_min'],
                        'NoOfGemstones6_Max' => $input['noofgemstones6_max'],
                        'GemstoneCaratWeight6'=>$input['gemstonecaratweight6'],
                        'GemstoneCaratWeight6_Min'=>$input['gemstonecaratweight6_min'],
                        'GemstoneCaratWeight6_Max'=>$input['gemstonecaratweight6_max'],

                        'GemstoneShape7' => $input['gemstoneshape7'],
                        'NoOfGemstones7' => $input['noofgemstones7'],
                        'NoOfGemstones7_Min' => $input['noofgemstones7_min'],
                        'NoOfGemstones7_Max' => $input['noofgemstones7_max'],
                        'GemstoneCaratWeight7'=>$input['gemstonecaratweight7'],
                        'GemstoneCaratWeight7_Min'=>$input['gemstonecaratweight7_min'],
                        'GemstoneCaratWeight7_Max'=>$input['gemstonecaratweight7_max'],

                        'GemstoneShape8' => $input['gemstoneshape8'],
                        'NoOfGemstones8' => $input['noofgemstones8'],
                        'NoOfGemstones8_Min' => $input['noofgemstones8_min'],
                        'NoOfGemstones8_Max' => $input['noofgemstones8_max'],
                        'GemstoneCaratWeight8'=>$input['gemstonecaratweight8'],
                        'GemstoneCaratWeight8_Min'=>$input['gemstonecaratweight8_min'],
                        'GemstoneCaratWeight8_Max'=>$input['gemstonecaratweight8_max'],

                        'GemstoneShape9' => $input['gemstoneshape9'],
                        'NoOfGemstones9' => $input['noofgemstones9'],
                        'NoOfGemstones9_Min' => $input['noofgemstones9_min'],
                        'NoOfGemstones9_Max' => $input['noofgemstones9_max'],
                        'GemstoneCaratWeight9'=>$input['gemstonecaratweight9'],
                        'GemstoneCaratWeight9_Min'=>$input['gemstonecaratweight9_min'],
                        'GemstoneCaratWeight9_Max'=>$input['gemstonecaratweight9_max'],

                        'GemstoneShape10' => $input['gemstoneshape10'],
                        'NoOfGemstones10' => $input['noofgemstones10'],
                        'NoOfGemstones10_Min' => $input['noofgemstones10_min'],
                        'NoOfGemstones10_Max' => $input['noofgemstones10_max'],
                        'GemstoneCaratWeight10'=>$input['gemstonecaratweight10'],
                        'GemstoneCaratWeight10_Min'=>$input['gemstonecaratweight10_min'],
                        'GemstoneCaratWeight10_Max'=>$input['gemstonecaratweight10_max'],

                    ];
                    $checkCondition = ['product_id' => $last_insert_id];
                    $saved = InternalProductGemstones::updateOrCreate($checkCondition, $gemInsertOrUpdate);
                } else {
                    $stat = 'false';
                }
            }
        }
        if ($stat == 'true') {
            $this->getImportedData(['is_updated' => 'true']);
        } else {
            $this->getImportedData(['is_updated' => 'false']);
        }
        $this->importStatus = ['is_updated' => $stat ? 'true' : 'false'];
        $this->importedData = $collection;
    }

    public function getImportedData()
    {
        return $this->importedData;
    }

    public function getImportStatus()
    {
        return $this->importStatus;
    }







    ## get metal color id
    public function getMetalColorIdByName($name)
    {
        $query = MetalColor::where('name', $name);
        if ($query->exists()) {
            $metaldata  = $query->first();
            return $metaldata['id'];
        } else {
            $metalColor = new MetalColor();
            $metalColor->name = $name;
            $metalColor->status = 'false';
            $metalColor->order_number = 0;
            $metalColor->save();
            return $metalColor->id;
        }
    }

    ## get metal type id
    public function getMetalTypeIdByName($name)
    {
        $query = RingMetal::where('metal', $name);
        if ($query->exists()) {
            $metaltype  = $query->first();
            return $metaltype['id'];
        } else {
            $metaltype = new RingMetal();
            $metaltype->metal = $name;
            $metaltype->status = 'false';
            $metaltype->save();
            return $metaltype->id;
        }
    }

    ## get cubcategory by name and categoryif
    public function getSubcategoryId($subcatname)
    {
        $query =  Subcategory::where('menu_id', $this->menu_id)
            ->where('category_id', 7)
            ->where('name', $subcatname);
        if ($query->exists()) {
            $subcatdata = $query->first();
            return $subcat_id = $subcatdata['id'];
        } else {
            ## insert into category table where menu = $menu
            $insertData = new Subcategory;
            $insertData->menu_id = $this->menu_id;
            $insertData->category_id = 7;
            $insertData->name = $subcatname;
            $slug = $insertData->generateUniqueSlug($subcatname);
            $insertData->slug = $slug;
            $insertData->alias = $slug;
            $insertData->order_number = 0;
            $insertData->status = 'true';
            $insertData->save();
            return $subcat_id = $insertData->id;
        }
    }

    ## short videos
    public function sortVideos($videos)
    {
        $videos = explode(',', $videos);
        if ($videos != NULL || !empty($videos)) {
            //sort videos
            $colors = ['rose', 'white', 'yellow'];
            $colorVideoMapping = [];
            foreach ($videos as $video) {
                // Extract color name from the video URL
                preg_match('/\.video\.(\w+)\.mp4/', $video, $matches);

                if (isset($matches[1])) {
                    $colorName = $matches[1];

                    // Check if the color is in the defined colors array
                    if (in_array($colorName, $colors)) {
                        // Assign the video URL to the corresponding color key
                        $colorVideoMapping[$colorName] = $video;
                    }
                }
            }
            // Convert the array to an object
            return json_encode($colorVideoMapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        } else {
            return null;
        }
    }

    ## convert Overmounting sku to sama sku
    public function convertToSamaSku($overmountingData)
    {
        $sku = $overmountingData['sku'];
        $fractionsemimount = $overmountingData['fractionsemimount'];
        if (is_null($fractionsemimount) || empty($fractionsemimount)) {
            $fractionsemimount = '000';
        } else {
            $mount = explode(' ', $fractionsemimount);
            $mount0 = isset($mount[0]) ? $mount[0] : '';
            $mount1 = isset($mount[1]) ? $mount[1] : '';
            $totalMount = explode('/', $mount0);
            $totalMount0 = isset($totalMount[0]) ? $totalMount[0] : '';
            $totalMount1 = isset($totalMount[1]) ? $totalMount[1] : '';
            $fractionsemimount = $totalMount0 . ($totalMount1 ? $totalMount1 : '');
        }
        $internal_sku = "SA" . str_replace('/', '', $sku) . '-' . $fractionsemimount;
        return $internal_sku;
    }

    public function generateSamaSKU($sku, $fractionsemimount)
    {
        // Clean up the fractionsemimount
        if ($fractionsemimount != NULL) {
            $fractionsemimount_cleaned = str_replace(['ct', 'tw', '/'], '', $fractionsemimount);
            $fractionsemimount_cleaned = trim($fractionsemimount_cleaned);
        } else {
            $fractionsemimount_cleaned = '000'; // Default if fractionsemimount is null
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
