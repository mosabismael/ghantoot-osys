<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>

<!-- Jquery files -->
<script type="text/javascript" src="../assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-migrate-1.2.1.min.js"></script>


<style>
#a123 {
	width: 50%;
	margin: 0 auto;
	padding: 2% 1%;
	border-radius: 5px;
	background: red;
	text-align: center;
	color: #FFF;
}
</style>

</head>
<body>

<div id="a123">Hello World !!</div>
<input id="a1" type="file">

<script>
$('#a1').on('change', function(){
	alert('file recieved');
});
</script>


</body>
</html>