<?php
use Illuminate\Routing\UrlGenerator;
use App\Models\Admin\CategoryListing as CategoryListing;
use App\Event as EVENT;
use App\Store as STORE;
use App\Permission as Roles;
use App\User as USER;
use App\Category as CATEGORY;
use Illuminate\Support\Facades\Session;


function startQL($param = null) {
		if ($param) {
			\DB::connection($param)->enableQueryLog();
		} else {
			\DB::enableQueryLog();
		}
	}

	function showQL($param = null) {
		if ($param) {
			dd(\DB::connection($param)->getQueryLog());
		} else {
			dd(\DB::getQueryLog());
		}
	}

	/*function getSiteBySiteId($param) {
		$site = '';
		if (auth()->user()->role_id == 7) {
			$site = DB::table('sites')->where('site_id', $param)->first();
		} else {
			$site = DB::connection('mysql2')->table('sites')->where('site_id', $param)->first();
		}
		return $site;
	}*/


	function sanitize_slug($text) {
		if (empty($text)) {
			return "";
		}
		// replace .
		$text = str_ireplace(".", "-9874-", $text);
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		$text = trim($text, '-'); // trim
		// transliterate
		$text = specialChar_to_english_letters($text);
		// lowercase
		$text = strtolower($text);
		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);
		// replace -9874- back to .
		$text = str_ireplace("-9874-", ".", $text);
		return $text;
	}

	function specialChar_to_english_letters($text) {
		return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($text));
	}

    function getAllSites(){
        return \App\Site::select('name', 'id')->orderBy('name')->get();
    }

    function getSiteID() {
	    return Session::get("SITE_ID");
    }


?>
