<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProductImageModel;
use App\Models\SamaProductImageModel;
use GuzzleHttp\Client;

class DownloadAndUploadImages extends Command
{
    protected $signature = 'images:download-upload';
    protected $description = 'Download images, save to SKU folder, and upload to S3';

    public function __construct()
    {
        parent::__construct();
    }
    ## script to download images on loacl storage
    public function handle()
    {
        $products = DB::table('tbl_products')->select('id', 'entity_id', 'sama_sku', 'images')->get();
        $client = new \GuzzleHttp\Client();

        foreach ($products as $product) {
            $entity_id = $product->entity_id;
            if (!empty($product->images)) {
                $images = explode(',', $product->images);

                $localFolder = storage_path("app/public/products/$entity_id");
                if (!file_exists($localFolder)) {
                    mkdir($localFolder, 0777, true);
                }

                foreach ($images as $image) {
                    $imageName = basename($image);
                    $newNameParts = explode('.', $imageName);
                    $newNameParts[0] = $entity_id;
                    $newImageName = implode('.', $newNameParts);
                    $this->info("Old Name: $imageName, New Name: $newImageName");

                    $localPath = "$localFolder/$newImageName";

                    // Check if the image already exists
                    if (file_exists($localPath)) {
                        SamaProductImageModel::updateOrCreate(
                            ['product_id' => $product->id, 'product_sku' => $product->sama_sku, 'image_path' => $newImageName]
                        );
                        $this->info("Image $localPath already exists. Skipping download.");
                        continue;
                    }

                    // try {
                        // Download the image using the original URL
                        $imagex = trim($image);
                        $image = rtrim($imagex);
                        // $image = filter_var($image, FILTER_SANITIZE_URL);
                        $response = $client->get($image);


                        file_put_contents($localPath, $response->getBody());

                        // // Update the database
                        SamaProductImageModel::updateOrCreate(
                            ['product_id' => $product->id, 'product_sku' => $product->sama_sku, 'image_path' => $newImageName]
                        );

                        $this->info("Downloaded $image to $localPath.");
                    // }

                }
            }
        }
    }
}
