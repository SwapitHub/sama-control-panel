<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InternalProducts extends Model
{
    use HasFactory;
    protected $table = 'tbl_products';
	protected $guarded = [];


    public static function generateUniqueSlug($title)
	{
		$slug = Str::slug($title);
		$originalSlug = $slug;
		$count = 2;
		while (static::where('slug', $slug)->exists()) {
			$slug = $originalSlug . '-' . $count;
			$count++;
		}
		return $slug;
	}


	public static function sortVideos($videos)
	{
		$videos = explode(',',$videos);
		if ($videos != NULL || !empty($videos)) {
			$colors = ['rose', 'white', 'yellow'];
			$colorVideoMapping = [];
			foreach ($videos as $video) {
				preg_match('/\.video\.(\w+)\.mp4/', $video, $matches);

				if (isset($matches[1])) {
					$colorName = $matches[1];
					if (in_array($colorName, $colors)) {
						$colorVideoMapping[$colorName] = $video;
					}
				}
			}
			return json_encode($colorVideoMapping, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
		} else {
			return null;
		}
	}
}
