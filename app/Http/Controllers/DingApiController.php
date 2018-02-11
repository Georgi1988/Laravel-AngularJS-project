<?php

namespace App\Http\Controllers;

use App;
use App\User;
use Illuminate\Http\Request;
use mProvider;
use dingAuth;
use dingUser;

class DingApiController extends Controller
{
    public function index(Request $request){
        
        $event = $request->input('event');

        switch ($event){
			case 'get_userinfo':
				$accessToken = dingAuth::getAccessToken();
				$code = $request->input('code');
				$userInfo = dingUser::getUserInfo($accessToken, $code);
				// Log::i("[USERINFO]".json_encode($userInfo));
				$result = json_encode($userInfo);
				break;
			case 'get_userdetail':	// login process
			
				$ret_array = array('errcode' => 0);
				
				$top_dealer = App\Dealer::find(1);
				if(null !== $top_dealer) $root_dep_id = $top_dealer->dd_account;
				else $root_dep_id = '44672379';
			
				$accessToken = dingAuth::getAccessToken();
				$userId = $request->input('userid');
				$userDetail = dingUser::getUserDetail($accessToken, $userId);
				$userDetailArray = json_decode($userDetail, true);

				if ($userDetailArray['errcode'] == 0) {
					$request->session()->put('user_info', $userDetailArray);
				}else{
					$ret_array['errcode'] = 1;
				}
				
				/***************************************
					
					Lewis dealer synchronize part
					
				***************************************/
				
				$dealer_id = $userDetailArray['department'][0];
				
				if($root_dep_id != $dealer_id){
					$dealer_architecture = array();
					do{
						$departmentStr = dingUser::getDepartmentInfo($accessToken, $dealer_id);
						$departmentArray = json_decode($departmentStr, true);
						if ($departmentArray['errcode'] == 0) {
							$dealer_id = $departmentArray['parentid'];
							$dealer_architecture[] = $departmentArray;
						}else{
							$ret_array['errcode'] = 1;
							echo json_encode($ret_array); exit;
						}
					}while($dealer_id != $root_dep_id);
					$dealer_architecture = array_reverse($dealer_architecture);
					
					foreach($dealer_architecture as $dealer_item){
						$dealer = App\Dealer::where('dd_account', $dealer_item["id"])->first();
						if(null === $dealer){
							
							$parent_dealer = App\Dealer::where([
									['dd_account', '=', $dealer_item['parentid']]
								])->first();
							
							if($parent_dealer !== null){
								$parent_id = $parent_dealer->id;
								$level = $parent_dealer->level + 1;
							}else{
								$parent_id = 1;
								$level = 1;
							}	
							
							$dealer = new App\Dealer();
							$dealer->name = $dealer_item['name'];
							$dealer->dd_account = $dealer_item['id'];
							$dealer->parent_id = $parent_id;
							$dealer->level = $level;
							$dealer->save();
							$dealer_level[''.$dealer->dd_account] = $dealer;						
						}else{
							$dealer->name = $dealer_item['name'];
							$dealer->save();
						}
					}
					//var_dump($dealer_architecture); echo "---";
					
				}
				//echo $userDetailArray['department'][0]; echo "---";
				//var_dump($departmentArray); echo "---";
				
				
				/***************************************					
					The end of Lewis dealer synchronize part					
				***************************************/
				
				
				
				/* $departmentList = dingUser::getDepartmentList($accessToken);
				$departmentListArray = json_decode($departmentList, true);

				if ($departmentListArray['errcode'] == 0) {
					$request->session()->put('dept_info', $departmentListArray);
				}else{
					$ret_array['errcode'] = 1;
				} */
				
				$result = json_encode($userDetail);
				//$result = json_encode($ret_array);
				
				
				/********************************************
							Login Process Part
				********************************************/
				
				$user_dingtalk_info = $request->session()->get('user_info');
				
				$dealer_level = [
					//"".$root_dep_id => ["id"=> 1, "level" => 0, "parent_id" => ""]
				];
				
				$dealers = App\Dealer::orderBy('id')->get();
				foreach ($dealers as $dealer_item) {
					$dealer_level[''.$dealer_item['dd_account']] = $dealer_item;
				}
				
				// dealer save if not exist
				/* $dealer_dingtalk_info = $request->session()->get('dept_info');
				foreach($dealer_dingtalk_info['department'] as $dealer_item){
					$dealer = App\Dealer::where('dd_account', $dealer_item["id"])->first();
					if(null === $dealer){
						$dealer = new App\Dealer();
						$dealer->name = $dealer_item['name'];
						$dealer->dd_account = $dealer_item['id'];
						if(isset($dealer_level[''.$dealer_item['parentid']])){
							$dealer->parent_id = $dealer_level[''.$dealer_item['parentid']]['id'];
							$dealer->level = $dealer_level[''.$dealer_item['parentid']]['level'] + 1;
						}
						$dealer->save();						
						$dealer_level[''.$dealer->dd_account] = $dealer;						
					}
				} */
				
				// user save
				$dealer_dingtalk_id = $user_dingtalk_info["department"][0];
				
				$cur_dealer = App\Dealer::where('dd_account', $dealer_dingtalk_id)->first();
				$up_dealer = App\Dealer::where('id', $cur_dealer['parent_id'])->first();
				$down_dealers = App\Dealer::where('parent_id', $cur_dealer['id'])->get();
				
				$user = App\User::where('dd_account', $user_dingtalk_info["userid"])->first();
				if (null === $user) $user = App\User::where('link', $user_dingtalk_info["mobile"])->first();

				if(null === $user){
					$user = new App\User();
					
					// Message last id store to user table
					$message = App\Message::orderByDesc('id')->first();
					$last_message_id = (null === $message)? 0: $message->id;
					
					$user->name = (isset($user_dingtalk_info["name"]))? $user_dingtalk_info["name"] : "";
					$user->link = (isset($user_dingtalk_info["mobile"]))? $user_dingtalk_info["mobile"] : "";
					$user->last_message_id = $last_message_id;
					
				}
				
				$dealer = App\Dealer::where('dd_account', $dealer_dingtalk_id)->first();	
				
				$user->email = (isset($user_dingtalk_info["email"]))? $user_dingtalk_info["email"] : "";
				$user->dd_account = (isset($user_dingtalk_info["userid"]))? $user_dingtalk_info["userid"] : "";
				$user->avatar = $user_dingtalk_info["avatar"];
				$user->dealer_id = $dealer->id;
				
				if($cur_dealer['level'] == 0){
					$user->role_id = 1;
				}else{
					$role_id_val = App\Role::where('name', '=', $user_dingtalk_info["position"])->first();
					if(null !== $role_id_val) {$user->role_id = $role_id_val->id;}
					else {$user->role_id = 3;}
				}
				
				$user->save();

				//total info to session
				
				$is_leader = json_decode($user_dingtalk_info["isLeaderInDepts"]);

				if($cur_dealer['level'] == 0) 
					$authority = "admin";
				else if(strpos($user_dingtalk_info["isLeaderInDepts"], $dealer_dingtalk_id.":true") !== false) 
					$authority = "dealer";
				else if($user->role_id == 1 || $user->role_id == 2) 
					$authority = "dealer";
				else
					$authority = 'seller';
				
				$request->session()
					->put('total_info', 
							array(
								"authority" => $authority,
								"user_id" => $user->id,
								"dealer_id" => $user->dealer_id,
								"level" => $cur_dealer['level'],
								"up_dealer" => $up_dealer, 
								"down_dealers" => $down_dealers)
						);
				
				$request->session()->put('site_priv', $authority);
				
				break;
			/* case 'get_departmentlist':
				$accessToken = dingAuth::getAccessToken();
				$departmentList = dingUser::getDepartmentList($accessToken);
				$departmentListArray = json_decode($departmentList, true);
				if ($departmentListArray['errcode'] == 0) {
					// Set the session when success
					$request->session()->put('dept_info', $departmentListArray);
				}
				$result = json_encode($departmentList);
				break; */
        }
		
        return $result;
    }

    public function getUserInfo() {

    }
}