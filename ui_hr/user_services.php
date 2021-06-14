<?php
	require_once('../bootstrap/app_config.php');
	require_once('../bootstrap/chk_log_user.php');
	$page_title=$page_description=$page_keywords=$page_author= $SETTINGS['site_title'.$lang_db];
	// $page_title=$page_description=$page_keywords=$page_author= "Site Title";
	$page_id = 106;
	$pageID = 0;
	$subPageID = 0;
	
$SITE_LOGO_ICON =  $SETTINGS['site_logo_icon'];
$SITE_LOGO = $SETTINGS['site_logo'];
$site_loading = $SETTINGS['site_loading'];

?>
<html dir="<?=$lang_dir; ?>" lang="<?=$lang; ?>">
<html>
<head>
	<?php include('app/meta.php'); ?>
    <?php include('app/assets.php'); ?>
</head>
<body>
<div id="loader" class="loader-showed">
	<div class="loader-bar"></div>
	<span><img src="../uploads/loader.gif" alt="loading..."><br><?=$site_loading; ?></span>
</div>
<script>
	function start_loader(){
		$('#loader').addClass("loader-showed");
		set_loader( 0 );
		return true;
	}

	function end_loader(){
		set_loader( 100 );
		
		setTimeout( function(){
			$('#loader').removeClass("loader-showed");
			
			
		}, 1000 );
			setTimeout( function(){
				set_loader( 0 );
				
			}, 1500 );
		return true;
	}
	function set_loader( percentage ){
		$('#loader .loader-bar').css("width", percentage + "%");
		return true;
	}
	start_loader();
	set_loader(1);
	
</script>

</body>
</html>
<?php

	//recieve data
	//save data
	//redirect user to his page
	
?>