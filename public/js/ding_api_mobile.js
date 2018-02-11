// Get company config information
dd.config({
    agentId: _config.agentId,
    corpId: _config.corpId,
    timeStamp: _config.timeStamp,
    nonceStr: _config.nonceStr,
    signature: _config.signature,
    jsApiList: [
        'runtime.info',
        'device.notification.prompt',
        'biz.chat.pickConversation',
        'device.notification.confirm',
        'device.notification.alert',
        'device.notification.prompt',
        'biz.chat.open',
        'biz.util.open',
        'biz.user.get',
        'biz.contact.choose',
        'biz.telephone.call',
        'biz.ding.post']
});
dd.userid=0;

dd.ready(function() {
    console.log('dd.ready rocks!');

    dd.biz.navigation.setTitle({
        title : '邮箱正文',//控制标题文本，空字符串表示显示默认文本
        onSuccess : function(result) {
            /*结构
            {
            }*/
        },
        onFail : function(err) {}
    });

    dd.biz.navigation.setIcon({
        showIcon : true,//是否显示icon
        iconIndex : 102,//显示的iconIndex,如上图
        onSuccess : function(result) {
            /*结构
            {
            }*/
            //点击icon之后将会回调这个函数
            console.log("icon clicked.");
        },
        onFail : function(err) {
        //jsapi调用失败将会回调此函数
        }
    });

    dd.biz.navigation.setLeft({
        show: true,//控制按钮显示， true 显示， false 隐藏， 默认true
        control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
        showIcon: true,//是否显示icon，true 显示， false 不显示，默认true； 注：具体UI以客户端为准
        text: '',//控制显示文本，空字符串表示显示默认文本
        onSuccess : function(result) {
            /*
            {}
            */
            //如果control为true，则onSuccess将在发生按钮点击事件被回调
            console.log("left icon display.");
        },
        onFail : function(err) {
            console.log(err);
        }
    });

    dd.biz.navigation.setMenu({
        backgroundColor : "#ADD8E6",
        textColor : "#ADD8E611",
        items : [
            {
                "id":"1",//字符串
                "iconId":"file",//字符串，图标命名
                "text":"帮助"
            },
            {
                "id":"2",
                "iconId":"photo",
                "text":"dierge"
            },
            {
                "id":"3",
                "iconId":"setting",
              "text":"disange",
            },
            {
                "id":"4",
                "iconId":"time",
                "text":"disige"
            }
        ],
        onSuccess: function(data) {
        /*
        {"id":"1"}
        */
            console.log(data);
        },
        onFail: function(err) {
        }
    });

    dd.runtime.info({
        onSuccess: function(info) {
            console.log('runtime info: ' + JSON.stringify(info));
        },
        onFail: function(err) {
            console.log('fail: ' + JSON.stringify(err));
        }
    });

    dd.runtime.permission.requestAuthCode({
        corpId: _config.corpId, //企业id
        onSuccess: function (info) {
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
                data: {"event":"get_userinfo","code":info.code},
                dataType:'json',
                timeout: 10000,
                success: function (data, status, xhr) {
                    var info = JSON.parse(data);
                    if (info.errcode === 0) {
                        console.log('user id: ' + info.userid);
                        dd.userid = info.userid;

                        // Get user detail of dingding
                        $.ajax({
                            url: '/dingapi',
                            type:"POST",
                            data: {"event":"get_userdetail", "userid":dd.userid},
                            dataType:'json',
                            timeout: 10000,
                            success: function (data, status, xhr) {
                                var info = JSON.parse(data);
                                if (info.errcode === 0) {
                                    console.log(data);
                                    //DingTalkPC.userid = info.userid;
                                    // Get department list of company
                                    $.ajax({
                                        url: '/dingapi',
                                        type:"POST",
                                        data: {"event":"get_departmentlist"},
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
        onFail: function (err) {
            console.log('requestAuthCode fail: ' + JSON.stringify(err));
        }
    });
})