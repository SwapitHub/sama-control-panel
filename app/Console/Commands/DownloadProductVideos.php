<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProductVideosModel;
use App\Models\SamaProductVideosModel;
use GuzzleHttp\Client;

class DownloadProductVideos extends Command
{
    protected $signature = 'videos:download';
    protected $description = 'Download Videos from url, save to SKU folder, and upload to S3';

    public function __construct()
    {
        parent::__construct();
    }

    ## script to download images on loacl storage
    public function handle()
    {
        $products = DB::table('tbl_products')->select('id', 'entity_id', 'sama_sku', 'videos')->get();
        $client = new \GuzzleHttp\Client();

        foreach ($products as $product) {
            $sku = $product->sama_sku;
            $product_id = $product->id;
            $entity_id = $product->entity_id;

            if (!is_null($product->videos)) {
                // Split the comma-separated string into an array of video URLs
                $videos = explode(',', $product->videos);

                // Check if the array is valid and not empty
                if (empty($videos)) {
                    $this->error("Empty or invalid video data for SKU: $entity_id");
                    continue;
                }

                $localFolder = storage_path("app/public/videos/$entity_id");
                if (!file_exists($localFolder)) {
                    mkdir($localFolder, 0777, true);
                }

                foreach ($videos as $videoUrl) {
                    // Clean and validate the URL
                    $videoUrl = trim($videoUrl);  // Remove any extra spaces
                    $videoUrl = filter_var($videoUrl, FILTER_SANITIZE_URL);

                    if (filter_var($videoUrl, FILTER_VALIDATE_URL) === FALSE) {
                        $this->error("Invalid video URL: $videoUrl for SKU: $entity_id");
                        continue;
                    }

                    // Check which color the video corresponds to based on the URL
                    if (strpos($videoUrl, 'white') !== false) {
                        $color = 'white';
                    } elseif (strpos($videoUrl, 'yellow') !== false) {
                        $color = 'yellow';
                    } elseif (strpos($videoUrl, 'rose') !== false) {
                        $color = 'rose';
                    } else {
                        $this->error("No recognized color found in video URL: $videoUrl for SKU: $entity_id");
                        continue;
                    }

                    // Process and download the video
                    $videoName = basename($videoUrl);
                    $extension = pathinfo($videoName, PATHINFO_EXTENSION);
                    $videoFileName = "{$entity_id}.video.{$color}.{$extension}";
                    $localPath = "$localFolder/$videoFileName";

                    try {
                        \Log::info("Attempting to download video from URL: $videoUrl");

                        // Download the video
                        $response = $client->get($videoUrl, ['sink' => $localPath]);

                        // Update the database
                        SamaProductVideosModel::updateOrCreate(
                            ['product_id' => $product_id, 'product_sku' => $sku, 'color' => $color],
                            ['video_path' => $videoFileName]
                        );
                        $this->info("Downloaded {$color} color video $videoUrl to $localPath.");
                    } catch (\GuzzleHttp\Exception\RequestException $e) {
                        $this->error("Failed to download {$color} color video $videoUrl: " . $e->getMessage());
                    } catch (\Exception $e) {
                        $this->error("Unexpected error occurred: " . $e->getMessage());
                    }
                }
            } else {
                $this->error("Empty videos for SKU: $entity_id");
            }
        }
    }
}
