<br>
<br>
<br>
	<div class="zero"></div>
</article>

<div onclick="hide_mnu();" id="ghost"></div>
<span class="mob_only"></span>
<span class="tablet_only"></span>

<!-- datepicker css -->
<script type="text/javascript" src="<?=assets_root; ?>js/jquery_datepicker.js"></script>
<link type="text/css" rel="stylesheet" href="<?=assets_root; ?>js/jquery_datepicker.css" >

<script>

function set_tabber(tID){
	$('.tabs .tabsBodyActive').removeClass('tabsBodyActive');
	$('.tabs .activeHeaderTab').removeClass('activeHeaderTab');
	
	$('.tabs .tabsIdSel-' + tID).addClass('activeHeaderTab');
	$('.tabs .tabsId-' + tID).addClass('tabsBodyActive');
}

var tabIDs = 100;
function init_tabber(){
	
}

//MENU FUNCTIONS START ------------------------------------------------------------------------------///////////
var currentMenu = $('#changable_mnu').html();
function makeMeFav( iconID ){
	var iconName = "#icon-" + iconID;
	var currentState = parseInt( $(iconName).attr('isfav') );
	if( currentState == 1 ){
		//its fav, remove from favs
		//remove old class
		$(iconName + ' .box-faver i').removeClass("fas");
		$(iconName + ' .box-faver i').addClass("far");
		$(iconName).attr('isfav', '0');
		$(iconName + ' .faver_valuer').val('0');
		$(iconName).removeClass('favbox');
	} else {
		//its NOT fav, add to favs
		//remove old class
		$(iconName + ' .box-faver i').removeClass("far");
		$(iconName + ' .box-faver i').addClass("fas");
		$(iconName).attr('isfav', '1');
		$(iconName + ' .faver_valuer').val('1');
		$(iconName).addClass('favbox');
	}
}




//MENU FUNCTIONS END --------------------------------------------------------------------------------///////////


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
		loadProcesses();
	}   else if( idd == 'NewTaskDetails' ){
		loadProcesses();
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
	var top_space = header_h * 1.5;
	
	vv = aside_h - vv;
	
	dd = aside_h - dd;
	
	$('article').css('height', aside_h);
	$('.subNavContainer').css('height', aside_h);
	
	$('article').css('top', header_h);
	$('.subNavContainer').css('top', header_h);
	// $('#slider .slide').css('height', dd);
	// $('#slider').css('margin-top', header_h);
	
	// $('#slider .slider-spacer').css('top', top_space);
	
	// $('.header-content').css('min-height', vv);
	
	
}

function fix_inliner(){
	// $(window).scrollTop(0);
	var disp = $('.mob_only').css('display');
	var disp2 = $('.tablet_only').css('display');
	// header_h = $('header').height();
	// $('.inner-ul').css('margin-top', header_h);
	if( disp == 'none' && disp2 == 'none' ){
		// $('.inner-ul').css('margin-top', header_h);
	}
}


// fix_aside();
setTimeout(
	function(){
		fix_aside();
	}
,100);
setTimeout(
	function(){
		

		fix_inliner();
		
	}
,1000);

setTimeout(
	function(){
		
	}
,800);

// $(document).on('scroll', function(){ do_slide_effects(); });

$( window ).resize(function() {
	// location.reload();
	fix_aside();
		fix_inliner();
});


function do_date_picker(){
	$(".has_date").datepicker({
	  dateFormat: "yy-mm-dd",
	  changeYear: true, 
	  changeMonth: true, 
	  yearRange: "<?=date('Y'); ?>:<?=date('Y') + 5; ?>"
	});
}



do_date_picker();












$(document).ready( function () {
    $('.tabler').DataTable();
} );












// $(window).scrollTop(0);
set_loader(100);
end_loader();


init_nwFormGroup();
</script>