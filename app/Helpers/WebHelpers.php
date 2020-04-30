<?php
use App\Http\Controllers\Web\Routes as Routes;
use App\Site as SITES;
use DB as DB;
use App\Coupon;
use App\Store;
use App\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

function clearCache() {
	\Artisan::call('config:clear');
	return true;
}

function checkCountryAndSetConfigs() {
    if (Schema::hasTable('sites')) {
        try {
            $segments = \Request::segments();
            $segments0 = $segments[0] ?? '';
            if ($segments0 == 'us' || $segments0 == '') {
                config(['app.route_prefix' => '']);
                $segments0 = 'us';
            } else {
                config(['app.route_prefix' => $segments0]);
            }

            if($segments0=='admin'){
                return true;
            }else{

                $siteid = 0;$reg='us';
                $get = SITES::where('country_code',config('app.route_prefix'))->first();

                if($get){
                    $siteid = $get['id'];
                    $reg = $get['country_code'];

                    config(['app.db_obj' => $get]);
                }else{

                    $get = SITES::where('country_code','us')->first();
                    if($get) {
                        $siteid = $get['id'];
                        $reg = $get['country_code'];
                        config(['app.route_prefix'=>'']);

                        config(['app.db_obj' => $get]);
                    } else {
                        abort(404);
                    }
                }
                $regurl = config('app.route_prefix') ? '/'.config('app.route_prefix') : '';

                if (\App::environment('production')) {
                    config([
                        "app.siteid" => $siteid,
                        "app.Region" => $reg,
                        'app.namespace_name' => 'web',
                        'app.image_path' => str_replace( 'http://', 'https://', \URL::to('/') ),
                        'app.app_path' => str_replace( 'http://', 'https://', \URL::to('/').$regurl ),
                    ]);
                } else {
                    config([
                        "app.siteid" => $siteid,
                        "app.Region" => $reg,
                        'app.namespace_name' => 'web',
                        'app.image_path' => \URL::to('/'),
                        'app.app_path' => \URL::to('/').$regurl,
                    ]);
                }



                clearCache();
                $routes = new Routes;
                $routes = $routes->find_route($segments[0] ?? '', $segments[1] ?? '', $segments[2] ?? '', $segments[3] ?? '');
                if(defined('ROUTE_NAME')){
                 config(['app.routename'=>ROUTE_NAME]);
                 }
                return true;

            }


        } catch (\Exception $e) {
            abort(404);
        }
    }
}

function data_toArray_Web($data) {
	$data = json_encode($data);
	return json_decode($data, true);
}


function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

function get_string_between($string, $start, $end) {
	$string = " " . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) {
		return "";
	}

	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

// Function to get the client IP address
function get_client_ip() {
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}
function ip_details($IPaddress) {
	$json = file_get_contents("http://ipinfo.io/{$IPaddress}");
	$details = json_decode($json, true);
	return $details;
}
function getCouponRecord($coupon_id){
    try{
    $coupon = \App\Coupon::select('id','title','date_expiry','code','store_id','description','custom_image_title','free_shipping')->with('store:id,name,store_url')->whereId($coupon_id)->wherePublish(1)->first();
    $coupon = ($coupon) ? $coupon->toArray() : null;    
    return $coupon;
    }catch (\Exception $e) {
       // abort(404);
    }
}
function _404(){
        $data = [];
        try{
            $siteid = config('app.siteid');
            $dt = Carbon::now();
            $date = $dt->toDateString();
            $data['popularStores'] = Store::CustomWhereBasedData($siteid)->where('popular',1)->orderBy('name', 'asc')->get()->toArray();
            $query = Coupon::CustomWhereBasedData($siteid)->where('date_expiry', '>=', $date);
            $query = $query->where(function($q) {
                $q->orwhere('featured', 1)->orwhere('popular', 1);
            });
            $data['featuredCouponsAndPopularCoupons'] = $query->with('store.slugs')->orderBy('featured')->orderBy('title', 'asc')->get()->toArray();
            $data['featuredCategories'] = Category::CustomWhereBasedData($siteid)->where('featured',1)->orderBy('title', 'asc')->get()->toArray();
            $data['sites'] = SITES::select('id','country_name','country_code','url')->where('publish',1)->get()->toArray();
            return $data;
        }catch (\Exception $e) {
            abort(404);
        }

    }
function addhttps($url) {
    if (\App::environment('production')) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }
    }
    return $url;
}

?>
