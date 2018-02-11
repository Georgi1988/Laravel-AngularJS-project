<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class CustomFunctionProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
	
	public static $is_mobile = true;
	public static $locale;
	public static $view_prefix;
	public static $user_priv = "admin";
	public static $dealer_level = '';
	public static $view_prefix_priv = "admin.";
	
	 
    public function boot()
    {
		// 사용자 기기가 모바일인지, 아닌지를 판단하기
		$this::$is_mobile = $this->get_browser_info('mobile');
		view()->share('is_mobile', ($this::$is_mobile)? 'true': 'false');
		
		$this::$view_prefix = ($this::$is_mobile)? "mobile." : "pc.";

		$locale = "cn";
		view()->share('locale', $locale);

		//echo 'asdf'.Config('dingding.DIR_ROOT');
	}

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }	
	
	// Check custom is on PC or mobile?
	// 모바일인지, PC인지를 분기
	function get_browser_info($type) {
		$http_request = Request();
		
		// 사용자 기기가 모바일인지, 아닌지를 판단하기
		$user_agent = strtolower($http_request->userAgent());

		if ( $type == 'bot' ) {
			// matches popular bots
			if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
				return true;
				// watchmouse|pingdom\.com are "uptime services"
			}
		} else if ( $type == 'browser' ) {
			// matches core browser types
			if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
				return true;
			}
		} else if ( $type == 'mobile' ) {
			// matches popular mobile devices that have small screens and/or touch inputs
			// mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
			// detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
			if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
				// these are the most common
				return true;
			} else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
				// these are less common, and might not be worth checking
				return true;
			}
		}

		return false;
	}
	
	static function set_val($value, $default_null_value = null){
		return (isset($value))? $value: $default_null_value;
	}
	
	static function get_card_valid_period($months){
		if($months > 0){
			return date("Y-m-d H:i:s", strtotime('+'.$months.' months'));
		}else{
			return null;
		}
	}
	
	static function get_next_genorder($order){
		if ($order === null || $order == 0 || strlen($order) != 4)
		    return "20AA";
		else {
			$n1 = $order[0];
			$n2 = $order[1];
			$n3 = ord($order[2]) - 65;
			$n4 = ord($order[3]) - 65;
			
			$number = ($n1.$n2) * (676) + $n3 * 26 + $n4 + 1;
			
			$x12 = floor(($number) / 676);
			$number = $number - $x12 * 676;
			$x3 = floor(($number) / 26);
			$number = $number - $x3 * 26;
			$x4 = $number;
			
			return $x12.chr($x3 + 65).chr($x4 + 65);
		}
	}
	
	static function generate_image_thumbnail($source_image_path, $thumbnail_image_path, $thumb_width = 200, $thumb_height = 150)
	{
		list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);

		switch ($source_image_type) {
			case IMAGETYPE_GIF:
				$source_gd_image = imagecreatefromgif($source_image_path);
				break;
			case IMAGETYPE_JPEG:
				$source_gd_image = imagecreatefromjpeg($source_image_path);
				break;
			case IMAGETYPE_PNG:
				$source_gd_image = imagecreatefrompng($source_image_path);
				break;
		}

		if ($source_gd_image === false) {
			return false;
		}

		$source_aspect_ratio = $source_image_width / $source_image_height;
		$thumbnail_aspect_ratio = $thumb_width / $thumb_height;
		
		if ($thumbnail_aspect_ratio > $source_aspect_ratio) {
			$source_copy_width = $source_image_width;
			$source_copy_height = (int) ($source_image_width / $thumbnail_aspect_ratio);
		} else {
			$source_copy_width = (int) ($source_image_height * $thumbnail_aspect_ratio);
			$source_copy_height = $source_image_height;
		}

		$source_off_x = ($source_image_width - $source_copy_width) / 2;
		$source_off_y = ($source_image_height - $source_copy_height) / 2;
		
		$thumbnail_gd_image = imagecreatetruecolor($thumb_width, $thumb_height);
		imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, $source_off_x, $source_off_y, $thumb_width, $thumb_height, $source_copy_width, $source_copy_height);

		$img_disp = imagecreatetruecolor($thumb_width, $thumb_height);

		imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp)/2)-(imagesx($thumbnail_gd_image)/2), (imagesy($img_disp)/2)-(imagesy($thumbnail_gd_image)/2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

		imagejpeg($img_disp, $thumbnail_image_path, 50);
		imagedestroy($source_gd_image);
		imagedestroy($thumbnail_gd_image);
		imagedestroy($img_disp);

		return true;
	}
}
