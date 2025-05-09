 ************************************************* Roles And Permission In the laravel  **************************************************


Step : 1 Create Table in the database

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_role_id` bigint(20) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `email` longtext DEFAULT NULL,
  `mobile_no` varchar(10) DEFAULT NULL,
  `password` longtext DEFAULT NULL,
  `identify_type` varchar(250) DEFAULT NULL,
  `identify_number` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `identity_image` varchar(250) DEFAULT NULL,
  `status` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `module` longtext DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




Step : 2 web file code


 Route::prefix('custom-role/')->name('custom-role.')->controller(EmployeeController::class)->group(function(){
        Route::get('add', 'roleView')->name('add');
        Route::post('store', 'roleStore')->name('store');
        Route::post('status-change', 'statusChange')->name('status-change');
        Route::get('edit/{id}', 'roleEdit')->name('edit');
        Route::post('update', 'roleUpdate')->name('update');
        Route::get('delete/{id}', 'roleDelete')->name('delete');
    });

    Route::prefix('employee/')->name('employee.')->controller(EmployeeController::class)->group(function(){
        Route::get('add', 'employeeView')->name('add');
        Route::post('store', 'employeeStore')->name('store');
        Route::post('status-change', 'employeeStatusChange')->name('status-change');
        Route::get('edit/{id}', 'employeeEdit')->name('edit');
        Route::get('view/{id}', 'employeeViews')->name('view');
        Route::post('update', 'employeeUpdate')->name('update');
    });



Step : 3 Controller side code file code

<?php

namespace App\Http\Controllers\Admin\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\AdminRole;
use App\Models\Admin;


use Hash;
use Str;
use Mail;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Admin\RoleExport;
use App\Exports\Admin\EmployeeExport;

class EmployeeController extends Controller
{
  
    public function roleView(Request $req){
        $query = AdminRole::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        if ($req->has('export')) {
            return Excel::download(new RoleExport($query->get()), 'role_list.xlsx');
        }
        $roles = $query->where('id', '!=', 1)->orderBy('id','desc')->paginate(10);
        return view('admin.role.add',compact('roles'));
    }

    public function roleStore(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string|unique:admin_roles,name',
            'module' => 'required|array',
        ], [
            'name.required' => 'This role name is required.',
            'name.string' => 'This role name must be a valid string.',
            'name.unique' => 'This role name already exists. Please enter a different one.',
            'module.required' => 'At least one module must be selected.',
            'module.array' => 'Invalid format for modules.',
        ]);
        

        $adminRole = new AdminRole();
        $adminRole->name = $req->name;
        $adminRole->module = json_encode($req->module);
        $adminRole->save();
        return back()->with('success','Role Setup Successfully!');
    }

    
    public function statusChange(Request $request)
    {
        $request->validate([
            'role_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);    
    
        try {
            $adminRole = AdminRole::findOrFail($request->role_id);
            $adminRole->status = $request->status;
    
            if ($adminRole->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role status updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update review status.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function roleEdit($id){
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $selectedModules = json_decode($role->module, true) ?? [];
        return view('admin.role.edit', compact('role','selectedModules'));
    }

    public function roleUpdate(Request $req){
        // dd($req->all());
        $id = $req->id;
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $req->validate([
           'name' => 'required|string|unique:admin_roles,name,' . $id,
            'module' => 'required|array',
        ], [
            'name.required' => 'This role name is required.',
            'name.string' => 'This role name must be a valid string.',
            'name.unique' => 'This role name already exists. Please enter a different one.',
            'module.required' => 'At least one module must be selected.',
            'module.array' => 'Invalid format for modules.',
        ]);
        
        $role->name = $req->name;
        $role->module = json_encode($req->module);
        $role->save();
        return redirect()->route('admin.custom-role.add')->with('success', 'Role Update Successfully!');
    }

    public function roleDelete($id){
        // dd($id);
        $role = AdminRole::findOrFail($id);
        if(!$role){
            return back()->with('error','Role Not Found!');
        }
        $role->delete();
        return back()->with('error','Role Delete Successfully!');
    }







    public function employeeView(Request $req){
        // dd($req->all());
        $query = Admin::query();
        if($req->has('name') && $req->name != null){
            $query->where('name','like','%' .$req->name . '%');
        }
        if ($req->has('admin_role_id') && $req->admin_role_id !== 'null' && $req->admin_role_id !== null) {
            $query->where('admin_role_id',$req->admin_role_id);
        }
        if ($req->has('export')) {
            return Excel::download(new EmployeeExport($query->get()), 'employee_list.xlsx');
        }
        $employees = $query->where('id', '!=', 1)->orderBy('id','desc')->paginate(10);
        $roles = AdminRole::where('id', '!=', 1)->orderBy('id','desc')->get();
        // dd($roles);
        return view('admin.employee.add',compact('employees','roles'));
    }

    public function employeeStore(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string',
            'mobile_no' => 'required|digits:10|unique:admins,mobile_no',
            'email' => 'required|email|unique:admins,email',
            'admin_role_id' => 'required|numeric',
            'identify_type' => 'required|numeric',
            'identify_number' => 'required|string',
            'password' => 'required|string',
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'identity_image' => 'required|image|mimes:jpeg,jpg,png',
        ], [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a valid string.',            
            'mobile_no.required' => 'Mobile number is required.',
            'mobile_no.digits' => 'Mobile number must be exactly 10 digits.',
            'mobile_no.unique' => 'This mobile number is already taken.',            
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already registered.',            
            'admin_role_id.required' => 'Please select an admin role.',
            'admin_role_id.numeric' => 'Admin role must be numeric.',            
            'identify_type.required' => 'Identification type is required.',
            'identify_type.numeric' => 'Identification type must be numeric.',            
            'identify_number.required' => 'Identification number is required.',
            'identify_number.string' => 'Identification number must be a string.',            
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',            
            'image.required' => 'Profile image is required.',
            'image.image' => 'Profile image must be a valid image file.',
            'image.mimes' => 'Profile image must be a JPEG or PNG file.',            
            'identity_image.required' => 'Identity image is required.',
            'identity_image.image' => 'Identity image must be a valid image file.',
            'identity_image.mimes' => 'Identity image must be a JPEG or PNG file.',
        ]);       

        $admin = new Admin();
        $admin->name = $req->name;
        $admin->mobile_no = $req->mobile_no;
        $admin->email = $req->email;
        $admin->admin_role_id = $req->admin_role_id;
        $admin->identify_type = $req->identify_type;
        $admin->identify_number = $req->identify_number;
        $admin->password = Hash::make($req->password);
        $admin->status = 1;

        if($req->identity_image != null){
            $file = $req->identity_image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/admin/identity-image/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $admin->identity_image = "app/admin/identity-image/{$year}/{$month}/" . $filename;
        }

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("app/admin/image/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $admin->image = "app/admin/image/{$year}/{$month}/" . $filename;
        }

        $admin->save();
        return back()->with('success','Employee Add Successfully!');
    }

    public function employeeEdit($id){
        $admin = Admin::findOrFail($id);
        if(!$admin){
            return back()->with('error','Admin Not Found!');
        }
        return view('admin.employee.edit', compact('admin'));
    }

    
    public function employeeViews($id){
        $admin = Admin::findOrFail($id);
        if(!$admin){
            return back()->with('error','Admin Not Found!');
        }
        return view('admin.employee.view', compact('admin'));
    }

    public function employeeStatusChange(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',  
            'status' => 'required|boolean',  
        ]);    
    
        try {
            $admin = Admin::findOrFail($request->employee_id);
            $admin->status = $request->status;
    
            if ($admin->save()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Employee status updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update review status.',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage(),
            ], 500);
        }
    }
}





Step : 4 admin.role.add file code 

@extends('admin.layout.app')
@section('content')
@push('css')

@endpush

<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
        <img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
        <h3 class="mt-3">Employee role setup <span class="count-circle mt-3">{{ count($roles ) }}</span></h3>	
	</div>
</div>

<div class="row">
    <div class="col-12">        
        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>


<div class="card">
    <div class="card-body">
        <form id="submit-create-role" method="post" action="{{ route('admin.custom-role.store') }}" class="text-start">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mb-4">
                        <label for="name" class="title-color">Role name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"  placeholder="Ex:Store" required>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-4 flex-wrap align-items-center">
                <label for="name" class="title-color font-weight-bold mb-0">Module permission </label>
                <div class="form-group d-flex gap-2">
                    <input type="checkbox" id="select-all" class="cursor-pointer">
                    <label class="title-color mb-0 cursor-pointer text-capitalize" for="select-all">Select all</label>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" value="dashboard" class="module-permission" id="dashboard">
                        <label class="title-color mb-0" 
                                for="dashboard">Dashboard</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" value="enrool_student" class="module-permission" id="enrool_student">
                        <label class="title-color mb-0"  for="enrool_student">Enrool Student</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="manage_member" id="manage_member">
                        <label class="title-color mb-0 text-capitalize" for="order">Manage Member</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="donation" id="donation">
                        <label class="title-color mb-0 text-capitalize" for="donation">Donation & Point's</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="notification_management" id="notification_management">
                        <label class="title-color mb-0 text-capitalize" for="notification_management">Notification Management</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" name="module[]" class="module-permission" value="student_document" id="student_document">
                        <label class="title-color mb-0 text-capitalize" for="student_document">Student Document</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="course_management" id="course_management">
                        <label class="title-color mb-0 text-capitalize" for="course_management">Course Management</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="college_management" id="college_management">
                        <label class="title-color mb-0 text-capitalize" for="college_management">College management</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="question_bank" id="question_bank">
                        <label class="title-color mb-0 text-capitalize" for="question_bank">Question Bank</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="manage_task" id="manage_task">
                        <label class="title-color mb-0 text-capitalize" for="manage_task">Manage Task</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="trust_setting" id="trust_setting">
                        <label class="title-color mb-0 text-capitalize" for="trust_setting">Trust Setting</label>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="form-group d-flex gap-2">
                        <input type="checkbox" class="module-permission" name="module[]" value="log_setting" id="log_setting">
                        <label class="title-color mb-0 text-capitalize" for="log_setting">Log Details</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>        
</div>

<div class="card">
    <div class="card-header d-block d-sm-flex justify-content-between align-items-center">
        <span></span>
        <div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
            <form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
                <input type="text" class="form-control" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Role">
                <button class="btn btn-primary mt-2 mt-sm-0">Search</button>
                <button type="submit" name="export" value="1" class="btn btn-dark text-nowrap mt-2 mt-sm-0">Export Excel</button>
                <button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
                </form>
        </div>
    </div>
<div class="card-body">
            <div class="table-responsive table-card mt-3 mb-1">
                <table class="table align-middle table-nowrap ">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Role name</th>
                            <th>Modules</th>
                            <th>Created at	</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($roles) && $roles->count())
                                @foreach($roles as $key => $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name ?? "N/A" }}</td>
                                    @php $decodedModules = json_decode($role->module, true) ?? []; @endphp
                                    <td class="text-capitalize">
                                        @foreach($decodedModules as $decodedModule)
                                        {{ ucwords(str_replace('_', ' ', $decodedModule)) }} <br>
                                        @endforeach
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d-M-Y h:i A') }}</td>
                                    <td>
                                        <label class="switch">
                                        <input type="checkbox" class="status-toggle" data-id="{{ $role->id }}" {{ $role->status ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                        </label> 
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.custom-role.edit',$role->id) }}" class="btn btn-info btn-sm" >Edit</a>
                                        <a href="javascript:void(0)" onclick="deleteRole({{ $role->id }})" class="btn btn-danger btn-sm" >Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            @else 
                            <tr>
                                <td colspan="6" class="text-danger text-center" >No Role Found!</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $roles->links('pagination::bootstrap-4') }}
            </div>
        </div>
</div>

@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#select-all').change(function() {
            $('.module-permission').prop('checked', $(this).prop('checked'));
        });

        $('.module-permission').change(function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            } else if ($('.module-permission:checked').length === $('.module-permission').length) {
                $('#select-all').prop('checked', true);
            }
        });

       
        $('.status-toggle').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var role_id = $(this).data('id');
    
            $.ajax({
                url: '{{ url('admin/custom-role/status-change') }}',
                type: 'POST',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'role_id': role_id,
                    'status': status
                },
                success: function(response) {
                    iziToast.info({
                        title: 'Info',
                        message: response.message,
                        position: 'topRight',
                        timeout: 3000,
                    });
                },
                error: function(xhr, status, error) {
                    iziToast.error({
                        title: 'Error',
                        message: 'Error updating status!',
                        position: 'topRight',
                        timeout: 4000,
                        backgroundColor: '#F0D5B6',
                        titleColor: '#000', 
                        messageColor: '#000', 
                        titleSize: '16px',
                        messageSize: '16px',
                        titleLineHeight: '20px',
                        messageLineHeight: '16px',
                        titleFontWeight: '700', 
                        messageFontWeight: '700'
                        });
                }
            });
        });
        
    });

    function deleteRole(id) {
        Swal.fire({
            title: 'Are you sure to delete this?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes Delete It!',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.custom-role.delete', ':id') }}".replace(':id', id);
            }
        });
    }
</script>
<script>
	$(document).on('submit', '#submit-create-role', function() {
		let btn = $('button[type="submit"]');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
@endpush




Step : 5 admin.employee.add file code 

@extends('admin.layout.app')
@section('content')
@push('css')

@endpush
<div class="card">
	<div class="card-header" style="display: flex; gap: 10px; align-items: center;">
		<img src="{{ asset('admin/assets/img/employee.png') }}" width="40px" width="40px">
		<h3 class="mt-3">Add New Employee <span class="count-circle mt-3">{{ count($employees ) }}</span></h3>
	</div>
</div>
<div class="row">
	<div class="col-12">
		@if(session()->get('error'))
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			{{ session()->get('error') }}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
		@if ($errors->any())
		<div class="alert alert-danger alert-dismissible fade show">
			<ul>
				@foreach ($errors->all() as $error)
				<li style="font-size:larger;">{{ $error }}</li>
				@endforeach
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		@endif
	</div>
</div>

<div class="row">
    <div class="col-12">        
        @if(session()->get('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="font-size:larger;">{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
</div>


<div class="card">
	<div class="card-body">
		<form id="employee-store" action="{{ route('admin.employee.store') }}" method="post" enctype="multipart/form-data" class="text-start">
			@csrf                  
			<div class="card">
				<div class="card-body">
					<h5 class="mb-0 page-header-title text-capitalize d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						General information
					</h5>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="name"	class="title-color">Full name <span class="text-danger" >*</span>  </label>
								<input type="text" name="name" class="form-control alphabet" id="name"	placeholder="Ex:John Doe" value="" required>
							</div>
							<div class="form-group">
								<label for="phone" class="title-color">Phone <span class="text-danger" >*</span> </label>
								<div class="mb-3">
									<input class="form-control number" name="mobile_no" type="text" id="exampleInputPhone" value=""	placeholder="Enter phone number" required>
								</div>
							</div>
							<div class="form-group">
								<label for="admin_role_id" class="title-color">Role <span class="text-danger" >*</span> </label>
								<select class="form-control" name="admin_role_id" id="admin_role_id" required>
									<option value="0" selected disabled>Select Role	</option>
                                    @isset($roles)
                                        @foreach($roles as $role)
									        <option	value="{{ $role->id }}" >{{ $role->name ?? 'N/A' }}</option>
                                        @endforeach
                                    @endisset
									
								</select>
							</div>
							<div class="form-group">
								<label for="identify_type" class="title-color">Identify type <span class="text-danger" >*</span> </label>
								<select class="form-control" name="identify_type" id="identify_type" required>
									<option value="" selected disabled>Select identify type</option>
									<option value="1">Aadhar Card</option>
									<option value="2">Pan Card</option>
                                    <option value="3">Driving License</option>

								</select>
							</div>
							<div class="form-group">
								<label for="identify_number" class="title-color">Identify number <span class="text-danger" >*</span> </label>
								<input type="text" name="identify_number" class="form-control"	placeholder="Ex:9876123123" id="identify_number" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<div class="text-center mb-3">
									<img class="upload-img-view" id="viewer"
										src="https://server1.pearl-developer.com/silvana/public/assets/back-end/img/400x400/img2.jpg"
										alt=""/>
								</div>
								<div class="form-group">
									<label for="employee_image">
									Employee Image 
									<small class="text-info">( Ratio 1:1 )</small><span class="text-danger" >*</span> 
									</label>
									<input type="file" name="image" id="image" accept=".jpeg,.jpg,.png,image/jpeg,image/jpg,image/png" required class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="text-center mb-3">
									<img class="upload-img-view" id="viewer2"
										src="https://server1.pearl-developer.com/silvana/public/assets/back-end/img/400x400/img2.jpg"
										alt=""/>
								</div>
								<div class="form-group">
									<label for="identity_image">Identity Image <small class="text-info">( Ratio 1:1 )</small><span class="text-danger" >*</span> </label>
									<input type="file" name="identity_image" id="identity_image" accept=".jpeg,.jpg,.png,image/jpeg,image/jpg,image/png" required class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card mt-3">
				<div class="card-body">
					<h5 class="mb-0 page-header-title d-flex align-items-center gap-2 border-bottom pb-3 mb-3">
						<i class="tio-user"></i>
						Account Information
					</h5>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="email" class="title-color">Email <span class="text-danger" >*</span> </label>
								<input type="email" name="email" autocomplete="one-time-code" class="form-control"	id="email"	placeholder="Ex:ex@gmail.com" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                                <label for="password">Password <span class="text-danger" >*</span> </label>
                                <div class="password-field">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="one-time-code" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#password"></i>
                                </div>
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
                                <label for="confirmPassword">Confirm Password <span class="text-danger" >*</span> </label>
                                <div class="password-field">
                                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" autocomplete="one-time-code" required>
                                    <i class="fa-solid fa-eye-slash password-toggle" toggle="#confirmPassword"></i>
                                </div>
							</div>
                            <span class="text-danger mx-1 password-error"></span>
						</div>
					</div>
					<div class="d-flex justify-content-end gap-3">
						<button type="reset" id="reset" class="btn btn-secondary px-4">Reset</button>
						<button type="submit" id="submit-button" class="btn btn-primary px-4">Submit</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<div class="card">
	<div class="card-header d-block d-sm-flex justify-content-between align-items-center">
		<span></span>
		<div class="d-block d-sm-flex gap-2 align-items-center justify-content-between">
			<form action="{{ url()->current() }}" method="get" class="d-block d-sm-flex gap-2">
				<input type="text" class="form-control filter-name" value="{{ request()->query('name', '') }}" name="name" placeholder="Search Employee Name">
				<select name="admin_role_id"  class="form-control filter-select">
                    <option value="null" selected>All Role</option>
                    @isset($roles)
                        @foreach($roles as $role)
                            <option	value="{{ $role->id }}" >{{ $role->name ?? 'N/A' }}</option>
                        @endforeach
                    @endisset
                </select>
                <button class="btn btn-primary mt-2 mt-sm-0">Search</button>
				<button type="submit" name="export" value="1" class="btn btn-dark text-nowrap mt-2 mt-sm-0">Export Excel</button>
				<button type="button" class="btn btn-info mt-2 mt-sm-0 " onclick="window.location.href='{{ route(Route::currentRouteName()) }}';">Reset</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive table-card mt-3 mb-1">
			<table class="table align-middle table-nowrap ">
				<thead class="table-light">
					<tr>
						<th>SL</th>
						<th>Name</th>
						<th>Contact Info</th>
						<th>Role</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@if(isset($employees) && $employees->count())
					@foreach($employees as $key => $employee)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td class="text-capitalize">
                            <div class="media align-items-center d-flex gap-3"> 
                                <img class="rounded-circle avatar avatar-lg" alt="{{ asset($employee->image) }}" src="{{ asset($employee->image) }}"  >
                                <div class="media-body">{{ $employee->name ?? 'N/A' }}</div>
                            </div>
                        </td>
						<td class=""> {{ $employee->email ?? 'N/A' }} <br> {{ $employee->mobile_no ?? 'N/A' }} </td>
						<td>{{ $employee->mobile_no ?? 'N/A' }}</td>
						<td>
							<label class="switch">
							<input type="checkbox" class="status-toggle" data-id="{{ $employee->id }}" {{ $employee->status ? 'checked' : '' }}>
							<span class="slider round"></span>
							</label> 
						</td>
						<td>
							<a href="{{ route('admin.employee.edit',$employee->id) }}" class="btn btn-info btn-sm" >Edit</a>
							<a href="{{ route('admin.employee.view',$employee->id) }}" class="btn btn-dark btn-sm" >View</a>
						</td>
					</tr>
					@endforeach
					@else 
					<tr>
						<td colspan="6" class="text-danger text-center" >No Employee Found!</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
		<div class="d-flex justify-content-center mt-4">
			{{ $employees->links('pagination::bootstrap-4') }}
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	$(document).ready(function() {
	   
	    $('.status-toggle').change(function() {
	        var status = $(this).prop('checked') == true ? 1 : 0;
	        var employee_id = $(this).data('id');
	
	        $.ajax({
	            url: '{{ url('admin/employee/status-change') }}',
	            type: 'POST',
	            data: {
	                '_token': $('meta[name="csrf-token"]').attr('content'),
	                'employee_id': employee_id,
	                'status': status
	            },
	            success: function(response) {
	                iziToast.info({
	                    title: 'Info',
	                    message: response.message,
	                    position: 'topRight',
	                    timeout: 3000,
	                });
	            },
	            error: function(xhr, status, error) {
	                iziToast.error({
	                    title: 'Error',
	                    message: 'Error updating status!',
	                    position: 'topRight',
	                    timeout: 4000,
	                    backgroundColor: '#F0D5B6',
	                    titleColor: '#000', 
	                    messageColor: '#000', 
	                    titleSize: '16px',
	                    messageSize: '16px',
	                    titleLineHeight: '20px',
	                    messageLineHeight: '16px',
	                    titleFontWeight: '700', 
	                    messageFontWeight: '700'
	                    });
	            }
	        });
	    });
	    
	});

</script>
<script>
	$(document).on('submit', '#employee-store', function() {
		let btn = $('#submit-button');
		btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...').prop('disabled', true).css('cursor', 'no-drop');
	});
</script>
<script>
    $(document).ready(function() {

        function validatePassword(){
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();

            if(password != confirmPassword){
                $('.password-error').text("Password Do Not Match!");
                $('#submit-button').css('cursor','no-drop').attr('title','Password Do not Match!').prop('disabled',true);
            }else{
                $('.password-error').text("");
                $('#submit-button').prop('disabled',false).css('cursor','pointer');
            }

        }

        $('#confirmPassword').on('keyup',function(){
            validatePassword()
        });

        $('#image').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#viewer').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
        $('#identity_image').change(function(e) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#viewer2').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
    });
    document.querySelectorAll('.password-toggle').forEach(function(eyeIcon) {
        eyeIcon.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        });
    });
    $("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
         if (this.value.length > 10) {
          this.value = this.value.slice(0, 10); 
      }
    });
    $(".alphabet").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
    });
</script>
@endpush



Step : 6 in auth controller add this two line where i call dashbaord function 

 $permissions = json_decode($admin->role->module);
session(['role_permissions' => $permissions]);



Step : 7 Add this if condition in the admin sidebar to authenticate admin module exist or not in the admin roles table.

<ul class="nav nav-secondary">
	@if(in_array('dashboard', $permissions))
	<li class="nav-item active">
		<a	href="{{ route('admin.dashboard') }}"	aria-expanded="false">
			<i class="fas fa-home"></i>	<p>Dashboard</p>						
		</a>					
	</li>
	@endif

	@if(in_array('enrool_student', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.enrool-student') ? 'active' : '' }}">
		<a  href="{{ route('admin.enrool-student') }}">
			<i class="fas fa-user-plus"></i>
			<p>Enroll Student</p>
		</a>					
	</li>
	@endif

	<li class="nav-item {{ request()->routeIs('admin.custom-role.add','admin.custom-role.edit','admin.employee.add') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#employee">
			<i class="fas fa-user-tie"></i>
			<p>Manage Employee</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.custom-role.add','admin.custom-role.edit','admin.employee.add')  ? 'show' : '' }}"  id="employee">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.custom-role.add','admin.custom-role.edit') ? 'active' : '' }}" >
					<a href="{{ route('admin.custom-role.add') }}">
					<span class="sub-item">Employee Role Setup</span>
					</a>
				</li>

				<li class="{{ request()->routeIs('admin.employee.add') ? 'active' : '' }}" >
					<a href="{{ route('admin.employee.add') }}">
					<span class="sub-item">Employees</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	
	@if(in_array('manage_member', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.member.indian-list') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#members">
			<i class="fas fa-id-card"></i>
			<p>Manage Member</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.member.indian-list') ? 'show' : '' }}"  id="members">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.member.indian-list') ? 'active' : '' }}" >
					<a href="{{ route('admin.member.indian-list') }}">
					<span class="sub-item">Member List</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif

	@if(in_array('donation', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.donation-report') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#donations">
			<i class="fas fa-gem"></i>
			<p>Donation &  Point's</p>
			<span class="caret"></span>
		</a>
		<div class="collapse {{ request()->routeIs('admin.donation-report') ? 'show' : '' }}" id="donations">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.donation-report') ? 'active' : '' }}">
					<a href="{{ route('admin.donation-report') }}">	<span class="sub-item">Donation Report</span></a>
				</li>
			</ul>
		</div>
	</li>
	@endif 

	@if(in_array('notification_management', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.notification') ? 'active' : '' }}">
		<a href="{{ route('admin.notification') }}">
			<i class="fas fa-bell"></i>
			<p>Notification Management</p>
		</a>				
	</li>
	@endif 

	@if(in_array('student_document', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.document') ? 'active' : '' }}">
		<a  href="{{ route('admin.document') }}">
			<i class="fas fa-file-alt"></i>
			<p>Student Document</p>
		</a>				
	</li>
	@endif 

	@if(in_array('course_management', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.courses') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#courses" class="menu-link">
			<i class="fas fa-book-open"></i>
			<p>Course Management</p>
			<span class="caret"></span>
		</a>
		<div class="collapse {{ request()->routeIs('admin.courses') || request()->routeIs('admin.edit-course') ? 'show' : '' }}" id="courses">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.courses') || request()->routeIs('admin.edit-course') ? 'active' : '' }}">
					<a href="{{ route('admin.courses') }}">
						<span class="sub-item">Add Course</span>
					</a>
				</li>
			</ul>
		</div>
	</li>
	@endif 

	@if(in_array('college_management', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.college-add') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#collegeManagement">
			<i class="fas fa-university"></i>
			<p>College Management</p>
			<span class="caret"></span>
		</a>
		<div class="collapse {{ request()->routeIs('admin.college-add') || request()->routeIs('admin.college-list') || request()->routeIs('admin.college-staff-list') ? 'show' : '' }}" id="collegeManagement">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.college-add') ? 'active' : '' }}">
					<a href="{{ route('admin.college-add') }}">	<span class="sub-item">College Add</span></a>
				</li>
				<li class="{{ request()->routeIs('admin.college-list') ? 'active' : '' }}">
					<a href="{{ route('admin.college-list') }}">	<span class="sub-item">College List</span></a>
				</li>
				<li class="{{ request()->routeIs('admin.college-staff-list') ? 'active' : '' }}">
					<a href="{{ route('admin.college-staff-list') }}">	<span class="sub-item">Staff List</span></a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif

	@if(in_array('question_bank', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.test-series.list') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#questions">
			<i class="fas fa-question-circle"></i>
			<p>Question Bank</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.test-series.list') || request()->routeIs('admin.question.list') ? 'show' : '' }}"  id="questions">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.test-series.list') ? 'active' : '' }}" >
					<a href="{{ route('admin.test-series.list') }}">
					<span class="sub-item">Add Test Series</span>
					</a>
				</li>

				<li class="{{ request()->routeIs('admin.question.list') ? 'active' : '' }}" >
					<a href="{{ route('admin.question.list') }}">
					<span class="sub-item">Add Question</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif 

	@if(in_array('manage_task', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.task-list') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#tasks">
			<i class="fas fa-tasks"></i>
			<p>Manage Task</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.task-list') ? 'show' : '' }}" id="tasks">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.task-list') ? 'active' : '' }}" >
					<a href="{{ route('admin.task-list') }}">
					<span class="sub-item">Add Task</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif

	@if(in_array('trust_setting', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.social-pages.privacy-policy') ||  request()->routeIs('admin.social-pages.term-condition') || request()->routeIs('admin.contact-us') ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#settings">
			<i class="fas fa-shield-alt"></i>
			<p>Trust Setting</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.social-pages.privacy-policy') || request()->routeIs('admin.social-pages.term-condition') ? 'show' : '' }}"  id="settings">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.social-pages.privacy-policy') || request()->routeIs('admin.social-pages.term-condition') ? 'active' : '' }}" >
					<a href="{{ route('admin.social-pages.privacy-policy') }}">
					<span class="sub-item">Social Pages</span>
					</a>
				</li>

				<li class="{{ request()->routeIs('admin.contact-us')  ? 'active' : '' }}" >
					<a href="{{ route('admin.contact-us') }}">
					<span class="sub-item">Contact Us</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif

	@if(in_array('log_setting', $permissions))
	<li class="nav-item {{ request()->routeIs('admin.logs-student') ||  request()->routeIs('admin.logs-visitor')  ? 'active' : '' }}">
		<a data-bs-toggle="collapse" href="#log-details">
			<i class="fas fa-lock"></i>
			<p>Log Details</p>
			<span class="caret"></span>
		</a>
		<div class="collapse  {{ request()->routeIs('admin.logs-student') || request()->routeIs('admin.logs-visitor') ? 'show' : '' }}"  id="log-details">
			<ul class="nav nav-collapse">
				<li class="{{ request()->routeIs('admin.logs-student') || request()->routeIs('admin.logs-visitor') ? 'active' : '' }}" >
					<a href="{{ route('admin.logs-student') }}">
					<span class="sub-item">Student Log </span>
					</a>
				</li>

				<li class="{{ request()->routeIs('admin.logs-visitor')  ? 'active' : '' }}" >
					<a href="{{ route('admin.logs-visitor') }}">
					<span class="sub-item">Visitor Log</span>
					</a>
				</li>
				
			</ul>
		</div>
	</li>
	@endif	

</ul>








