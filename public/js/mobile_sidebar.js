
$( document ).ready(function() {
	var wscroll_position = 0;
	var sub_header_selector = "#header_fixed_navbar";
	var fix_header_offset = $(sub_header_selector).position();
	var fix_header_height = $(sub_header_selector).outerHeight();
	var subheader_offset = $(sub_header_selector).position().top;
	var subheader_height = $(sub_header_selector).outerHeight();

	function fix_sub_header() {
		$(sub_header_selector).css("position", "fixed");
		$(sub_header_selector).css("top", "0");
		$(sub_header_selector).css("z-index", "10");
		$('.fix_height').css('height', subheader_height + 'px');
	}
	function unfix_sub_header() {
		$(sub_header_selector).css("position", "static");
		$('.fix_height').css('height', '0');
	}

	window.addEventListener('scroll', function(e) {
		wscroll_position = window.scrollY;
		if (wscroll_position > fix_header_offset.top) {
			fix_sub_header();
			subheader_offset = 0;
		}else{
			unfix_sub_header();
			subheader_offset = $(sub_header_selector).position().top - wscroll_position;
		}
		set_sibebar();
	});
	
	var set_sibebar = function (){
		$("#mySidenav").css("transition", "0.01s");
		$('#mySidenav').css('top', (subheader_offset + fix_header_height) + 'px');
	}
	set_sibebar();
	
});	

	
function switchSideNav() {
	$("#mySidenav").css("transition", "0.5s");
	if($("#mySidenav").width() > 0){
		$("#mySidenav").css("width", "0");
	}else{
		$("#mySidenav").css("width", "200px");
		$("#mySidenav a").css("width", "200px");
	}
}

$(".sidebar_menu").on('click', function(){
	switchSideNav();
});

$(".nav").on('click', function(){
	$("#mySidenav").css("width", "0");
});