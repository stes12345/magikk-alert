<!-- resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Magikk Alert System</title>

		<link rel="icon" type="image/ico" href="assets/images/favicon.ico"/>

		<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
		<link href="assets/css/custom.css" rel="stylesheet">

		<script src="assets/js/plugins.js"></script>
		<script src="assets/js/custom.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-white">
  			<div class="container-fluid">
    			<a class="navbar-brand" href="#"><img src="assets/images/ssl-logo.svg" alt="Stesalit" class="img-fluid" /> <span><strong class="color-blue">Magikk</strong> - Alert System</span></a>
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
					        	<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" src="assets/images/user-avatar.png" alt="User" width="35" height="35" /></a>
                    			<ul class="dropdown-menu dropdown-menu-right shadow animated-grow-in">
                    				<li><span class="dropdown-item">Welcome, <a href="#"><strong>John Doe</strong></a></span></li>
                    				<li><div class="dropdown-divider"></div></li>
                    				<li><div style="height:3px;"></div></li>
                    				<li><a class="dropdown-item" href="#"><i data-feather="user" class="icon text-gray-500"></i> Profile</a></li>
                    				<li><a class="dropdown-item" href="#"><i data-feather="key" class="icon text-gray-500"></i> Change Password</a></li>
                    				<li><div style="height:3px;"></div></li>
                    				<li><div class="dropdown-divider"></div></li>
                    				<li><a class="dropdown-item" href="#" id="logout-link"><i data-feather="log-out" class="icon text-gray-500"></i> <span class="color-red">Logout</span></a></li>
                    			</ul>
					        </li>
      					</ul>
      				</div>
    			</div>
  			</div>
		</nav>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

		<div class="container-fluid" style="height:calc(100% - 70px);">
			<div class="row h-100">
				<div class="col left-sidebar">
					<div class="card">
						<div class="card-body">
							<div class="card-title">All Devices</div>
						</div>
					</div>
				</div>
				<div class="col main-container">
					<div class="gmap radius" style="width:100%; height:100%;">
                        <!-- <iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6214843.045457204!2d68.1097!3d23.4051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x394be4e58ae146d7%3A0xbc40c4c033ba24e1!2sIndia!5e0!3m2!1sen!2sin!4v1646563878311!5m2!1sen!2sin" allowfullscreen ></iframe> -->
						<div id="map"></div>

						<!-- prettier-ignore -->
						<script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
							({key: "AIzaSyCsxJFEi1A1HKcVPUdeUKBgUnR1Bxx4FB8", v: "weekly"});</script>
                    </div>
				</div>
				<div class="col right-sidebar">
					<div class="card">
						<div class="card-body">
							<div class="card-title">Active Alerts</div>
						</div>
						<hr>
						<div class="alerts-loop">
							<div class="card-body">
								<div class="row">
									<div class="col-2">
										<div class="alert-icon-round"><i class="bi bi-exclamation-triangle-fill"></i></div>
									</div>
									<div class="col-10">
										<div class="text-large font-weight-bold mb-1">Emergency SOS Alarm</div>
										<div class="row align-items-center mb-1">
											<div class="col text-gray-500">Friday 22, 2024</div>
											<div class="col-auto text-gray-500">1:55pm</div>
										</div>
										<div class="text-gray-600 mb-2">John Doe has pressed emergency SOS alarm.</div>
										<div><button type="button" class="btn button-light-blue btn-shadow">Decline</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn button-blue btn-shadow">Accept</button></div>
									</div>
								</div>
							</div>
							<hr>
							<div class="card-body">
								<div class="row">
									<div class="col-2">
										<div class="alert-icon-round"><i class="bi bi-exclamation-triangle-fill"></i></div>
									</div>
									<div class="col-10">
										<div class="text-large font-weight-bold mb-1">Emergency SOS Alarm</div>
										<div class="row align-items-center mb-1">
											<div class="col text-gray-500">Friday 22, 2024</div>
											<div class="col-auto text-gray-500">1:55pm</div>
										</div>
										<div class="text-gray-600 mb-2">John Doe has pressed emergency SOS alarm.</div>
										<div><button type="button" class="btn button-light-blue btn-shadow">Decline</button>&nbsp;&nbsp;&nbsp;<button type="button" class="btn button-blue btn-shadow">Accept</button></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			feather.replace();

            document.getElementById('logout-link').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            });

			let map;

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				map = new Map(document.getElementById("map"), {
					center: { lat: 20.593, lng: 78.962 },
					zoom: 8,
				});
			}

			initMap();
		</script>

		<style>
		#map {
			height: 100%;
		}
		</style>
	</body>
</html>