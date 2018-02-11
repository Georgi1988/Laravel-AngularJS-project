
$( function() {
	msgInfoDlg = $( "#message-info" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okMsgInfoBtn" ).button().on( "click", function() {
		msgInfoDlg.dialog( "close" );
	});
	$( "#cancelMsgInfoBtn" ).button().on( "click", function() {
		msgInfoDlg.dialog( "close" );
	});
	$( "#mailinfo" ).click( function() {
		msgInfoDlg.dialog( "open" );
	});
	
	msgInfo1Dlg = $( "#message-info1" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#cancelMsgInfo1Btn" ).button().on( "click", function() {
		msgInfo1Dlg.dialog( "close" );
	});
	
	$( "#mailinfo1" ).click( function() {
		msgInfo1Dlg.dialog( "open" );
	});
	
	orderNewDlg = $( "#order-new" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okOrderNewBtn" ).button().on( "click", function() {
		orderNewDlg.dialog( "close" );
	});
	$( ".orderbtn" ).click( function() {
		orderNewDlg.dialog( "open" );
	});
	
	proAddDlg = $( "#product-add" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okProAddBtn" ).button().on( "click", function() {
		proAddDlg.dialog( "close" );
	});
	$( ".productadd" ).click( function() {
		proAddDlg.dialog( "open" );
	});
	
	proInfoDlg = $( "#product-info" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#dec_price_btn" ).button().on( "click", function() {
		priceVal = $("#dec_price_val").text();
		htmlStr = '<input type="text" id="dec_price_input" name="dec_price_input" class="input_type" value="' + priceVal +'" />元';
		$("#dec_price").html(htmlStr);
	});
	$( "#exist_cnt_btn" ).button().on( "click", function() {
		cntVal = $("#exist_cnt_val").text();
		htmlStr = '<input type="text" id="exist_cnt_input" name="exist_cnt_input" class="input_type" value="' + cntVal +'" />张';
		$("#exist_cnt").html(htmlStr);
	});
	$( ".proudctinfo" ).click( function() {
		proInfoDlg.dialog( "open" );
	});
	
	saleActivateDlg = $( "#sale-activate" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okSaleActivateBtn" ).button().on( "click", function() {
		saleActivateDlg.dialog( "close" );
	});
	$( "#cancelSaleActivateBtn" ).button().on( "click", function() {
		saleActivateDlg.dialog( "close" );
	});
	$( ".saleactivate" ).click( function() {
		saleActivateDlg.dialog( "open" );
	});
	
	saleRegDlg = $( "#sale-reg" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okSaleRegBtn" ).button().on( "click", function() {
		saleRegDlg.dialog( "close" );
	});
	$( ".salesregist" ).click( function() {
		saleRegDlg.dialog( "open" );
	});
	
	stockDownDlg = $( "#stock-down" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okStockDownBtn" ).button().on( "click", function() {
		stockDownDlg.dialog( "close" );
	});
	$( ".stockservicedownload" ).click( function() {
		stockDownDlg.dialog( "open" );
	});
	
	stockReturnDlg = $( "#stock-return" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 740,
		modal: true,
	});
	$( "#okStockReturnBtn" ).button().on( "click", function() {
		stockReturnDlg.dialog( "close" );
	});
	$( ".stockservicereturn" ).click( function() {
		stockReturnDlg.dialog( "open" );
	});
	
	$( ".searchdatestart" ).datepicker({
      showOn: "both",
      buttonImage: base_url + "images/date.png",
      buttonImageOnly: true,
      buttonText: "Select date",
	  dateFormat: "yy-mm-dd"
    });
	
	$( ".searchdateend" ).datepicker({
      showOn: "both",
      buttonImage: base_url + "images/date.png",
      buttonImageOnly: true,
      buttonText: "Select date",
	  dateFormat: "yy-mm-dd"
    });
} );

$(document).ready(function(){
	$(".language").on('click', function( event ) {
		event.preventDefault();
		$.ajax({
			type: 'GET',
			dataType: "json",
			url: $(this).attr('href'),
			success: function(data, textStatus, jqXHR)
			{
				if(data.status){
					location.reload();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) 
			{
				alert('Location error occured!\nError status: ' + textStatus);
			}
		});
	})
});