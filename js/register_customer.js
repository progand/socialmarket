var map = null;

$(document).ready(function() {
	formInit();
});

function formInit() {
	$("#latitude,#longitude").change(locationChanged);
	ymaps.ready(formLocation);
}

function locationChanged() {
	var latitude = $("#latitude").val();
	var longitude = $("#longitude").val();
	map.setCenter([ latitude, longitude ]);
}

function formLocation() {
	$("section").hide();
	$("#location_form").submit(function(){
		return false;
	});
	$("button#btn_location_correct").click(function() {
		if (checkLocationForm()) {
			formAccountInfo();
		}else{
			$("#fill_location_error").fadeIn();
		}
	});
	if (navigator.geolocation) {
		$("section#allow_geolocation").fadeIn(1000);
		navigator.geolocation.getCurrentPosition(gotPosition,
				errorGettingPosition);
	} else {
		formLocationShow(ymaps.geolocation.latitude,
				ymaps.geolocation.longitude);
	}
}

function checkLocationForm() {
	return $("input#country").val().length>0 &&
	$("input#city").val().length>0&&
	$("input#street").val().length>0&&
	$("input#house").val().length>0;	
}

function formAccountInfo() {
	$("section").hide();
	$("section#account_info").fadeIn();
	var address = getAddressAsString();
	$("section#account_info p#address").text(address);
	$("section#account_info form").submit(submitRegistration);
}

function checkAccountInfo() {
	return $("input#login").val().length>0 &&
	$("input#email").val().length>0&&
	$("input#name").val().length>6&&
	($("input#password").val()==$("input#password_confirm").val());	
}

function submitRegistration(){
	if(checkAccountInfo()){
		
	}else{
		$("#fill_account_info").fadeIn();
	}
	return false;
}

function getAddressAsString() {
	var address = "" + $("#country").val();
	if ($("#region").val().length > 0) {
		address += ", " + $("#region").val();
	}
	if ($("#city").val().length > 0) {
		address += ", " + $("#city").val();
	}
	if ($("#district").val().length > 0) {
		address += ", " + $("#district").val();
	}
	if ($("#street").val().length > 0) {
		address += ", " + $("#street").val();
	}
	if ($("#house").val().length > 0) {
		address += ", " + $("#house").val();
	}
	if ($("#apartment").val().length > 0) {
		address += ", " + $("#apartment").val();
	}
	return address;
}

function formLocationShow(latitude, longitude) {
	if (!$("#latitude").val() && !$("#longitude").val()) {
		$("section").hide();
		$("section#location").fadeIn();
	}

	initMap(latitude, longitude);
	$("#latitude").val(latitude);
	$("#longitude").val(longitude);
}

function gotPosition(pos) {
	var latitude = pos.coords.latitude;
	var longitude = pos.coords.longitude;

	formLocationShow(latitude, longitude);
}

function errorGettingPosition(err) {
	formLocationShow(ymaps.geolocation.latitude, ymaps.geolocation.longitude);
}

function initMap(latitude, longitude) {
	map = new ymaps.Map('map', {
		center : [ latitude, longitude ],
		zoom : 12
	});
	map.controls.add(new ymaps.control.ZoomControl());
	map.controls.add('typeSelector');
	map.controls.add('searchControl');
	placemark = new ymaps.Placemark([ latitude, longitude ]);
	map.geoObjects.add(placemark);
	/*
	 * map.geoObjects.add(new ymaps.Placemark([ ymaps.geolocation.latitude,
	 * ymaps.geolocation.longitude ], { balloonContentHeader :
	 * ymaps.geolocation.country, balloonContent : ymaps.geolocation.city,
	 * balloonContentFooter : ymaps.geolocation.region }));
	 */

	map.geoObjects.events.add('click', function(e) {
		var coords = e.get('target').geometry.getCoordinates();
		var latitude = coords[0];
		var longitude = coords[1];
		$("#latitude").val(latitude);
		$("#longitude").val(longitude);
		updateAddress(latitude, longitude);
	});

	updateAddress(latitude, longitude);
}

function updateAddress(latitude, longitude) {
	$("#latitude").val(latitude);
	$("#longitude").val(longitude);
	var myReverseGeocoder = ymaps.geocode([ latitude, longitude ]);
	myReverseGeocoder.then(function(res) {
		var street = res.geoObjects.get(-5);
		if (street) {
			$("#street").val(street.properties.get('name'));
		} else {
			$("#street").val("");
		}

		var district = res.geoObjects.get(-4);
		if (district) {
			$("#district").val(district.properties.get('name'));
		} else {
			$("#district").val("");
		}

		var city = res.geoObjects.get(-3);
		if (city) {
			$("#city").val(city.properties.get('name'));
		} else {
			$("#city").val("");
		}

		var region = res.geoObjects.get(-2);
		if (region) {
			$("#region").val(region.properties.get('name'));
		} else {
			$("#region").val("");
		}

		var country = res.geoObjects.get(-1);
		if (country) {
			$("#country").val(country.properties.get('name'));
		} else {
			$("#country").val("");
		}
	});
}