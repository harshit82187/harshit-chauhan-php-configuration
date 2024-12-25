<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
	</head>
	<body>
		<h1>Student Details </h1>
		<a href="demo_form" class="btn btn-primary">Registration Foam</a>
		<br><br>
		<div class="card">
			<div class="card-body">
				<table class="table table-striped" id="dataTable">
					<thead>
						<tr>
							<th>ID</th>
							<th>NAME</th>
							<th>Date</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($student as $data)
						<tr>
							<td>{{$loop->iteration}}</td>
							<td>
								{{ Illuminate\Support\Str::limit($data->gs_answers, 15) }} <i class="fa fa-info-circle" data-toggle="tooltip" title="{{ $data->gs_answers }}"></i>
							</td>
							<td>
								{{ date('d-m-Y H-i-s A', strtotime($data->created_at)) }}
							</td>
							<td>
								@if($data->image)
								<a href="{{ asset('blog_images/'.$data->b_image) }}" download="{{ $data->b_image }}">
								<img src="{{ asset('bookings/' .$data->image) }}" alt="image" style="width:74px; height:85px; border-radius:50%;"> </a>
								@else
								<img src="{{ asset('banners') }}">
								@endif
							</td>
							<td class="d-flex">
								<a href="#" data-toggle="modal" data-target="#request_view{{ $data->id }}" class="btn btn-info btn-sm  mr-2" >View</a>
								<a href="#" data-toggle="modal" data-target="#two_wheeler_edit{{ $data->id }}" class="btn btn-success">Edit</a>  
								<a href="" class="btn btn-sm btn-warning mr-2">Show</a>
								<a href="" class="btn btn-icon btn-primary mr-2">Show</a>
								<a href="{{ route('click_delete',$data->id) }}" onclick="return confirm('Are you want delete?')" class="btn btn-sm btn-danger">Delete </a>
							</td>
						</tr>						
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!-- jQuery, Bootstrap JS and DataTables JS -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
		<script>
			$(document).ready(function (){
			    $('#dataTable').DataTable();
			});
		</script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<!-- Add Tooltip Script -->
		<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();
			});
		</script>
	</body>
</html>








********************************** Add modal Code ***************************************************

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="formModalLabel">Form Modal</h5>
				<button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="studentForm" method="POST" >
					@csrf
					<div class="row">
						<div class="col-md-12 mb-3">
							<label for="name">Profile Photo</label>
							<input type="file" class="form-control" name="profile_photo" accept=".jpg,.png,.jpeg" >
						</div>

						<div class="col-md-12 mb-3">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" placeholder="Enter your name">
						</div>

						<div class="col-md-12 mb-3">
							<label for="mobile">Mobile</label>
							<input type="number" class="form-control" name="mobile_no" placeholder="Enter your mobile number">
						</div>

						<div class="col-md-12 mb-3">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" placeholder="Enter your email">
						</div>
						<div class="col-md-12 mb-3">
							<label for="email">Password</label>
							<input type="password" class="form-control" name="password" placeholder="Enter your password">
						</div>

						<div class="col-md-12 mb-3">
							<label>Gender</label>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender"  value="Male" checked>
								<label class="form-check-label" for="genderMale">Male</label>
							</div>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender"  value="Female">
								<label class="form-check-label" for="genderFemale">Female</label>
							</div>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender"  value="Other">
								<label class="form-check-label" for="genderOther">Other</label>
							</div>
						</div>

						<div class="col-md-12 mb-3">
							<label>Hobby</label>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="hobby[]"   value="Dancing">
								<label class="form-check-label" for="docDancing">Dancing</label>
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" name="hobby[]"  value="Singing">
								<label class="form-check-label" for="docSinging">Singing</label>
							</div>
						</div>
					</div>
				</form>
																								
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" id="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

********************************** Edit modal Code ***************************************************
<div class="modal" id="edit_student{{ $user->id }}">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="margin-left:172px; width:697px; margin-top:75px;">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Edit Details</h4>
				<button type="button" class="close" data-dismiss="modal" id="close{{$user->id}}" style="border:0px; background-color:transparent;">&times;</button>
			</div>
			<!-- Modal Body -->
			@php
			$hobbies = json_decode($user->hobby, true);
			@endphp
			<div class="modal-body">
				<form id="update_user_{{ $user->id }}" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="user_id" value="{{ $user->id }}">
					<div class="row">
						@if($user->profile_photo)
						<div class="col-md-12 mb-3">
							<img src="{{ asset('users/' . $user->profile_photo) }}" alt="image" style="width:74px; height:85px; border-radius:50%;">
						</div>
						@endif
						<div class="col-md-12 mb-3">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" value="{{ $user->name }}">
						</div>
						<div class="col-md-12 mb-3">
							<label for="mobile">Mobile</label>
							<input type="number" class="form-control" name="mobile_no" value="{{ $user->mobile_no }}">
						</div>
						<div class="col-md-12 mb-3">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" value="{{ $user->email }}">
						</div>
						<div class="col-md-12 mb-3">
							<label for="profile_photo">Profile Photo</label>
							<input type="file" class="form-control" name="profile_photo">
						</div>

						<div class="col-md-12 mb-3">
							<label>Gender</label>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender" id="genderMale{{ $user->id }}" value="Male" {{ $user->gender == 'Male' ? 'checked' : '' }}>
								<label class="form-check-label" for="genderMale{{ $user->id }}">Male</label>
							</div>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender" id="genderFemale{{ $user->id }}" value="Female" {{ $user->gender == 'Female' ? 'checked' : '' }}>
								<label class="form-check-label" for="genderFemale{{ $user->id }}">Female</label>
							</div>
							<div class="form-check">
								<input type="radio" class="form-check-input" name="gender" id="genderOther{{ $user->id }}" value="Other" {{ $user->gender == 'Other' ? 'checked' : '' }}>
								<label class="form-check-label" for="genderOther{{ $user->id }}">Other</label>
							</div>
						</div>

						<div class="col-md-12 mb-3">
							<label>Hobby</label>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="hobbyDancing{{ $user->id }}" name="hobby[]" value="Dancing" {{ in_array('Dancing', $hobbies ?? []) ? 'checked' : '' }}>
								<label class="form-check-label" for="hobbyDancing{{ $user->id }}">Dancing</label>
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="hobbySinging{{ $user->id }}" name="hobby[]" value="Singing" {{ in_array('Singing', $hobbies ?? []) ? 'checked' : '' }}>
								<label class="form-check-label" for="hobbySinging{{ $user->id }}">Singing</label>
							</div>
							<!-- Add more hobbies as needed -->
						</div>

						<div class="col-md-12 mb-3">
							<button type="submit" class="form-control btn btn-success" id="submit_user_{{ $user->id }}">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>



////////////////////// Another Example Of Datatable /////////////////////////////////////////////////



@extends('admin.layouts.master')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-md-12">
				@if(session('success'))
				<div class="alert alert-success alert-dismissible">
					<a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a>
					{{ session('success') }} 
				</div>
				@endif
				@if(session('error'))
				<div class="alert alert-danger alert-dismissible">
					<a href="#" class="close" data-bs-dismiss="alert" aria-label="close">&times;</a>
					{{ session('error') }} 
				</div>
				@endif
			</div>
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0">Social Media Links</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xxl-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title mb-0">Listing Social Media Links</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>S. No.</th>
										<th>Facebook</th>
										<th>Instagram</th>
										<th>Twitter</th>
										<th>Youtube</th>
										<th>Linkedin</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $cnt = 1; if($socials){ foreach($socials as $social){ ?>
									<tr>
										<td>{{ $cnt++ }}</td>
										<td>{{ $social->facebook }}</td>
										<td>{{ $social->instagram }}</td>
										<td>{{ $social->twitter }}</td>
										<td>{{ $social->youtube }}</td>
										<td>{{ $social->linkedin }}</td>
										<td>
										</td>
									</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- End Page-content -->
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
///////////////// If Tool Tip Not Working /////////////////////////////////
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"





















///////////////// Show Real Time And Date With Day /////////////////////////////////////
<div class="head-date">
	<?=date("l, F d, Y", strtotime(date('Y-m-d')));?>
</div>
















///////////////// Contact Us Page Delete All Option Functionality /////////////////////////////////////
<div class="card-header">
	<h3 class="card-heading" >Contact Listing </h3>
	<button class="btn btn-dark btn-sm" id="delete-selected">Delete Selected</button>
</div>
<table class="table table lms_table_active" id="dataTable">
	<thead>
		<tr>
			<th> <input type="checkbox" id="select-all"> </th>
			<th scope="col">S.no</th>
			<th scope="col">Name</th>
			<th scope="col">Mobile No</th>
			<th scope="col">Email</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($listing as $data)
		<tr>
			<td> <input type="checkbox" class="row-checkbox" data-id="{{ $data->id }}"> </td>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $data->name }} </td>
			<td>{{ $data->phone }}</td>
			<td>{{ $data->email }}</td>
			<td>
				<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
					data-bs-target="#exampleModal{{ $data->id }}">View</button>
				<button class="btn btn-danger btn-sm" onclick="changeStatus({{ $data->id }})">Delete</button>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>


<script>
	$(document).ready(function(){
	    $('#select-all').change(function(){
	        $('.row-checkbox').prop('checked', $(this).prop('checked'));
	    });

	    $('.row-checkbox').change(function(){
	        if(!$(this).prop('checked')){
	            $('#select-all').prop('checked', false);
	        }
	    });

	    $('#delete-selected').click(function(){
	        var selectedIds = [];
	        $('.row-checkbox:checked').each(function(){
	            selectedIds.push($(this).data('id'));
	        });
            if (selectedIds.length === 0) {
                iziToast.warning({
                    title: 'Warning :',
                    message: 'Select Atleast One',
                    position: 'topRight',
                });
                return;
            }
            if (!confirm('Are you sure you want to delete the selected rows?')) return;

	        var csrfToken = $('meta[name="csrf-token"]').attr('content');
	        $.ajax({
	            type: 'POST',
	            url: '{{ route('admin.deleteSelectedRows') }}',
	            data: {
	                ids: selectedIds,
	                _token: csrfToken
	            },
	            success: function(response){
                    console.log("AJAX Success:", response);
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight',
                    });
                    setTimeout(function() {
                        location.reload(true);
                    }, 1000);
	            },
	            error: function(xhr, status, error){
	                console.error(error);
                    iziToast.error({
                        title: 'Error',
                        message: 'Something went wrong!',
                        position: 'topRight',
                    });
	            }
	        });
	    });
	});
</script>
Route::post('delet-selected-rows', 'deleteSelectedRows')->name('deleteSelectedRows');

 public function deleteSelectedRows(Request $request){
	// dd($request->all());
	$ids = $request->input('ids');
	if (empty($ids) || !is_array($ids)) {
	    return response()->json(['message' => 'No rows selected.'], 400);   
	}
	// dd($ids);
	ContactForm::whereIn('id', $ids)->delete();
	return response()->json(['message' => 'Selected rows deleted successfully']);
}



////////////////////////////////////////////////////////////// Summernote /////////////////////////////////////////////////////////////////////


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<textarea class="form-control summernote" rows="5" cols="5" name="sidebar_description" >{{ $websitesetting->sidebar_description ?? ''}}</textarea>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script><script>
	$(document).ready(function() {
	    
	    $('.summernote').summernote({
	    placeholder: 'Hello stand alone ui',
	    tabsize: 2,
	    height: 120,
	    toolbar: [
	      ['style', ['style']],
	      ['font', ['bold', 'underline', 'clear']],
	      ['color', ['color']],
	      ['para', ['ul', 'ol', 'paragraph']],
	      ['table', ['table']],
	      ['insert', ['link', 'picture', 'video']],
	      ['view', ['fullscreen', 'codeview', 'help']]
	    ]
	   });
	
	});
</script>
