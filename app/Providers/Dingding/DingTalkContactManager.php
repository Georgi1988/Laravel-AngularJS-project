<?php

/*****************************************************************************************
 *   Module Name:
 *     File Name:
 *      Function:
 *   Description:
 * First Created:
 * Last Modified:
 *    Created By:
 *****************************************************************************************
 */
namespace App\Providers\Dingding;

use Illuminate\Support\ServiceProvider;
use App;
use Illuminate\Http\Request;
use dingAuth;

class DingTalkContactManager extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
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


    /**
     * Get a list of departments
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/department/list?access_token=ACCESS_TOKEN
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * -------------    --------------      -------     ----------------------------
     * access_token     String              Yes         Call Interface credentials
     * only             String              No          Contacts language (default zh_CN additional support en_US)
     * id               String              Yes         Father department id
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "department": [
     *          {
     *              "id": 2,
     *              "name": "钉钉事业部",
     *              "parentid": 1,
     *              "createDeptGroup": true,
     *              "autoAddUser": true
     *          },
     *          {
     *              "id": 3,
     *              "name": "服务端开发组",
     *              "parentid": 2,
     *              "createDeptGroup": false,
     *              "autoAddUser": false
     *          }
     *      ]
     *  }
     *
     * parameter        Explanation
     * -------------    ----------------------------------------
     * ERRCODE          Return code
     * errmsg           On the return code text description
     * department       Department list data. order field to departments in ascending order
     * id               Department id
     * name             Department name
     * parentid         Father department id, root division 1
     * createDeptGroup  Is synchronized to create a group of companies associated with this sector, true representation is,
     *                  false representation is not
     * autoAddUser      Once the group has been created, whether there are new entrants sector will automatically join the group,
     *                  true representation is, false representation is not
     *
     *
     * @param $departmentId
     * @param null $only
     * @return string
     */
    public static function getDepartmentList($departmentId, $only = null)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/department/list",
            array("access_token" => $accessToken,
                "id" => $departmentId)
        );

        return json_encode($response);
    }




    /**
     * Gets Unit details
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/department/get?access_token=ACCESS_TOKEN&id=2
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * -------------    --------------      --------    --------------------
     * access_token     String              Yes         Call Interface credentials
     * id               String              Yes         Department id
     * only             String              no          Contacts language (default zh_CN additional support en_US)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "id": 2,
     *      "name": "钉钉事业部",
     *      "order" : 10,
     *      "parentid": 1,
     *      "createDeptGroup": true,
     *      "autoAddUser": true,
     *      "deptHiding" : true,
     *      "deptPerimits" : "3|4",
     *      "userPerimits" : "userid1|userid2",
     *      "outerDept" : true,
     *      "outerPermitDepts" : "1|2",
     *      "outerPermitUsers" : "userid3|userid4",
     *      "orgDeptOwner" : "manager1122",
     *      "deptManagerUseridList" : "manager1122|manager3211"
     *  }
     *
     * parameter                Explanation
     * -------------            ---------------------------------------------------
     * ERRCODE                  Return code
     * errmsg                   On the return code text description
     * id                       Department id
     * name                     Department name
     * parentid                 Father department id, root division 1
     * order                    Order value in the parent department
     * createDeptGroup          Is synchronized to create a group of companies associated with this sector, true representation is,
     *                          false representation is not
     * autoAddUser              Once the group has been created, whether there are new entrants sector will automatically join the group,
     *                          true representation is, false representation is not
     * deptHiding               Department is hidden, true representation hide, false representation display
     * deptPerimits             You can view a list of other departments specified hidden sector, if hidden sector, this value take effect
     *                          for other sectors id value consisting of the string and | symbols split
     * userPerimits             You can view a list of other officers designated hiding department, department if hidden,
     *                          this value take effect, the value of other people userid consisting of the string and | symbols split
     * outerDept                Do employees in this sector only visible employees themselves, is true, the staff of the department default
     *                          can only see their own employees
     * outerPermitDepts         Employees of the department employees themselves visible only to true, you can configure additional visible department,
     *                          department id is composed of a string, use | the symbols split
     * outerPermitUsers         Employees of the department employees themselves visible only to true, you can configure additional visible staff,
     *                          userid is composed of the string and | symbols split
     * orgDeptOwner             Enterprise group main group
     * deptManagerUseridList    A list of the competent authorities, the value of String userid in charge of the composition of the ground,
     *                          use a different userid | symbols split
     *
     *
     * @param $departmentId
     * @param null $only
     * @return string
     */
    public static function getUnitDetails($departmentId, $only = null)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/department/get",
            array("access_token" => $accessToken,
                "id" => $departmentId)
        );

        return json_encode($response);
    }




    /**
     * Creating a Department
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: POST
     *
     * https://oapi.dingtalk.com/department/create?access_token=ACCESS_TOKEN
     *
     * Request packet structure
     *
     *  {
     *      "name": "钉钉事业部",
     *      "parentid": "1",
     *      "order": "1",
     *      "createDeptGroup": true,
     *      "deptHiding" : true,
     *      "deptPerimits" : "3|4",
     *      "userPerimits" : "userid1|userid2",
     *      "outerDept" : true,
     *      "outerPermitDepts" : "1|2",
     *      "outerPermitUsers" : "userid3|userid4"
     *  }
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     ---------------     --------    ---------------------------------------
     * access_token     String              Yes         Call Interface credentials
     * name             String              Yes         Department name. Length is limited to 1 to 64 characters.
     * parentid         String              Yes         Father department id. Root department id 1
     * order            String              no          Order value in the parent department. order higher-ranking small value
     * createDeptGroup  Boolean             no          Whether to create a group of companies associated with this sector, the default is false
     * deptHiding       Boolean             no          Department is hidden, true representation hide, false representation display
     * deptPerimits     String              no          You can view a list of other departments specified hidden sector, if hidden sector, this value take effect
     *                                                  for other sectors id value consisting of the string and | symbols split
     * userPerimits     String              no          You can view a list of other officers designated hiding department, department if hidden, this value take effect,
     *                                                  the value of other people userid consisting of the string and | symbols split
     * outerDept        Boolean             no          Do employees in this sector only visible employees themselves, is true, the staff of the department default
     *                                                  can only see their own employees
     * outerPermitDepts String              no          Employees of the department employees themselves visible only to true, you can configure additional visible department,
     *                                                  department id is composed of a string, use | the symbols split
     * outerPermitUsers String              no          Employees of the department employees themselves visible only to true, you can configure additional visible staff,
     *                                                  userid is composed of the string and | symbols split
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "created",
     *      "id": 2
     *  }
     *
     * parameter    Explanation
     * ----------   ---------------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * id           Department created id
     *
     *
     * @param $name
     * @param $parentId
     * @return string
     */
    public static function createDepartment($name, $parentId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::post("/department/create",
            array("access_token" => $accessToken),
            array("name" => $name,
                "parentid" => $parentId
            )
        );

        return json_encode($response);
    }




    /**
     * Updated department
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: POST
     *
     * https://oapi.dingtalk.com/department/update?access_token=ACCESS_TOKEN
     *
     * Request packet structure
     *
     *  {
     *      "name": "钉钉事业部",
     *      "parentid": "1",
     *      "order": "1",
     *      "id": "1",
     *      "createDeptGroup": true,
     *      "autoAddUser": true,
     *      "deptManagerUseridList": "manager1111|2222",
     *      "deptHiding" : true,
     *      "deptPerimits" : "3|4",
     *      "userPerimits" : "userid1|userid2",
     *      "outerDept" : true,
     *      "outerPermitDepts" : "1|2",
     *      "outerPermitUsers" : "userid3|userid4",
     *      "orgDeptOwner": "manager1111"
     *  }
     *
     * Parameter Description
     *
     * parameter                Parameter Type      have to     Explanation
     * --------------           --------------      -------     -------------------------------------
     * access_token             string              Yes         Call Interface credentials
     * only                     String              no          Contacts language (default zh_CN additional support en_US)
     * name                     String              no          Department name. Length is limited to 1 to 64 characters.
     * parentid                 String              no          Father department id. Root department id 1
     * order                    String              no          Order value in the parent department. order higher-ranking small value
     * id                       long                Yes         Department id
     * createDeptGroup          Boolean             no          Whether to create a group of companies associated with this sector
     * autoAddUser              Boolean             no          If there is whether new entrants sector will automatically join the department group
     * deptManagerUseridList    String              no          A list of the competent authorities, the value of String userid in charge of the composition of the ground,
     *                                                          use a different userid '| sign is divided
     * deptHiding               Boolean             no          Department is hidden, true representation hide, false representation display
     * deptPerimits             String              no          You can view a list of other departments specified hidden sector, if hidden sector, this value take effect
     *                                                          for other sectors id value consisting of the string and | symbols split
     * userPerimits             String              no          You can view a list of other officers designated hiding department, department if hidden, this value take effect,
     *                                                          the value of other people userid consisting of the string and | symbols split
     * outerDept                Boolean             no          Do employees in this sector only visible employees themselves, is true, the staff of the department default
     *                                                          can only see their own employees
     * outerPermitDepts         String              no          Employees of the department employees themselves visible only to true, you can configure additional visible department,
     *                                                          department id is composed of a string, use | the symbols split
     * outerPermitUsers         String              no          Employees of the department employees themselves visible only to true, you can configure additional visible staff,
     *                                                          userid is composed of the string and | symbols split
     * orgDeptOwner             String              no          Enterprise group main group
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "updated"
     *  }
     *
     * parameter    Explanation
     * ----------   -------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     *
     *
     * @param $name
     * @param $parentId
     * @param $departmentId
     * @return string
     */

    public static function updateDepartment($name, $parentId, $departmentId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::post("/department/update",
            array("access_token" => $accessToken),
            array("name" => $name,
                "parentid" => $parentId,
                "id" => $departmentId
            )
        );

        return json_encode($response);
    }




    /**
     * Delete department
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/department/delete?access_token=ACCESS_TOKEN&id=ID
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      --------    ------------------------
     * access_token     String              Yes         Call Interface credentials
     * id               long                Yes         Department id. (Note: You can not delete the root department; can not delete contains sub-sector, Sector Members)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "deleted"
     *  }
     *
     * parameter    Explanation
     * ---------    -------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     *
     *
     * @param $departmentId
     * @return string
     */
    public static function deleteDepartment($departmentId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/department/delete",
            array("access_token" => $accessToken,
                "parentid" => $departmentId
            )
        );

        return json_encode($response);
    }




    /**
     * According to members of the userid get unionid
     *
     * Request Description
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/getUseridByUnionid?access_token=ACCESS_TOKEN&unionid=xxxxxx
     *
     * parameter        Parameter Type      have to     Explanation
     * ----------       ---------------     --------    -----------------------------
     * access_token     String              Yes         Call Interface credentials
     * unionid          String              Yes         Uniquely identifies the user within the current range of nail open platform account, with a nail open platform account
     *                                                  can contain multiple open applications and also includes ISV applications and enterprise application suite
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "userid": "zhangsan"
     *  }
     *
     * parameter    Explanation
     * -----------  --------------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * userid       Employees unique identification ID (not modifiable)
     *
     *
     * @param $unionId
     * @return string
     */
    public static function getUseridByUnionid($unionId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/getUseridByUnionid",
            array("access_token" => $accessToken,
                "unionid" => $unionId
            )
        );

        return json_encode($response);
    }




    /**
     * Members get details
     *
     * Request Description
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/get?access_token=ACCESS_TOKEN&userid=zhangsan
     *
     * parameter        Parameter Type      have to     Explanation
     * -------------    --------------      -------     ---------------
     * access_token     String              Yes         Call Interface credentials
     * userid           String              Yes         UserID employees in the enterprise, the enterprise is used to uniquely identify a user's field.
     * only             String              no          Contacts language (default zh_CN additional support en_US)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "userid": "zhangsan",
     *      "name": "张三",
     *      "tel" : "010-123333",
     *      "workPlace" :"",
     *      "remark" : "",
     *      "mobile" : "13800000000",
     *      "email" : "dingding@aliyun.com",
     *      "active" : true,
     *      "orderInDepts" : "{1:10, 2:20}",
     *      "isAdmin" : false,
     *      "isBoss" : false,
     *      "dingId" : "WsUDaq7DCVIHc6z1GAsYDSA",
     *      "unionid" : "cdInjDaq78sHYHc6z1gsz",
     *      "isLeaderInDepts" : "{1:true, 2:false}",
     *      "isHide" : false,
     *      "department": [1, 2],
     *      "position": "工程师",
     *      "avatar": "dingtalk.com/abc.jpg",
     *      "jobnumber": "111111",
     *      "extattr": {
     *          "爱好":"旅游",
     *          "年龄":"24"
     *      }
     *  }
     *
     * parameter        Explanation
     * -------------    ---------------------------------------------------
     * ERRCODE          Return code
     * errmsg           On the return code text description
     * userid           Employees unique identification ID (not modifiable)
     * name             Member name
     * tel              Extension (ISV not visible)
     * workPlace        Office (ISV not visible)
     * remark           Remarks (ISV not visible)
     * mobile           Phone number (ISV not visible)
     * email            Staff e-mail (ISV not visible)
     * orgEmail         E-mail employees (ISV not visible)
     * active           If activated, true representation has been activated, false Not activated
     * orderInDepts     Sorting the corresponding sector, json string Map structures, key sector is Id, value is the ranking value art in this sector
     * isAdmin          Is an administrator of the enterprise, true representation is, false representation is not
     * isBoss           Whether it is a business owner, true representation is, false representation is not
     * dingId           Id nails, nail global identity identifying the user within a range, but a user can modify their own
     * unionid          In the current isv globally uniquely identify a user's identity, the user can not be modified
     * isleaderındepts  In the corresponding department in charge of whether json string, Map structure, key is Id sector, value is the personnel in this sector
     *                  if the competent, true representation is, false representation is not
     * isHide           Whether the number hidden, true representation hide, false representation does not hide
     * department       Members of the department id list
     * position         Job information
     * avatar           Avatar url
     * jobnumber        Staff no
     * extattr          Extended attributes, you can set a variety of properties (but can only show up on the phone 10 extended attributes,
     *                  which attributes specific display, go to OA management background -> Settings -> Address Book
     *                  and OA management background settings -> Settings -> Phone setting information is displayed.) of
     *
     *
     * @param $userId
     * @return string
     */
    public static function getUserDetails($userId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/get",
            array("access_token" => $accessToken,
                "userid" => $userId
            )
        );

        return json_encode($response);
    }


    /**
     * Founding member
     *
     * Interface Description (ISV default no call privileges)
     *
     * This port is a high privilege interfaces, the call will be strictly limited. Ask the administrator to complete the personal real-name authentication before calling,
     * or submit enterprise certification, the maximum number will be automatically expanded.
     *
     * Request Description
     *
     * Https request method: POST
     *
     * https://oapi.dingtalk.com/user/create?access_token=ACCESS_TOKEN
     *
     * Request packet structure
     *
     *  {
     *      "userid": "zhangsan",
     *      "name": "张三",
     *      "orderInDepts" : "{1:10, 2:20}",
     *      "department": [1, 2],
     *      "position": "产品经理",
     *      "mobile": "15913215421",
     *      "tel" : "010-123333",
     *      "workPlace" :"",
     *      "remark" : "",
     *      "email": "zhangsan@gzdev.com",
     *      "jobnumber": "111111",
     *      "isHide": false,
     *      "isSenior": false,
     *      "extattr": {
     *          "爱好":"旅游",
     *          "年龄":"24"
     *      }
     *  }
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * -------------    --------------      -------     ------------------------------
     * access_token     String              Yes         Call Interface credentials
     * userid           String              no          Employees unique identification ID (not modifiable), must be unique within the enterprise.
     *                                                  A length of 1 to 64 characters, if not pass, the server will automatically generate a userid
     * name             String              Yes         Member name. A length of 1 to 64 characters
     * orderInDepts     JSONObject          no          Sorting the corresponding sector, json string Map structures, key sector is Id, value is the ranking value art in this sector
     * department       List                Yes         Array type, which is an array of integers, members of the department id list
     * position         String              no          Job information. A length of 0 to 64 characters
     * mobile           String              Yes         cellphone number. It must be unique within the enterprise
     * tel              String              no          Extension, a length of 0 to 50 characters
     * workPlace        String              no          Office location, length of 0 to 50 characters
     * remark           String              no          Note, a length of 0 to 1000 characters.
     * email            String              no          mailbox. A length of 0 to 64 characters. It must be unique within the enterprise
     * jobnumber        String              no          Staff no. OA corresponds to the background and display the client job number column of personal data. A length of 0 to 64 characters
     * isHide           Boolean             no          Whether the number hidden, true representation hide, false representation is not hidden. After hide your phone number,
     *                                                  the phone number on your profile page hidden, but still their hair DING, launched nails free business telephone.
     * isSenior         Boolean             no          Whether executives mode, true representation is, false representation is not. When turned on, the phone number is hidden from all employees.
     *                                                  Ordinary employees can not send them DING, launched nails free business telephone. Between the affected executives.
     * extattr          JSONObject          no          Extended attributes, you can set a variety of properties (but can only show up on the phone 10 extended attributes,
     *                                                  which attributes specific display, go to OA management background -> Settings -> Address Book
     *                                                  and OA management background settings -> Settings -> Phone setting information is displayed.)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "created",
     *      "userid": "dedwefewfwe1231"
     *  }
     *
     * parameter    Explanation
     * ----------   ---------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * userid       Employees unique identification
     *
     *
     * @param $name
     * @param $department
     * @param $position
     * @param $mobile
     * @param $workPlace
     * @param $email
     * @return string
     */
    public static function createUser($name, $department, $position, $mobile, $workPlace, $email)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::post("/user/create",
            array("access_token" => $accessToken),
            array("name" => $name,
                "department" => $department,
                "position" => $position,
                "mobile" => $mobile,
                "workPlace" => $workPlace,
                "email" => $email
            )
        );

        return json_encode($response);
    }




    /**
     * Update members
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: POST
     *
     * https://oapi.dingtalk.com/user/update?access_token=ACCESS_TOKEN
     *
     * Request packet structure
     *
     *  {
     *      "userid": "zhangsan",
     *      "name": "张三",
     *      "department": [1, 2],
     *      "orderInDepts": "{1:10}",
     *      "position": "产品经理",
     *      "mobile": "15913215421",
     *      "tel" : "010-123333",
     *      "workPlace" :"",
     *      "remark" : "",
     *      "email": "zhangsan@gzdev.com",
     *      "jobnumber": "111111",
     *      "isHide": false,
     *      "isSenior": false,
     *      "extattr": {
     *          "爱好":"旅游",
     *          "年龄":"24"
     *      }
     *  }
     *
     * (Non-set values ​​if necessary before the field is not specified, the nail does not change the background field) Parameter Description
     *
     * parameter	    Parameter Type	    have to	    Explanation
     * ------------     --------------      -------     -------------------------------
     * access_token	    String	            Yes	        Call Interface credentialsonly	String	no	Contacts language (default zh_CN additional support en_US)
     * userid	        String	            Yes	        Employees unique identification ID (not modifiable), must be unique within the enterprise. A length of 1 to 64 characters
     * name	            String	            Yes	        Member name. A length of 1 to 64 characters
     * department	    List	            no	        Members of the department id list
     * orderInDepts	    JSONObject	        no	        Map actually serialized string, the Key Map is deptId, showing sector ID, Map Value is the order, the value indicating the sort,
     *                                                  the list is arranged according to descending order of the output, i.e., in descending order of output
     * position	        String	            no	        Job information. A length of 0 to 64 characters
     * mobile	        String	            no	        cellphone number. It must be unique within the enterprise
     * tel	            String	            no	        Extension, a length of 0 to 50 characters
     * workPlace	    String	            no	        Office location, length of 0 to 50 characters
     * remark	        String	            no	        Note, a length of 0 to 1000 characters.
     * email	        String	            no	        mailbox. A length of 0 to 64 characters. It must be unique within the enterprise
     * jobnumber	    String	            no	        Staff job number, corresponding to the display back to OA and the client job number column of personal data.
     *                                                  A length of 0 to 64 characters
     * isHide	        Boolean	            no	        Whether the number hidden, true representation hide, false representation is not hidden. After hide your phone number,
     *                                                  the phone number on your profile page hidden, but still their hair DING, launched nails free business telephone.
     * isSenior	        Boolean	            no	        Whether executives mode, true representation is, false representation is not. When turned on, the phone number is hidden
     *                                                  from all employees. Ordinary employees can not send them DING, launched nails free business telephone. Between the affected executives.
     * extattr	        JSONObject	        no	        Extended attributes, you can set a variety of properties (but can only show up on the phone 10 extended attributes,
     *                                                  which attributes specific display, go to OA management background -> Settings -> Address Book
     *                                                  and OA management background settings -> Settings -> Phone setting information is displayed.)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "updated"
     *  }
     *
     * parameter	Explanation
     * ---------    --------------------
     * errcode	    Return code
     * errmsg	    On the return code text description
     */
    public static function updateUser($name, $department, $position, $mobile, $workPlace)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::post("/user/update",
            array("access_token" => $accessToken),
            array("name" => $name,
                "department" => $department,
                "position" => $position,
                "mobile" => $mobile,
                "workPlace" => $workPlace
            )
        );

        return json_encode($response);
    }




    /**
     * Remove members
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/delete?access_token=ACCESS_TOKEN&userid=ID
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      -------     -------------------------------
     * access_token     String              Yes         Call Interface credentials
     * userid           String              Yes         Employees unique identification ID (not modifiable)
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "deleted"
     *  }
     *
     * parameter    Explanation
     * ----------   ----------------------------
     * errcode      Return code
     * errmsg       On the return code text description
     *
     *
     * @param $userId
     * @return string
     */
    public static function removeUser($userId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/delete",
            array("access_token" => $accessToken, "userid" => $userId)
        );

        return json_encode($response);
    }




    /**
     * Batch delete members
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: POST
     *
     * https://oapi.dingtalk.com/user/batchdelete?access_token=ACCESS_TOKEN
     *
     * Request packet structure
     *
     *  {
     *      "useridlist":["zhangsan","lisi"]
     *  }
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      -------     ------------------------
     * access_token     String              Yes         Call Interface credentials
     * useridlist       List                Yes         Employees UserID list. List length between 1 and 20
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "deleted"
     *  }
     *
     * parameter    Explanation
     * ----------   -----------------------------
     * errcode      Return code
     * errmsg       On the return code text description
     *
     * @param $userIdList
     * @return string
     */
    public static function removeUsers($userIdList)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::post("/user/batchdelete",
            array("access_token" => $accessToken),
            array("useridlist" => $userIdList)
        );

        return json_encode($response);
    }




    /**
     * Gets Sector Members
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/simplelist?access_token=ACCESS_TOKEN&department_id=1
     *
     * Parameter Description
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      -------     ------------------------
     * access_token     String              Yes         Call Interface credentials
     * only             String              no          Contacts language (default zh_CN additional support en_US)
     * department_id    long                Yes         Get the department id
     * offset           long                no          Support paging query, set to take effect at the same time when the size parameter, which represents the offset
     * size             int                 no          Support paging query, set to take effect at the same time when the offset parameter, which represents the page size, maximum 100
     * order            String              no          Support paging query, collation Sector Members, the default does not pass are sorted by custom;
     *                                                  entry_asc representatives in chronological ascending into the sector, entry_desc representatives in chronological descending
     *                                                  into the sector, modify_asc represents the modification time ascending according to department information, modify_desc representatives
     *                                                  according to the department descending time information modification, custom behalf of a user defined
     *                                                  (not defined according phonetic) ordering
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "hasMore": false,
     *      "userlist": [
     *          {
     *              "userid": "zhangsan",
     *              "name": "张三"
     *          }
     *      ]
     *  }
     *
     * parameter    Explanation
     * -----------  ------------------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * hasMore      Returned when paging query, does it mean that there are more data Next
     * userlist     Member list
     * userid       Employees unique identification ID (not modifiable)
     * name         Member name
     *
     *
     * @param $departmentId
     * @return string
     */
    public static function getUsersByDepartment($departmentId)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/simplelist",
            array("access_token" => $accessToken,
                "department_id" => $departmentId
            )
        );

        return json_encode($response);
    }




    /**
     * Gets Sector Members (details)
     *
     * Request Description (ISV default no call privileges)
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/list?access_token=ACCESS_TOKEN&department_id=1
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      -------     -----------------------------------
     * access_token     String              Yes         Call Interface credentials
     * only             String              no          Contacts language (default zh_CN additional support en_US)
     * department_id    long                Yes         Get the department id
     * offset           long                Yes         Support paging query, set to take effect at the same time when the size parameter, which represents the offset
     * size             int                 Yes         Support paging query, set to take effect at the same time when the offset parameter, which represents the page size, maximum 100
     * order            String              no          Support paging query, collation Sector Members, the default does not pass are sorted by custom;
     *                                                  entry_asc representatives in chronological ascending into the sector, entry_desc representatives in chronological descending
     *                                                  into the sector, modify_asc represents the modification time ascending according to department information,
     *                                                  modify_desc representatives according to the department descending time information modification,
     *                                                  custom behalf of a user defined (not defined according phonetic) ordering
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "hasMore": false,
     *      "userlist":[
     *          {
     *              "userid": "zhangsan",
     *              "dingId": "dwdded",
     *              "mobile": "13122222222",
     *              "tel" : "010-123333",
     *              "workPlace" :"",
     *              "remark" : "",
     *              "order" : 1,
     *              "isAdmin": true,
     *              "isBoss": false,
     *              "isHide": true,
     *              "isLeader": true,
     *              "name": "张三",
     *              "active": true,
     *              "department": [1, 2],
     *              "position": "工程师",
     *              "email": "zhangsan@alibaba-inc.com",
     *              "avatar":  "./dingtalk/abc.jpg",
     *              "jobnumber": "111111",
     *              "extattr": {
     *                  "爱好":"旅游",
     *                  "年龄":"24"
     *              }
     *          }
     *      ]
     *  }
     *
     * parameter    Explanation
     * ----------   -------------------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * hasMore      Returned when paging query, does it mean that there are more data Next
     * userlist     Member list
     * userid       Employees unique identification ID (not modifiable)
     * order        Sorting represents staff in this sector, the list is arranged according to descending order of the output, i.e., in descending order of output
     * dingId       Nails ID
     * mobile       Phone number (ISV not visible)
     * tel          Extension (ISV not visible)
     * workPlace    Office (ISV not visible)
     * remark       Remarks (ISV not visible)
     * isAdmin      Whether it is the administrator of the enterprise, true representation is, false representation is not
     * isBoss       Whether it is a business owner, true representation is, false representation is not
     * isHide       Whether hidden numbers, true representation is, false representation is not
     * isLeader     Whether the competent authorities, true representation is, false representation is not
     * name         Member name
     * active       It means that the user activates the nail
     * department   Members of the department id list
     * position     Job information
     * email        Employees mailbox
     * orgEmail     E-mail staff
     * avatar       Avatar url
     * jobnumber    Staff no
     * extattr      Extended attributes, you can set a variety of properties (but can only show up on the phone 10 extended attributes, which attributes specific display,
     *              go to OA management background -> Settings -> Address Book and OA management background settings -> Settings -> Phone setting information is displayed.)
     *
     *
     * @param       $departmentId
     * @param       $offset
     * @param       $size
     * @return      string
     */
    public static function getUsersByDepartmentInDetail($departmentId, $offset, $size)
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/list",
            array("access_token" => $accessToken),
            array("department_id" => $departmentId,
                "offset" => $offset,
                "size" => $size
            )
        );

        return json_encode($response);
    }




    /**
     * Get the list of administrators
     *
     * Https request method: GET
     *
     * https://oapi.dingtalk.com/user/get_admin?access_token=ACCESS_TOKEN
     *
     * parameter        Parameter Type      have to     Explanation
     * ------------     --------------      -------     ---------------------------------
     * access_token     String              Yes         Call Interface credentials
     *
     * Back to Results
     *
     *  {
     *      "errcode": 0,
     *      "errmsg": "ok",
     *      "adminList":[
     *          { "sys_level":2,"userid":"123abc" }
     *          {"sys_level":1,"userid":"456efg"}
     *      ]
     *  }
     *
     * parameter    Explanation
     * ----------   ---------------------
     * ERRCODE      Return code
     * errmsg       On the return code text description
     * sys_level    Administrator Role 1: Primary Administrator, 2: Sub-Administrator
     *
     *
     * @return string
     */

    public static function getAdministratorsList()
    {
        $accessToken = dingAuth::getAccessToken();

        $response = Http::get("/user/get_admin",
            array("access_token" => $accessToken)
        );

        return json_encode($response);
    }
}