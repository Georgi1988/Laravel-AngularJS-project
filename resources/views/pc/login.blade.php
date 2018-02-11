<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
        <title>DingDing Start</title>
        <!-- Styles -->
		<link href="{{url('')}}/css/jquery-ui.min.css" type="text/css" rel="stylesheet"/>
		<link href="{{url('')}}/css/bootstrap-switch.min.css" rel="stylesheet"/>
		<link href="{{url('')}}/css/style.css" type="text/css" rel="stylesheet"/>
		<link rel="shortcut icon" href="images/dellecomicon.ico">
    </head>
    <body class="startbg">
		<div class="container_start">
			<div class="generalblock textcenter">
				<img src="{{url('')}}/images/start_logo.png" class="startlogo" alt="startlogo" />
				<figure class="startfigure">DELL服务卡<br />服务卡销售和管理系统</figure>
			</div>
			<hr class="middleline" />
			<div id="loginBtn" class="generalblock textcenter">
				<a class="startbtn" onclick="login()">进入系统</a>
			</div>
			<div id="failMsg">
			</div>
			<div class="generalblock textcenter margintop30">
				<p class="lineheight250">产品咨询：400-123-4567</p>
				<p class="lineheight250">如有疑问请联系服务卡销售和管理系统客服（工作时间8点-20点）</p>
			</div>
		</div>
    </body>
	<script src="{{url('')}}/js/jquery-1.12.4.min.js"></script>
	<!-- dingding api javascript files -->
	<script type="text/javascript" src="//g.alicdn.com/dingding/dingtalk-pc-api/2.5.0/index.js"></script>
	<script type="text/javascript">var _config = <?php echo dingAuth::getConfig();?></script>
	<script type="text/javascript">
		var busy = false;

		var protocol = location.protocol;
		var slashes = protocol.concat("//");
		var host = slashes.concat(window.location.hostname);

		var login_after_url = host + '/home';
		var reload = false;
		if(window.location.pathname == '/'){
			login_after_url = host + '/home';
		}else{
			reload = true;
			login_after_url = location.href;
		}
		
		function login() {
			if (busy) return;
			//$("#nowloading").css("display", "block");
			busy = true;
			$('#loginBtn').html('<a class="startbtn">正在进入系统<span>&nbsp<img src="./images/progress.gif" width="13px"></span></a>');
			$('#failMsg').html('');
//			console.log("login try");
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
			

			DingTalkPC.userid = 0;
			// When dingding api config success
			DingTalkPC.ready(function(res){
//				console.log("api call Ready");
				DingTalkPC.runtime.permission.requestAuthCode({
					corpId: _config.corpId, //企业ID
					onSuccess: function(info) {
						/*{
						code: 'hYLK98jkf0m' //string authCode
						}*/
//						console.log('authcode: ' + info.code);
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
//									console.log('user id: ' + info.userid);
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
//											console.log(data);
											if (info.errcode === 0) {
//												console.log("login success");
												//window.location = "/home";
												if(!reload)
													window.location = login_after_url;
												else 
													location.reload();
												
												/* //DingTalkPC.userid = info.userid;
												userdetail = data;
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
//															console.log(data);
															departstruct = data;
//															console.log("login success");
															window.location = login_after_url;
														}
														else {
//															console.log('auth error: ' + data);
															busy = false;
														}
													},
													error: function (xhr, errorType, error) {
//														console.log(errorType + ', ' + error);
														busy = false;
													}
												}); */
											}
											else {
//												console.log('auth error: ' + data);
												$('#loginBtn').html('');
												$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
												busy = false;
											}
										},
										error: function (xhr, errorType, error) {
//											console.log(errorType + ', ' + error);
											$('#loginBtn').html('');
											$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
											busy = false;
										}
									});
								}
								else {
//									console.log('auth error: ' + data);
									$('#loginBtn').html('');
									$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
									busy = false;
								}
							},
							error: function (xhr, errorType, error) {
//								console.log(errorType + ', ' + error);
								$('#loginBtn').html('');
								$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
								busy = false;
							}
						});
						
					},
					onFail : function(err) {
//						console.log(JSON.stringify(err));
						$('#loginBtn').html('');
						$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
						busy = false;
					}
				});
			});
			// When dingding api config fails
			DingTalkPC.error(function(error){
				$('#loginBtn').html('');
				$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
				busy = false;
			});
		}
	</script>
</html>