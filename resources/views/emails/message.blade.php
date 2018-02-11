<!doctype html>
<html>
<head>
	<title>{{$data->message}}</title>
</head>
<body>
	<h1>你好！刚才到了戴尔服务卡管理系统-通知</h1>
	<p> </p>
	<p> 
		@if(isset($data->html_message) && $data->html_message != "")
			{!! $data->html_message !!}
		@else
			{{$data->message}}
		@endif
	</p>
	<p style="text-align: left; text-indent: 15px; color: gray;">
		谢谢！
	</p>
	<p style="text-align: left; text-indent: 15px; color: gray;">
		DELL服务卡销售和管理系统
	</p>
</body>
</html>