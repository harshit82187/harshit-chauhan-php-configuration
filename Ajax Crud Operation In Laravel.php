
************************************** project Create Command ***************************************

composer create-project laravel/laravel:^10.0 ecommerece

**************************************** Web File Code  *************************************************

Route::controller(AjaxCrudController::class)->group(function () {
    Route::get('/ajax-crud', 'ajaxCrud')->name('ajax-crud');
    Route::post('/ajax-crud-store', 'ajaxCrudStore')->name('ajax-crud-store');
    Route::post('/ajax-crud-update', 'ajaxCrudUpdate')->name('ajax-crud-update');
    Route::get('/ajax-crud-delete/{id}', 'ajaxCrudDelete')->name('ajax-crud-delete');
});


Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('auth/google/callback', 'handleGoogleCallback');

});


***************************************** Index File Code **********************************************************************

@extends('layout.app')
@push('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
@endpush
@section('content')

<div class="container">
    <div class="card mt-5">
        <div class="card-header">
            <div style="display:flex; justify-content:space-between; align-item:center; ">
                <h3>User Listing</h3>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-student-modal" class="btn btn-success">Add Student</a>
            </div>
        </div>
        <div class="card-body shadow p-3 mb-5 bg-white rounded">
            <table class="table mt-5" id="user-table">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                         <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile No</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>
                                @if($user->image != null)
                                <a href="{{ asset($user->image) }}" target="_blank"><img src="{{ asset($user->image) }}" style="width: 50px; height: 50px; object-fit: cover;"  class="rounded-circle" >
                                </a>
                                @endif
                            </td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>{{ $user->mobile_no ?? 'N/A' }}</td>
                            <td>{{ $user->email ?? 'N/A' }}</td>
                            <td style="gap:5px;">
                                <a href="javascript:void(0)" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-mobile_no="{{ $user->mobile_no }}" data-image="{{ $user->image }}" class="btn btn-primary edit-user-info">Edit</a>
                                <a href="javascript:void(0)"  class="btn btn-danger" onclick="userDelete({{ $user->id }})">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-exclamation-circle"></i> No details found
                                </td>
                            </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>

{{-- Add Student Modal --}}
<div class="modal fade" id="add-student-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student Form</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form id="add-student-form" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label>Student Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept=".jpeg,.jpg,.png,.webp"   required autocomplete="one-time-code">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Student Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control alphabet"  required autocomplete="one-time-code">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Student Mobile No <span class="text-danger">*</span></label>
                        <input type="text" name="mobile_no" class="form-control number" required autocomplete="one-time-code">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Student Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required autocomplete="one-time-code">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Student Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" required autocomplete="one-time-code">
                    </div>

                </div>
            </div>
            <div class="modal-footer mt-3">
                <a href="{{ route('google.login') }}" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" title="Registration With Google"><img src="{{ asset('front/img/google.png') }}" style="width: 50px; height: 50px; object-fit: cover;"  class="rounded-circle" ></a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="add-form-submit">Save changes</button>
            </div>

       </form>
    </div>
  </div>
</div>

{{-- Edit Student Modal --}}
<div class="modal fade" id="edit-student-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="exampleModalLabel">Edit Student Form</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="student-update-form" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id">
				<div class="modal-body">
					<div class="row">
						<span id="existing-image"></span>
						<div class="col-12 mt-4">
							<label>Student Inage (If You Want To Change)</label>
							<input type="file" name="image" class="form-control" accept=".jpeg,.jpg,.png,.webp"   autocomplete="one-time-code">
						</div>
						<div class="col-12 mt-3">
							<label>Student Name <span class="text-danger">*</span></label>
							<input type="text" name="name" class="form-control alphabet"  required autocomplete="one-time-code">
						</div>
						<div class="col-12 mt-3">
							<label>Student Mobile No <span class="text-danger">*</span></label>
							<input type="text" name="mobile_no" class="form-control number" required autocomplete="one-time-code">
						</div>
						<div class="col-12 mt-3">
							<label>Student Email <span class="text-danger">*</span></label>
							<input type="email" name="email" class="form-control" required autocomplete="one-time-code">
						</div>
						<div class="col-12 mt-3">
							<label>Student Password (If You Want To Change) </label>
							<input type="password" name="password" class="form-control" autocomplete="one-time-code">
						</div>
					</div>
				</div>
				<div class="modal-footer mt-3">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="edit-form-submit">Update changes</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection
@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
	$(document).ready(function(){
	    $(".alphabet").on("input", function () {
	        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
	    });
	
	    $("input[type='number'], .number").on("input", function () {
	        this.value = this.value.replace(/[^0-9]/g, '');
	        if (this.value.length > 10) {
	            this.value = this.value.slice(0, 10);
	        }
	    });
	
	    // add-student-form-ajax
	    $('#add-student-form').submit(function(e){
	        // alert(121);
	        e.preventDefault();
	        let form = this;
	        let data = new FormData(form);
	        console.log(data);
	        let btn = $('#add-form-submit');
	        btn.html('⏳ Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	        $.ajax({
	            url : "{{ url('ajax-crud-store') }}",
	            type : "POST",
	            data : data,
	            dataType : "JSON",
	            processData : false,
	            contentType : false,
	            success: function(response) {
	                btn.html('Save changes').prop('disabled', false).css('cursor', 'pointer');
	                if (response.errors) {
	                    var errorMsg = '';
	                    $.each(response.errors, function(field, errors) {
	                        $.each(errors, function(index, error) {
	                            errorMsg += error + '<br>';
	                        });
	                    });
	                    iziToast.error({
	                        message: errorMsg,
	                        position: 'topRight'
	                    });
	                } else {
	                    $('#add-student-form')[0].reset();
	                    console.log(response);
	                    $('#add-student-modal').modal('hide');
	                    $('#user-table tbody').load(location.href + " #user-table tbody > *");
	                    iziToast.info({
	                        message: response.message,
	                        position: 'topRight'
	                    });
	                }
	            },
	            error: function(xhr, status, error) {
	                btn.html('Save changes').prop('disabled', false).css('cursor', 'pointer');
	                let errorMessage = 'An error occurred';
	                if (xhr.responseJSON && xhr.responseJSON.errors) {
	                    var errorMsg = '';
	                    $.each(xhr.responseJSON.errors, function(field, errors) {
	                        $.each(errors, function(index, error) {
	                            errorMsg += error + '<br>';
	                        });
	                    });
	                    iziToast.error({
	                        message: errorMsg,
	                        position: 'topRight'
	                    });
	                } else if (xhr.responseJSON && xhr.responseJSON.message) {
	                    errorMessage = xhr.responseJSON.message;
	                    iziToast.error({
	                        message: errorMessage,
	                        position: 'topRight'
	                    });
	                } else {
	                    errorMessage += ': ' + error;
	                    iziToast.error({
	                        message: errorMessage,
	                        position: 'topRight'
	                    });
	                }
	            }
	        });
	    });
	
	
        // edit-modal-open-script
	    $(document).on('click', '.edit-user-info', function() {
	        // alert(12121);
	        const id = $(this).data('id');
	        const name = $(this).data('name');
	        const email = $(this).data('email');
	        const mobile_no = $(this).data('mobile_no');
	        const image = $(this).data('image');
	        $('#existing-image').html('');
	
	        $('#student-update-form').find('input[name="id"]').val(id);
	        $('#student-update-form').find('input[name="name"]').val(name);
	        $('#student-update-form').find('input[name="email"]').val(email);
	        $('#student-update-form').find('input[name="mobile_no"]').val(mobile_no);
	         $('#student-update-form').find('input[name="image"]').val('');
	
	       if (image && image !== '') {
	            const newRow = `
	                <div class="mt-3 text-center">
	                    <span class="d-block mb-2 fw-bold">Existing Image</span>
	                    <img src="${image}" style="width: 90px; height: 90px; object-fit: cover;"  class="rounded-circle border border-2" >
	                </div>
	            `;
	            $('#existing-image').html(newRow);
	        }	
	        $('#edit-student-modal').modal('show');	
	    });
	
        // student-update-form-ajax
	    $('#student-update-form').submit(function(e){
	        // alert(121);
	        e.preventDefault();
	        let form = this;
	        let data = new FormData(form);
	        let btn = $('#edit-form-submit');
	        btn.html('⏳ Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	        console.log(data);
	        $.ajax({
	            url : "{{ url('ajax-crud-update') }}",
	            type : "POST",
	            data : data,
	            dataType : "JSON",
	            processData : false,
	            contentType : false,
	            success: function(response) {
	                btn.html('Update changes').prop('disabled', false).css('cursor', 'pointer');
	                if (response.errors) {
	                    var errorMsg = '';
	                    $.each(response.errors, function(field, errors) {
	                        $.each(errors, function(index, error) {
	                            errorMsg += error + '<br>';
	                        });
	                    });
	                    iziToast.error({
	                        message: errorMsg,
	                        position: 'topRight'
	                    });
	                } else {
	                    $('#add-student-form')[0].reset();
	                    console.log(response);
	                    $('#edit-student-modal').modal('hide');
	                    $('#user-table tbody').load(location.href + " #user-table tbody > *");
	                    iziToast.info({
	                        message: response.message,
	                        position: 'topRight'
	                    });
	                }
	            },
	            error: function(xhr, status, error) {
	                btn.html('Update changes').prop('disabled', false).css('cursor', 'pointer');
	                let errorMessage = 'An error occurred';
	                if (xhr.responseJSON && xhr.responseJSON.errors) {
	                    var errorMsg = '';
	                    $.each(xhr.responseJSON.errors, function(field, errors) {
	                        $.each(errors, function(index, error) {
	                            errorMsg += error + '<br>';
	                        });
	                    });
	                    iziToast.error({
	                        message: errorMsg,
	                        position: 'topRight'
	                    });
	                } else if (xhr.responseJSON && xhr.responseJSON.message) {
	                    errorMessage = xhr.responseJSON.message;
	                    iziToast.error({
	                        message: errorMessage,
	                        position: 'topRight'
	                    });
	                } else {
	                    errorMessage += ': ' + error;
	                    iziToast.error({
	                        message: errorMessage,
	                        position: 'topRight'
	                    });
	                }
	            }
	        });
	    });
	});
</script>
<script>
	function userDelete(id) {
	    Swal.fire({
	        title: 'Are you sure?',
	        text: "This action cannot be undone!",
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#d33',
	        cancelButtonColor: '#3085d6',
	        confirmButtonText: 'Yes, delete it!'
	    }).then((result) => {
	        if (result.isConfirmed) {
	
	            $.ajax({
	                url: "{{ url('ajax-crud-delete') }}/" + id,
	                type: "GET",
	                data: {
	                    _token: $('meta[name="csrf-token"]').attr('content')
	                },
	                success: function (response) {
	                    if (response.success) {
	                        Swal.fire({
	                            title: 'Deleted!',
	                            text: response.message,
	                            icon: 'success',
	                            timer: 1500,
	                            showConfirmButton: false
	                        });
	
	                        // 🔁 reload only table data (no full page refresh)
	                        $('#user-table').load(location.href + " #user-table");
	                    } else {
	                        Swal.fire({
	                            title: 'Error!',
	                            text: response.message || 'Something went wrong.',
	                            icon: 'error'
	                        });
	                    }
	                },
	                error: function (xhr, status, error) {
	                    Swal.fire({
	                        title: 'Error!',
	                        text: 'An unexpected error occurred.',
	                        icon: 'error'
	                    });
	                }
	            });
	        }
	    });
	}
	
</script>
@endpush


*************************************** Controller Side Code To Add ************************************************************
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Hash;
use App\Models\User;

class AjaxCrudController extends Controller
{
    public function ajaxCrud(){
        $users = User::orderBy('id','desc')->paginate(10);
        return view('ajax-crud.index', compact('users'));
    }

    public function ajaxCrudStore(Request $req){
        // dd($req->all());
        $rules = [
            'name' => 'required|string',
            'mobile_no' => 'required|numeric|unique:users,mobile_no',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',

        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'mobile_no' => $req->mobile_no,
        ];

        if ($req->hasFile('image')) {
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/users/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file->move($folderPath, $filename);
            $data['image'] = "app/users/{$year}/{$month}/" . $filename;
        }

        User::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Student Added Successfully'
        ], 201);
    }

    public function ajaxCrudUpdate(Request $req){
        // dd($req->all());
        $user = User::findOrFail($req->id);
        $rules = [
            'name' => 'required|string',
            'mobile_no' => 'required|numeric|unique:users,mobile_no,' .$req->id,
            'email' => 'required|email|unique:users,email,' .$req->id,
        ];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'mobile_no' => $req->mobile_no,
        ];

        if($req->password != null){
            $data['password'] = Hash::make($req->password);
        }

        if ($req->hasFile('image')) {
            if ($user->image && File::exists(public_path($user->image))) {
                File::delete(public_path($user->image));
            }
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/users/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file->move($folderPath, $filename);
            $data['image'] = "app/users/{$year}/{$month}/" . $filename;
        }

        if($user){
            $user->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Student Details Update Successfully!'
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong!'
            ], 422);
        }
    }

    public function ajaxCrudDelete($id){
        // dd($id);
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
    }
}



**************** when image come in array form ****************************
if ($request->hasFile('images')) {
        $uploadedFiles = $req->file('images'); 
        $images = [];
        foreach ($uploadedFiles as $file) {
            $filename = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("hotel-images/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file->move($folderPath, $filename);
            $images[] = "hotel-images/{$year}/{$month}/" . $filename;
        }
        $hotel->images = json_encode($images);
}









