<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="dingdingApp">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>DingDing Start</title>
        <!-- Styles -->
		@yield('style_part')
		<link rel="shortcut icon" href="images/dellecomicon.ico">
    </head>
    <body class="startbg">
		<div class="container_start" ng-controller="MainController">
			<ng-view></ng-view>
		</div>
    </body>
	@yield('javascript_part')
</html>