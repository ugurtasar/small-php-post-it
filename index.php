<?php
require('vendor/autoload.php');
$databaseDirectory = __DIR__ . "/db";
$postsStore = new \SleekDB\Store("posts", $databaseDirectory);
$axios = file_get_contents("php://input");
if($axios){
	if(empty($axios)){
		echo json_encode([
			'status' => 'failed'
		]);
		exit();
	}
	$insertData = $postsStore->insert([
		'post_id' => bin2hex(random_bytes(20)),
		'content' => $axios
	]);
	echo json_encode([
		'status' => 'success',
		'id' => $insertData['post_id'],
		'content' => $axios
	]);
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Post-it</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/css/bootstrap.min.css">
	<style>.container{max-width: 800px;}</style>
</head>
<body class="bg-light">
<div class="container my-3">
	<h1 class="h2 text-center">Post-it</h1>
	<form method="post" id="form" action="#" class="d-flex flex-column">
	  	<textarea class="form-control" name="content" id="content" rows="5" placeholder="write here" required></textarea>
		<div class="alert alert-success mt-2 mb-0 d-none" id="post-url">
			
		</div>
		<button type="submit" id="post-button" class="mt-2 w-100 btn btn-success bg-gradient py-3 fw-bold text-uppercase">Submit</button>
	</form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
$('#form').submit(function (evt) {
	evt.preventDefault();
	$('#post-button').prop('disabled', true);
	$('#post-button').text('Posting...');
	var content = $("#content").val();
	axios.post('index.php', content).then(function (response) {
	console.log(response.data);
	$('#post-url').removeClass("d-none");
	var postUrl = window.location.origin+'/single.php?id='+response.data.id;
	$('#post-url').html('<a href="'+postUrl+'" target="_blank">'+postUrl+'</a>');
	$('#post-button').prop('disabled', false);
	$('#post-button').text('Post-it');
	}).catch(function (error) {
	console.log(error);
	});
});
</script>
</body>
</html>