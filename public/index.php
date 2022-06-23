<?php
	$pageTitle = "Shop page";

	require('../src/config.php');
	require('../src/app/common_functions.php');
	require('../src/app/CRUD_functions.php');

	$products = $crudFunctions->fetchAllProductsDESC();

	include('layout/header.php');
?>

<div id="homepage-con">

	<div id="front-info">
	<h2>Pralinerpralinerpraliner</h2>
		<p>
			Välkommen till Marias Söta i Vejbystrand. 
			Jag bakar med smakrikedom och blomsterpilleri, där ögat får sitt innan smaken tar vid.
		</p>
	</div>

	<div id="searchDiv">
		<form id="searchByTitleForm" action="../src/app/API.php" method="POST">
			<input type="text" name="searchByTitle" placeholder="Search by Title">
			<input type="hidden" name="searchingByTitle">
		</form>
		<form id="searchByFlavourForm" action="../src/app/API.php" method="POST">
			<input type="text" name="searchByFlavour" placeholder="Search by Flavour">
			<input type="hidden" name="searchingByFlavour">
		</form>
	</div>

	<div id="shop-con">
	</div>
</div>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- CUSTOM -->
<script src="../src/app/AJAX.js"></script>
<script src="../src/app/js_functions.js"></script>
<script>
	var JSDATA = <?=json_encode($products, JSON_HEX_TAG | JSON_HEX_AMP )?>;
	showProducts(JSDATA);
	showValue();
</script>
<?php include('layout/footer.php') ?>