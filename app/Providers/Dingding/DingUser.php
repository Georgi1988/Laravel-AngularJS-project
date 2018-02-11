<?php

namespace App\Providers\Dingding;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class DingUser extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

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

    // Get userid of dingding by using authcode
    public static function getUserInfo($accessToken, $code)
    {
        $response = Http::get("/user/getuserinfo", array("access_token" => $accessToken, "code" => $code));
        return json_encode($response);
    }

    // Get userdetail of dingding by using userid
    public static function getUserDetail($accessToken, $userid)
    {
        $response = Http::get("/user/get", array("access_token" => $accessToken, "userid" => $userid));
        return json_encode($response);
    }

    // Get departmentlist of company
    public static function getDepartmentList($accessToken)
    {
		$response = Http::get("/department/list", array("access_token" => $accessToken, "id" => "44672379"));
		//$response = Http::get("/department/list", array("access_token" => $accessToken));
        return json_encode($response);
    }

    // Get departmentlist of company
    public static function getDepartmentInfo($accessToken, $depart_id)
    {
		$response = Http::get("/department/get", array("access_token" => $accessToken, "id" => $depart_id));
		//$response = Http::get("/department/list", array("access_token" => $accessToken));
        return json_encode($response);
    }

    public static function simplelist($accessToken,$deptId){
        $response = Http::get("/user/simplelist", array("access_token" => $accessToken,"department_id"=>$deptId));
        return $response->userlist;
    }
}