// Get company config information
DingTalkPC.config({
    agentId: _config.agentId,
    corpId: _config.corpId,
    timeStamp: _config.timeStamp,
    nonceStr: _config.nonceStr,
    signature: _config.signature,
    jsApiList: [
        'runtime.permission.requestAuthCode',
        'device.notification.alert',
        'device.notification.confirm',
        'biz.contact.choose',
        'device.notification.prompt',
        'biz.ding.post'
    ] // 必填，需要使用的jsapi列表
});

DingTalkPC.userid=0;
DingTalkPC.ready(function(res){
    console.log("api call Ready");
    DingTalkPC.runtime.permission.requestAuthCode({
        corpId: _config.corpId, //企业ID
        onSuccess: function(info) {
            /*{
             code: 'hYLK98jkf0m' //string authCode
             }*/
            console.log('authcode: ' + info.code);
            // Set the ajax call header x-csrf-token value
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Get userid of dingding
            $.ajax({
                url: '/dingapi',
                type:"POST",
                data: {"event":"get_userinfo", "code":info.code},
                dataType:'json',
                timeout: 10000,
                success: function (data, status, xhr) {
                    var info = JSON.parse(data);
                    if (info.errcode === 0) {
                        console.log('user id: ' + info.userid);
                        DingTalkPC.userid = info.userid;
                        // Get user detail of dingding
                        $.ajax({
                            url: '/dingapi',
                            type:"POST",
                            data: {"event":"get_userdetail", "userid":DingTalkPC.userid},
                            dataType:'json',
                            timeout: 10000,
                            success: function (data, status, xhr) {
                                var info = JSON.parse(data);
                                if (info.errcode === 0) {
                                    console.log(data);
                                    //DingTalkPC.userid = info.userid;
                                }
                                else {
                                    console.log('auth error: ' + data);
                                }
                            },
                            error: function (xhr, errorType, error) {
                                console.log(errorType + ', ' + error);
                            }
                        });
                    }
                    else {
                        console.log('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    console.log(errorType + ', ' + error);
                }
            });
            
        },
        onFail : function(err) {
            console.log(JSON.stringify(err));
        }
    });
});
