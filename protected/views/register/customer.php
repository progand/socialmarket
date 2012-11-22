<?php
/* @var $this RegisterController */

$this->breadcrumbs=array(
	'Register'=>array('/register'),
	'Customer',
);
?>
<script src="js/jquery.js"></script>
<script src="js/register_customer.js"></script>
<script
	src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU"
	type="text/javascript"></script>
<link rel="stylesheet" href="css/register_customer.css"/>

<article>
		<section id='loading'>
			<img alt="" src="images/loading.gif">
		</section>	
		<section id='allow_geolocation'>
			<h1>Please, allow geolocation in your browser (not necessarily)</h1>
		</section>		
		<section id="location">
			<button id="btn_location_correct">Correct!</button>
			<h1>Your location</h1>
			<div id="map"></div>
			<form action="#" id="location_form">
				<h2>Coordinates</h2>
				<span>Latitude:</span><input type="text" id="latitude"> <span>Longitude:</span><input
					type="text" id="longitude"><br>
				<h2>Address</h2>
				<span>Country:</span><input type="text" required id="country">
				<span>Region:</span><input type="text" id="region"><br>
				<span>City:</span><input type="text" required id="city"> <span>District:</span><input
					type="text" id="district"><br> <span>Street:</span><input
					type="text" required id="street"> <span>House:</span><input
					type="text" required id="house"><br> <span>Apartment:</span><input
					type="text" id="apartment"><br>
			</form>
		</section>
		<section id="account_info">
			<h1>Last step</h1>
			<form action="#">
				<p id="address"></p>
				<span>Login:</span><input type="text" required id="login"><br>
				<span>E-mail:</span><input type="email" required id="email"><br>
				<span>Full Name:</span><input type="text" required id="name"><br>
				<span>Password:</span><input type="password" required id="password"><br>
				<span>Re-type:</span><input type="password" required
					id="password_confirm"><br>

				<button id="btn_submit_register">Register now!</button>
			</form>
		</section>
	</article>