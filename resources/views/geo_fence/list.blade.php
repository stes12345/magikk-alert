<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Magikk Alert System</title>

		<link rel="icon" type="image/ico" href="{{asset('assets/images/favicon.ico')}}"/>

		<link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet">
		<link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">

		<script src="{{asset('assets/js/plugins.js')}}"></script>
		<script src="{{asset('assets/js/custom.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg bg-white">
  			<div class="container-fluid">
    			<a class="navbar-brand" href="#"><img src="{{asset('assets/images/ssl-logo.svg')}}" alt="Stesalit" class="img-fluid" /> <span><strong class="color-blue">Magikk</strong> - Alert System</span></a>
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
					        <li class="nav-item nav-reports" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Reports"><a class="nav-link" href="#"><i data-feather="file" class="icon"></i></a></li>
					        <li class="nav-item nav-settings" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Settings"><a class="nav-link" href="#"><i data-feather="settings" class="icon"></i></a></li>
					        <li class="nav-item nav-user dropdown no-arrow">
					        	<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" src="{{asset('assets/images/user-avatar.png')}}" alt="User" width="35" height="35" /></a>
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
			<div class="card box-shadow">
				<div class="card-body">
					<div class="card-title color-blue">Search User</div>
					<hr class="mt-1">
					<div class="gap"></div>
					<form class="frm">
						<div class="row">
							<div class="col-12 col-sm-12 col-md-2">
								<label class="form-label">Area Name</label>
								<input type="text" class="form-control" id="">
							</div>
							<div class="col-12 col-sm-12 col-md-2">
								<label class="form-label">Status</label>
								<select class="form-control" id="">
									<option>Active</option>
									<option>Inactive</option>
								</select>
							</div>
						</div>
						<div class="space"></div>
						<div><button type="button" class="btn button-blue">Submit</button>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn button-light-blue">Reset</button></div>
					</form>
				</div>
			</div>

			<div class="gap"></div><div class="gap"></div>

			<div class="card box-shadow">
				<div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card-title color-blue">Geo Fence Listing</div>
                        </div>
                        <div class="col-auto">
                            <div class="nav-item nav-user dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></a>
                                <ul class="dropdown-menu dropdown-menu-right shadow animated-grow-in">
                                    <li><a class="dropdown-item" href="{{route('geo-fence.create')}}"><i class="bi bi-plus-lg"></i> Add New</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
					<hr class="mt-1">
					<div class="gap"></div>
					<table class="table table-striped">
						<thead>
						<tr>
						  <th>Area Name</th>
                          <th>Created By</th>
                          <th>Created At</th>
						  <th>Status</th>
                          <th></th>
						</tr>
						</thead>
						<tbody>
                            @foreach ($geo as $geo)
							<tr>
								<td>{{$geo->area_name}}</td>
                                <td>{{$geo->createdBy->name}}</td>
                                <td>{{ $geo->created_at }}</td>
								<td id="status_{{ $geo->id }}">{{ $geo->status==0 ? 'Inactive' : 'Active' }}</td>
                                <td>
                                    <div class="nav-item nav-user dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right shadow animated-grow-in">
                                            <li><a class="dropdown-item" href="geo-fence/{{$geo->id}}/edit"><i class="bi bi-pencil"></i> Edit</a></li>
                                            <li><div style="height:3px;"></div></li>
                                            <li><div class="dropdown-divider"></div></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="toggleStatus({{ $geo->id }},{{$geo->status}})"><i class="bi bi-person"></i> Change Status</a></li>
                                            <li><div style="height:3px;"></div></li>
                                            <li><div class="dropdown-divider"></div></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $geo->id }}').submit();"><i class="bi bi-trash"></i> <span class="color-red">Delete</span></a></li>
                                            <!-- Example using a link -->
                                            <form id="delete-form-{{ $geo->id }}" action="{{ route('geo-fence.destroy', $geo->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </ul>
                                    </div>
                                </td>
							</tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<script>
			feather.replace();

            function toggleStatus(itemId, status) {
                var csrfToken = '{{ csrf_token() }}';
				var finalStatus = '';

                // Make AJAX request to toggle status
                $.ajax({
                    url: '/geo-status-change/' + itemId,
                    type: 'POST',
                    contentType: 'application/json', // Specify content type as JSON
                    data: JSON.stringify({
                        status: status,
						id : itemId
                    }),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    success: function(response) {
                        // Update status in DOM
						var finalStatus = status == 1 ? 'Inactive' : 'Active';
                        $('#status_' + itemId).text(finalStatus);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error toggling status:', error);
                    }
                });
            }

		</script>
	</body>
</html>