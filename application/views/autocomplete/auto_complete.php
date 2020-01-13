<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Auto Complete Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="jquery.js"></script>
	<style>
		ul{
			background: #eee;
			cursor: pointer;
		}
		li{
			padding: 5px;
		}
	</style>
</head>
<body>
	<br /><br />
	<div class="container" style="width: 500px;">
		<h3 align="center">Autocomplete textBox using ajax,jquery,php and mysql</h3>
		<label for="">Enter Country Name</label>
		<input type="text" name="country" id="country" class="form-control" placeholder="Enter country name..." />
		<div id="countryList"></div>
	</div>
</body>
</html>
