<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Magikk Alert System</title>

		<link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}"/>

		<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

		<script src="{{ asset('assets/js/plugins.js') }}"></script>
		<script src="{{ asset('assets/js/custom.js') }}"></script>
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsxJFEi1A1HKcVPUdeUKBgUnR1Bxx4FB8&libraries=drawing&callback=initMap"></script>
		<style>
			#map {
				height: 400px;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-white">
  			<div class="container-fluid">
    			<a class="navbar-brand" href="#"><img src="{{ asset('assets/images/ssl-logo.svg') }}" alt="Stesalit" class="img-fluid" /> <span><strong class="color-blue">Magikk</strong> - Alert System</span></a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerNavbar" aria-controls="headerNavbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    			<div class="d-flex">
    				<div class="collapse navbar-collapse" id="headerNavbar">
        				<ul class="navbar-nav align-items-center">
					        <li class="nav-item nav-home" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Home"><a class="nav-link" href="{{route('dashboard')}}"><i data-feather="home" class="icon"></i></a></li>
					        <li class="nav-item nav-alerts" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Alerts">
					        	<a class="nav-link" href="#">
					        		<i data-feather="bell" class="icon"></i>
					        		<span class="pulse">10</span>
					        	</a>
					        </li>
					        <li class="nav-item nav-reports" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Reports"><a class="nav-link" href="{{route('geo-fence.index')}}"><i data-feather="file" class="icon"></i></a></li>
					        <li class="nav-item nav-settings" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Settings"><a class="nav-link" href="#"><i data-feather="settings" class="icon"></i></a></li>
					        <li class="nav-item nav-user dropdown no-arrow">
					        	<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" src="{{ asset('assets/images/user-avatar.png') }}" alt="User" width="35" height="35" /></a>
                    			<ul class="dropdown-menu dropdown-menu-right shadow animated-grow-in">
                    				<li><span class="dropdown-item">Welcome, <a href="#"><strong>John Doe</strong></a></span></li>
                    				<li><div class="dropdown-divider"></div></li>
                    				<li><div style="height:3px;"></div></li>
                    				<li><a class="dropdown-item" href="#"><i data-feather="user" class="icon text-gray-500"></i> Profile</a></li>
                    				<li><a class="dropdown-item" href="#"><i data-feather="key" class="icon text-gray-500"></i> Change Password</a></li>
                    				<li><div style="height:3px;"></div></li>
                    				<li><div class="dropdown-divider"></div></li>
                    				<li><a class="dropdown-item" href="#"><i data-feather="log-out" class="icon text-gray-500"></i> <span class="color-red">Logout</span></a></li>
                    			</ul>
					        </li>
      					</ul>
      				</div>
    			</div>
  			</div>
		</nav>

		<div class="container-fluid">
    
    <div class="card shadow">
        
        <div class="card-body">
            
            <div class="card-title">{{ isset($geo) ? 'Update' : 'Create' }} Geo Fence</div>
            
            <fieldset class="border pt-3 pr-4 pb-3 pl-4">
                <form id="frm_validate" role="form" method="POST" action="{{ isset($geo) ? route('geo-fence.update', $geo->id) : route('geo-fence.store') }}">
                    @csrf
                    @if(isset($geo))
                        @method('PUT')
                    @endif
                    <div class="p-l-5 p-r-5 p-t-5 p-b-5"></div>
                    <div class="row">
                        <div class="col-xs-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Area Name</label>
                                <input type="text" class="form-control" id="area_name" name="area_name" placeholder="Area Name" value="{{ isset($geo) ? $geo->area_name : ''}}" required>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-4 col-lg-4">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="" name="status">
                                <option value="">Select</option>
                                <option value="1" {{ isset($geo) && $geo->status==1 ? 'selected' : ''}}>Active</option>
                                <option value="0" {{ isset($geo) && $geo->status==0 ? 'selected' : ''}}>Inactive</option>
                            </select>
                        </div>
						<input type="hidden" class="form-control" id="area_geom" name="area_geom" value="{{ isset($geo) ? $geo->geom : ''}}">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12"><hr /></div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-sm btn-primary float-right" name="save" value="save">Save</button>
                                <a href="javascript:void(0);" class="btn btn-sm btn-danger">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>

	<div class="gap"></div><div class="gap"></div>

	<div class="card box-shadow">
		<div class="card-body">
			<div id="map"></div>
			<script>

				let map;
				// Create an empty multidimensional array
				let mapArray = [];
				let mapEditArray = [];

				function initMap() {
					map = new google.maps.Map(document.getElementById('map'), {
						center: {lat: 0, lng: 0},
						zoom: 3,
						disableDoubleClickZoom: true // Disable double-click zoom
					});

					<?php
					if(isset($geo)) { 
						foreach($geo->geoFenceTracks as $geoFenceTrack) { 
							?>
							mapEditArray.push({lat:{{$geoFenceTrack->latitude}}, lng:{{$geoFenceTrack->longitude}}});
							<?php
						}
						?>
						console.log(mapEditArray);
						
						// // Define the paths for the polygon
						// var polygonPaths = [
						// 	{ lat: 37.772, lng: -122.214 },
						// 	{ lat: 21.291, lng: -157.821 },
						// 	{ lat: -18.142, lng: 178.431 },
						// 	{ lat: -27.467, lng: 153.027 }
						// ];

						// Create a new polygon with the specified paths
						var polygon = new google.maps.Polygon({
							paths: mapEditArray,
							strokeColor: "#FF0000",
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: "#FF0000",
							fillOpacity: 0.35
						});

						// Add the polygon to the map
						polygon.setMap(map);
					<?php
					} else { ?>
						// Add a click event listener to the map
					map.addListener('click', function(event) {
						// Get the latitude and longitude of the clicked location
						let latitude = event.latLng.lat();
						let longitude = event.latLng.lng();

						// You can use these latitude and longitude values as needed
						
						// Push elements into the multidimensional array
						mapArray.push({lat:latitude, lng:longitude});

						// Get the hidden input element by its ID
						var area_geom = document.getElementById("area_geom");

						// Set the value of the hidden input
						//area_geom.value = JSON.stringify(mapArray);

					});

					var doubleClickHandler = map.addListener('dblclick', function(event) {
						// Prevent default zoom behavior
						// event.preventDefault();
						// Your double-click event handling code here
						console.log('multiArray1');
						console.log(mapArray);
						// Construct the polygon
						var polygon = new google.maps.Polygon({
							paths: mapArray,
							strokeColor: '#FF0000',
							strokeOpacity: 0.8,
							strokeWeight: 2,
							fillColor: '#FF0000',
							fillOpacity: 0.35
						});

						// Set the polygon on the map
						polygon.setMap(map);

						area_geom.value = JSON.stringify(mapArray);

					//	mapArray = [];

						// Remove the double-click event listener after the first double-click
						google.maps.event.removeListener(listener);
					});
					
					var listener = google.maps.event.addListener(map, 'dblclick', doubleClickHandler);
					<?php
					}
					?>
				}

			</script>
			<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsxJFEi1A1HKcVPUdeUKBgUnR1Bxx4FB8&callback=initMap"></script>
		</div>
	</div>
    
</div>

		<script>
			feather.replace();
		</script>
	</body>
</html>