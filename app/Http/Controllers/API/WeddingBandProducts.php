<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\InternalProducts;
use App\Models\SamaPrices;
use App\Models\SamaProductImageModel;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\DiamondShape;
use App\Models\ProductPrice;
use App\Models\CenterStone;
use App\Models\ProductImageModel;
use App\Models\ProductSubcategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Stmt\Else_;

class WeddingBandProducts extends Controller
{

    public function index(Request $request)
    {
        $category_slug = $request->query('category');
        $subcategory_slug = $request->query('subcategory');

        $cat_id = null;
        $subcat_id = null;

        if (!empty($category_slug)) {
            $cat_id = Category::where('slug', $category_slug)->pluck('id')->first();
        }

        if (!empty($category_slug) && !empty($subcategory_slug)) {
            $subcat_id = Subcategory::where('category_id', $cat_id)
                ->where('slug', $subcategory_slug)
                ->pluck('id')
                ->first();
        }

        // $query = ProductModel::where('menu', 2)
        //     ->whereNull('products.parent_sku')
        //     ->orWhereColumn('products.sku', 'products.parent_sku')
        //     ->where('products.status', 'true');

        $query = InternalProducts::where('menu', 2)
            ->where(function ($subQuery) {
                $subQuery->whereNull('tbl_products.sama_parent_sku')
                         ->orWhere('tbl_products.sama_parent_sku', '');
                 // Check if parent_sku is null
                    // ->orWhereColumn('tbl_products.sku', 'tbl_products.parent_sku'); // Check if product sku equals parent_sku
            })
            ->where('tbl_products.status', 'true'); // Ensure status is true

        if ($cat_id) {
            $query->where('tbl_products.category', $cat_id);
        }

        if ($subcat_id) {
            $query->where('tbl_products.sub_category', $subcat_id);
        }

        if ($request->query('metal_color')) {
            $metalcolor_id = $request->query('metal_color');
            $query->where('tbl_products.metalColor_id', $metalcolor_id)
                ->orWhereNull('tbl_products.metalColor_id'); // Include products without a price entry
        }

        if ($request->query('price_range')) {
            $range = explode(',', $request->query('price_range'));
            if (count($range) == 2) {
                $min = $range[0];
                $max = $range[1];
                $query->whereBetween(DB::raw('IFNULL(tbl_products.white_gold_price, 0)'), [$min, $max]);
            }
        }

        if (!is_null($request->query('subcategory'))) {
            $subcatSlugs = explode(',', $request->query('subcategory'));
            ## Fetch corresponding IDs based on slugs
            $subcatIds = ProductSubcategory::where('category_id', 2)->whereIn('slug', $subcatSlugs)->pluck('id')->toArray();

            ## If there are IDs, use them in the WHERE clause
            if (!empty($subcatIds)) {
                $query->where(function ($querys) use ($subcatIds) {
                    foreach ($subcatIds as $id) {
                        $querys->orWhereRaw("FIND_IN_SET(?, tbl_products.subcategory_ids)", [$id]);
                    }
                });
            } else {
                $query->where("tbl_products.subcategory_ids", $request->subcategory);
            }
        }

        ## Apply sorting based on request
        if (!is_null($request->query('sortby'))) {
            $sortBy = $request->query('sortby');
            if ($sortBy == 'low_to_high') {
                // $products->orderBy('product_price.price', 'asc');
                $query->orderByRaw("CAST(tbl_products.white_gold_price AS DECIMAL(12, 4)) ASC");
            } elseif ($sortBy == 'high_to_low') {
                // $products->orderBy('product_price.price', 'desc');
                $query->orderByRaw("CAST(tbl_products.white_gold_price AS DECIMAL(12, 4)) DESC");
            } elseif ($sortBy == 'Newest') {
                $query->orderBy('tbl_products.created_at', 'desc');
            } elseif ($sortBy == 'best_seller') {
                $query->where('tbl_products.is_bestseller', '1');
            }
        }



        ####################################
        $query->select('id', 'name', 'product_browse_pg_name', 'slug', 'sama_sku', 'entity_id', 'menu', 'category_id', 'subcategory_ids', 'white_gold_price', 'yellow_gold_price', 'rose_gold_price', 'platinum_price', 'default_image_url', 'images', 'is_bestseller', 'created_at');

           // Debug the query
        // $sql = $query->toSql();
        // $bindings = $query->getBindings();

        // dd($sql, $bindings);
        $actual_count = $query->count();
        $productsList = $query->paginate(30);
        $count = $productsList->count();


        if ($count) {
            $productList = [];
            foreach ($productsList as $product) {
                $name = strtolower($product->name);
                $product->name = ucwords($name);
                $path = parse_url($product->default_image_url, PHP_URL_PATH);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                ## create image
                $defaulImg = env('AWS_URL') . 'images_and_videos/images/' . $product->entity_id . '/' . $product->entity_id . '.' . $extension;
                $product->default_image_url = $defaulImg;
                ## product images
                $pro_images =  SamaProductImageModel::where('product_id', $product['id'])->get();
                $images_arr = [];
                if (count($pro_images) > 0) {
                    foreach ($pro_images as $product_img) {
                        $pimg =   env('AWS_URL') . 'images_and_videos/images/' . $product['entity_id'] . '/' . $product_img['image_path'];
                        $images_arr[] = $pimg;
                    }
                } else {
                    $images_arr = json_decode($product['images']);
                };
                $product->images = $images_arr;
                ## product image



                // Get the prices based on different criteria
                $product->white_gold_price = SamaPrices::where('product_id', $product['id'])
                    ->where('metalType', '18kt')
                    ->where('metalColor', 'White')
                    ->where('diamond_type', 'natural')
                    ->first()
                    ->price ?? 0;

                $product->yellow_gold_price = SamaPrices::where('product_id', $product['id'])
                    ->where('metalType', '18kt')
                    ->where('metalColor', 'Yellow')
                    ->where('diamond_type', 'natural')
                    ->first()
                    ->price ?? 0;

                $product->rose_gold_price = SamaPrices::where('product_id', $product['id'])
                    ->where('metalType', '18kt')
                    ->where('metalColor', 'Pink')
                    ->where('diamond_type', 'natural')
                    ->first()
                    ->price ?? 0;

                $product->platinum_price = SamaPrices::where('product_id', $product['id'])
                    ->where('metalType', 'Platinum')
                    ->where('metalColor', 'White')
                    ->where('diamond_type', 'natural')
                    ->first()
                    ->price ?? 0;

                array_push($productList, $product);
            }
            // Attach the results to the output
            $output['count'] = $count;
            $output['product_count'] = $actual_count;
            $output['data'] = $productList;
        } else {
            $output['res'] = 'error';
            $output['msg'] = 'No product found!';
            $output['data'] = [];
            // return response()->json($output)->header('Cache-Control', 'max-age=86400, public');
        }
        ####################################
        return response()->json($output)->header('Cache-Control', 'max-age=86400, public');
    }
}
