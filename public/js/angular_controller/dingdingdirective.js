dingdingApp.directive("datepicker", function () {

	function link(scope, element, attrs) {
		// CALL THE "datepicker()" METHOD USING THE "element" OBJECT.
		$(element).datepicker({
			showOn: "both",
			buttonImage: base_url + "images/date.png",
			buttonImageOnly: true,
			buttonText: "Select date",
			dateFormat: "yy-mm-dd"
		});
	}

	return {
		require: 'ngModel',
		link: link
	};
});

dingdingApp.directive('ngOnFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit(attr.broadcastEventName ? attr.broadcastEventName : 'ngRepeatFinished');
                });
            }
        }
    };
});