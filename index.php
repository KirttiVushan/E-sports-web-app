<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="grid.css">
	<script type="text/javascript" src="jquery.min.js"></script>
	
</head>
<body>

      <div class="container">
		<div class="row">
        <div class="col-3">
	    <?php include("includes/header.php"); ?>
	</div>
	 
        <div class="col-6"">
	    <?php include("includes/registration.php"); ?>
	</div>
	<div class="col-6"">
	    <?php include("includes/follow.php"); ?>
	</div>

	 <div class="col-3"">
	    <?php include("includes/stream.php"); ?>
	</div>
       
       <div class="col-3">
        <?php include("includes/footer.php"); ?>
	</div>
    </div>  
    <script type="text/javascript" src="animate.js"></script>
    
</body>
</html>