<div id="loader" class="loader-showed">
	<img src="../uploads/loader.gif" alt="loading...">
	<span>Loading Data...</span>
</div>
<script>
	function start_loader( txt ){
		$('#loader span').html( txt );
		$('#loader').addClass("loader-blocked");
		setTimeout( function(){
			$('#loader').addClass("loader-showed");
		}, 100 );
		set_loader( 0 );
		return true;
	}
	
	function end_loader(){
		set_loader( 100 );
		setTimeout( function(){
			$('#loader').removeClass("loader-showed");
		}, 500 );
		
		setTimeout( function(){
		$('#loader').removeClass("loader-blocked");
		}, 1000 );
		return true;
	}
	
	function set_loader( percentage ){
		$('#loader .loader-bar').css("width", percentage + "%");
		return true;
	}
	start_loader('Loading Data...');
	set_loader(1);


var doc_w = $(window).width();
var doc_h = $(window).height();
var header_h = $('header').height();
</script>
<?php
$nw_langA = '';
switch($lang){
	case 'en':
		$nw_langA = 'ar';
		break;
	case 'ar':
		$nw_langA = 'en';
		break;
}
?>



<script>
var activeMenu = <?=$menuId; ?>;
function initMnu(){
	var totC = 0;
	$('.navItem').each( function(){
		
		var thsId = parseInt( $(this).attr('data-ids') );
		if( isNaN( thsId ) ){
			thsId = 1;
		}
		if( thsId != 0 ){
			totC++;
		}
		$(this).attr('id', 'naver-' + totC);
		$(this).attr('onclick', 'showMenuContent(' + thsId + ');');
		if( thsId == activeMenu ){
			$(this).addClass('activeMainMenu');
			var mnuContent = $('#menuContent-' + activeMenu).html();
			$('#subMenuContainer').html( mnuContent );
		}
		
	} );
}

function showMenuContent( nwMnu ){
	$('#subMenuContainer').html('');
	$('.activeMainMenu').removeClass('activeMainMenu');
	$('#naver-' + nwMnu ).addClass('activeMainMenu');
	var MC = $('#menuContent-' + nwMnu).html();
	$('#subMenuContainer').html( MC );
}

</script>