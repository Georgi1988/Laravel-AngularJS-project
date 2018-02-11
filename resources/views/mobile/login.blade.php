<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>@lang('lang.login')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href="{{url('')}}/css/mobile_style.css" type="text/css" rel="stylesheet"/>
	</head>
	<body class="startbg">
		<div class="container_start">
			<div class="logo_part">
				<img src="{{url('')}}/images/start_logo.png" class="startlogo" alt="startlogo" />
				<h1>DELL服务卡</h1>
				<h2>服务卡销售和管理系统</h2>
			</div>
			<div id="loginBtn" class="generalblock textcenter">
				<a class="startbtn" onclick="login()">进入系统</a>
			</div>
			<div id="failMsg">
			</div>
			<div class="generalblock about_app">
				<p class="lineheight250">产品咨询：400-123-4567</p>
				<p class="lineheight250">（工作时间8点-20点）</p>
			</div>
			<div class="copyright fontsize0_8">
				©2017 DELL电脑公司
			</div>
		</div>
	</body>
	
	<!-- dingding api javascript files -->
    <script src="{{url('')}}/js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="//g.alicdn.com/dingding/open-develop/0.8.4/dingtalk.js"></script>
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
//				console.log('dd.ready rocks!');

				dd.runtime.permission.requestAuthCode({
					corpId: _config.corpId, //企业id
					onSuccess: function (info) {
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
							data: {"event":"get_userinfo","code":info.code},
							dataType:'json',
							timeout: 10000,
							success: function (data, status, xhr) {
								var info = JSON.parse(data);
								if (info.errcode === 0) {
//									console.log('user id: ' + info.userid);
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
//												console.log(data);
//												console.log("login success");
												console.log(login_after_url);
												if(!reload)
													window.location = login_after_url;
												else 
													location.reload();
												/* userdetail = data;
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
														}
													},
													error: function (xhr, errorType, error) {
//														console.log(errorType + ', ' + error);
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
					onFail: function (err) {
//						console.log('requestAuthCode fail: ' + JSON.stringify(err));
						$('#loginBtn').html('');
						$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
						busy = false;
					}
				});
			});
			dd.error(function(error){
				$('#loginBtn').html('');
				$('#failMsg').html('<p class="color_red textcenter">不能连接到服务器, 再试一次!</p>')
				busy = false;
			});
		}
    </script>
</html>

