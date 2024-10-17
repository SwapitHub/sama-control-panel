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
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class ProductImport implements ToCollection, WithHeadingRow
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
        $product = new ProductModel;
        $stat = 'true';
        foreach ($collection as $row) {
            if ($row->filter()->isNotEmpty()) {
                $input = $row->toArray();
                // dd($input);
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
                $input['category_id'] = $categoryId;
                $input['subcategory_ids'] = implode(',', $subcategoryIds);
                if (isset($input['default_image_url'])) {
                    $input['default_image_url'] = $input['default_image_url'];
                }
                ## insert category and subcategory

                ## added rest of the data of sheet
                $input['menu'] =  $this->menu_id;

                if (isset($input['category'])) {
                    $input['sub_category'] = $this->getSubcategoryId($input['category']);
                }
                $input['category'] = 7;
                $input['metalColor_id'] = $this->getMetalColorIdByName($input['metalcolor']);
                $input['metalType_id'] = $this->getMetalTypeIdByName($input['metaltype']);
                if ($input['parent_sku'] == NULL || $input['parent_sku'] === $input['sku']) {
                    // $input['parent_sku'] = '';
                    $input['type'] = 'parent_product';
                } else {
                    $input['type'] = 'child_product';
                }
                $images_arr = [];
                $images = explode(',', $input['images']);
                foreach ($images as $img) {
                    $images_arr[] = $img;
                }
                $input['name'] = $input['product_pg_name'];
                $input['images'] = json_encode($images) ?? null;
                $input['videos'] = isset($input['videos']) ? $this->sortVideos($input['videos']) : null;
                $input['internal_sku'] = $this->convertToSamaSku(['sku' => $input['sku'], 'fractionsemimount' => $input['fractionsemimount']]);

                $generateSlug = new ProductModel;
                $input['slug'] = $generateSlug->generateUniqueSlug(!empty($input['product_browse_pg_name']) ? $input['product_browse_pg_name'] : $input['name']);

                unset($input['subcategory']);
                unset($input['sama_sku']);
                unset($input['child_sama_sku']);
                unset($input['product_pg_name']);
                unset($input['product']);

                $matchData = ['sku' => $input['sku'], 'parent_sku' => $input['parent_sku'], 'fractionsemimount' => $input['fractionsemimount']];
                $product = ProductModel::where($matchData)->first();
                if ($product) {
                    $saved = $product->update($input);
                    if (!$saved) {
                        $stat = 'false';
                    }
                } else {
                    // Create a new product
                    // $condition = ['fractionsemimount' => $input['fractionsemimount'],'parent_sku'=>$input['parent_sku']];
                    $condition = [
                        'fractionsemimount' => $input['fractionsemimount'],
                        !empty($input['parent_sku'])?'parent_sku':'sku' =>  !empty($input['parent_sku'])?$input['parent_sku']:$input['sku'],
                    ];

                    // echo "<pre>";
                    // var_dump($condition);

                    $check = ProductModel::where($condition)->exists();
                    if (!$check) {
                        $saved = ProductModel::create($input);
                        if (!$saved) {
                            $stat = 'false';
                        }
                    }
                }
                // var_dump($saved);
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
}
