
<br>
<br>
<br>
	<div class="zero"></div>
</article>

<div onclick="hide_mnu();" id="ghost"></div>
<span class="mob_only"></span>
<span class="tablet_only"></span>

<script type="text/javascript" src="<?=assets_root; ?>js/table_loader.js" defer></script>

<!-- datepicker css -->
<script type="text/javascript" src="<?=assets_root; ?>js/jquery_datepicker.js"></script>
<link type="text/css" rel="stylesheet" href="<?=assets_root; ?>js/jquery_datepicker.css" >

<!-- timePicker css -->
<link rel="stylesheet" href="<?=assets_root; ?>js/jquery.timepicker.min.css">
<script src="<?=assets_root; ?>js/jquery.timepicker.min.js"></script>

<script>





function reverseString(str) {
    return str.split("").reverse().join("");
}

function insertDecimal(num) {
var bb = '';
var tt = num.toFixed(2);
var aa = reverseString(tt);
var cc = 0;
for (var i = 0; i < aa.length; i++) {
	
  if( cc == 6 ){
	bb += ',';
	bb += aa.charAt(i);
  } else if( cc == 9 ){
	bb += ',';
	bb += aa.charAt(i);
  } else {
	bb += aa.charAt(i);
  }
  
  cc++;
}
 return reverseString(bb);
}


function set_tabber(tID){
	$('.tabs .tabsBodyActive').removeClass('tabsBodyActive');
	$('.tabs .activeHeaderTab').removeClass('activeHeaderTab');
	
	$('.tabs .tabsIdSel-' + tID).addClass('activeHeaderTab');
	$('.tabs .tabsId-' + tID).addClass('tabsBodyActive');
}

var tabIDs = 100;
function init_tabber(){
	
}


function fetch_item_status( itemID, itemType ){
	start_loader("Loading Status Changes...");
			$('#fetched_status_change').html();
			$.ajax({
				url      :"<?=api_root; ?>helpers/get_status_change.php",
				data     :{ 'item_id': itemID, 'item_type': itemType },
				dataType :"html",
				type     :'POST',
				success  :function(data){
						end_loader();
						var tabler = '<table class="tabler">' + 
									'	<thead>' + 
									'		<tr>' + 
									'			<th style="width:20%;"><?=lang("Date", "AAR"); ?></th>' + 
									'			<th><?=lang("By", "AAR"); ?></th>' + 
									'			<th><?=lang("Action","AAR"); ?></th>' + 
									'		</tr>' + 
									'	</thead>' + 
									'	<tbody>' + data + '</tbody>' + 
									'</table>';
						
						$('#fetched_status_change' ).html(tabler);
					},
				error    :function(){
					alert('Data Error No: 5467653');
					},
				});
	
}


function show_ghost(){
	$('#ghost').addClass( 'showed-ghost' );
}
function hide_ghost(){
	$('#ghost').removeClass( 'showed-ghost' );
}

var act_modal = "";

function show_modal( idd, titler ){
	$('#' + idd).addClass( 'modal-showed' );
	$('#' + idd + ' .modal-header h1').text( titler );
	act_modal = idd;
	do_date_picker();
}
function hide_modal(){
	$('#' + act_modal).removeClass( 'modal-showed' );
}

var act_detail = "";

function show_details( idd, titler ){
	$('#' + idd).addClass( 'details-showed' );
	$('#' + idd + ' .viewerHeader h1').text( titler );
	
	
	
	act_detail = idd;
	do_date_picker();
}
function hide_details( idd ){
	$('#' + idd).removeClass( 'details-showed' );
	act_detail = "";
	
	if( idd == 'NewItemDetails' ){
		loadReqItems();
	} else if( idd == 'NewProcessDetails' ){
		loadProcesses();
	}  else if( idd == 'NewActivityDetails' ){
		loadActivities();
	}   else if( idd == 'NewTaskDetails' ){
		loadTasks();
	} else if( idd == 'addPriceListDetails' ){
		loadRFQs();
	}
	
	
}

function init_nwFormGroup(){
	$('.nwFormGroup').each( function(){
		$(this).append('<div class="zero"></div>');
	} );
	$('.row').each( function(){
		$(this).append('<div class="zero"></div>');
	} );
}


function fix_aside(){
	// $(window).scrollTop(0);
	doc_h = $( window ).height();
	doc_w = $( window ).width();
	
	var cont_w = doc_w * 4;
	var bannered = doc_h / 1.5;
	header_h = $('header').height();
	var subNav_h = 0;
	// alert( header_h );
	var aside_h = (doc_h - ( header_h + subNav_h)  );
	// var in_ul = header_h * 1.6;
	var vv = aside_h * 0.20;
	var dd = aside_h * 0.10;
	var top_space = (header_h * 0.2) + header_h;
	
	vv = aside_h - vv;
	
	dd = aside_h - dd;
	$('.subNavContainer').css('height', aside_h);
	
	$('article').css('margin-top', top_space);
	$('.subNavContainer').css('top', header_h);
}

// fix_aside();
setTimeout(
	function(){
		fix_aside();
	}
,100);

// $(document).on('scroll', function(){ do_slide_effects(); });


function do_date_picker(){
	$(".has_date").datepicker({
	  dateFormat: "yy-mm-dd",
	  changeYear: true, 
	  changeMonth: true, 
	  yearRange: "<?=date('Y'); ?>:<?=date('Y') + 5; ?>"
	});
}



function do_time_picker(){

	$('.has_time').timepicker({
		timeFormat: 'HH:mm', 
		dynamic: false,
		dropdown: false,
		scrollbar: false
	});


}


do_date_picker();
do_time_picker();













// $(window).scrollTop(0);
set_loader(100);
end_loader();


init_nwFormGroup();
</script>