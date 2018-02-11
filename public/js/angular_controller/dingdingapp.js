
var dingdingApp = angular.module("dingdingApp", /*['infinite-scroll'],*/ ["ngRoute"], function($interpolateProvider) {
	$interpolateProvider.startSymbol('{?');
	$interpolateProvider.endSymbol('?}');
});

dingdingApp.run(function($rootScope) {
    $rootScope.$on("$locationChangeStart", function(event, next, current) { 
        // handle route changes
		
		// Bootstrap modal perfect close
		$('.modal-backdrop').css('display', 'none');
		$('.daterangepicker').css('display', 'none');
    });
});

dingdingApp.filter('months_to_string', function() {

  // Create the return function
  // set the required parameter name to **number**
  return function(months) {
	

    // Ensure that the passed in data is a number
    if(isNaN(months) || months < 0) {
		// If the data is not a number or is less than 0 (thus not having a cardinal value) return it unmodified.
		return months;
		
	}else {
		
		if(months == 0) return lang.time_forever_valid_time;
		
		var ret_str = '';
		
		var years = Math.floor(months / 12);
		var remain_months = months % 12;
		
		if(years > 1){
			ret_str = years + lang.time_years;
		}else if(years == 1){
			ret_str = years + ' ' + lang.time_year;
		}
		
		if(remain_months != 0){
			if(remain_months != 6){
				if(years > 0) ret_str += lang.time_composer_and;
				ret_str += remain_months + lang.time_months;
				if(remain_months > 1) ret_str += lang.time_months_multi_suffix;
			}else{
				if(years > 0) ret_str += lang.time_composer_and + lang.time_half;
				else ret_str += lang.time_Half + lang.time_year.toLowerCase();
			}
		}
		
		return ret_str;
    }
  }
});

dingdingApp.filter('card_valid_period', function() {
	return function(valid_period) {
		if(valid_period == null) return lang.time_forever_valid_time;
		else return valid_period;
	}
});

dingdingApp.filter('prev_dash', function() {
	return function(value) {
		if(value == null || value == "") return value;
		else return " - " + value;
	}
});

dingdingApp.filter('floor', function() {
	return function(value) {
		return Math.floor(value);
	}
});


// Bootstrap input file box
function bs_input_file() {
	
	$(".input-file").before(
		function() {
			var element = $(this).prev();
			if ($(this).prev().hasClass('input-ghost') ) {
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("a.file_choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					console.log("asdfsadfasdfasdf");
					$(this).parents('.input-file').prev().click();
					return false;
				});
				return element;
			}
		}
	);
	
}

// Bootstrap input file box
function bs_input_file_reset(id_str) {
	//console.log($(id_str).parent().find(".input-file").find('input'));
	$(id_str).val('');
	$(id_str).parent().find(".input-file").find('input').val('');
}

function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
    }));
}

function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}