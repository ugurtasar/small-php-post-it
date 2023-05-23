<?php
require('vendor/autoload.php');
$databaseDirectory = __DIR__ . "/db";
$postsStore = new \SleekDB\Store("posts", $databaseDirectory);
$data = $postsStore->findOneBy(["post_id", "=", $_GET['id']]);
if(!$data){
	exit('post not found.');
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
	<h1>Post-it</h1>	
	<div class="mt-2">
		<?php echo nl2br($data['content']); ?>
	</div>
</div>
</body>
</html>