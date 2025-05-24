
		 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

@if (Session::has('success') || Session::has('error') || $errors->any())
<script>
    @if (Session::has('success'))
        var messageType = 'info';
        var messageColor = 'blue';
        var message = "{{ Session::get('success') }}";
    @elseif (Session::has('error'))
        var messageType = 'warning';
        var messageColor = 'orange';
        var message = "{{ Session::get('error') }}";
    @elseif ($errors->any())
        var messageType = 'error';
        var messageColor = 'red';
        var message = @json($errors->all());
    @endif

    if (Array.isArray(message)) {
        message.forEach(function (msg) {
            iziToast[messageType]({
                message: msg,
                position: 'topRight',
                timeout: 4000,
                displayMode: 0,
                color: messageColor,
                theme: 'light',
                messageColor: 'black',
            });
        });
    } else {
        iziToast[messageType]({
            message: message,
            position: 'topRight',
            timeout: 4000,
            displayMode: 0,
            color: messageColor,
            theme: 'light',
            messageColor: 'black',
        });
    }
</script>
@endif




use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

catch (ValidationException $e) {
    return back()->withErrors($e->validator)->withInput();
}catch(\Exception $e){
    return back()->with('error', 'Warning : ' .$e->getMessage());
}







*********************************************** Another Method ********************************************************************************




<div class="row">
    <div class="col-12">        
        @if(session()->get('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="close fs-1 text-dark" data-dismiss="alert" aria-label="Close">
                    <span class="text-dark" aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session()->get('error'))
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












***************************************** Sweet Alert Functionality With Success / Error / Validation Failed ******************************

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
       .swal2-icon{
            width: 80px!important;
            height: 80px!important;
        }

        button.button.py-20.-dark-1.bg-blue-1.text-white {
            width: 100%;
        }
</style>

@if(session('success'))
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Error Occurred",
        text: "{{ session('error') }}", 
        showConfirmButton: true,
        iconColor: '#FF0000', 
        timer: 2500
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        position: "top-end",
        icon: "warning",
        title: "Validation Failed!",
        html: `<ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>`,
        showConfirmButton: true,
        iconColor: '#FFA500', 
        timer: 2500
    });
</script>
@endif


************************************************************** Another Method With Command ***********************************************************************************
composer require brian2694/laravel-toastr

php artisan vendor:publish --provider="Brian2694\Toastr\ToastrServiceProvider"


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{!! Toastr::message() !!}


use Brian2694\Toastr\Facades\Toastr;

Toastr::success('Theater Booked Successfully!', 'Success');
Toastr::error('Cancellation Request Already Raised.', 'error');













************************************************************* Sweet Alert With Delete Button *********************************************************************************

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">


<style>
    .box-title{
        display: none;
    }

    .heading{
        margin: 0;
    }

    .btnntn{
        width: 100px;
    }

    .box-tools{
        display: flex;
        justify-content: end;
    }

    .swal2-title{
        font-size: 4rem;
    }

    .swal2-icon .swal2-icon-content {
        display: flex;
        align-items: center;
        font-size: 6.75em;
    }

    .swal2-icon{
        width: 14em;
        height: 14em;
    }

    .swal2-popup{
        width: 30%;
        height: 37rem;
    }

    .swal2-styled.swal2-confirm {
        width: 40%;
        font-size: 18px;
    }

    .swal2-styled.swal2-cancel{
        width: 35%;
        font-size: 18px;
    }

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

Route::get('account-details-active/{id}', 'account_active')->name('account_active');


<!-- Blade File Code -->

<button class="btn btn-success btn-sm" onclick="changeStatus({{ $data->id }})">Status Change</button>




<script>
    function changeStatus(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText:'Delete ',
            customClass: {
                popup: 'swal2-large',
                content: 'swal2-large'
            }
        }).then((result) => {
            if (result.isConfirmed) {
				window.location.href = "{{ url('admin/delete-plans') }}/" +id;				
                console.log("Harshit");
            }
        });
    }
</script>


///////////////////////////////////////  Modal And Migrate Command In web file ////////////////////////////////////////////////////////////////


Route::get('/migration', function(){
    try {
        Artisan::call('make:model', ['name' => 'Surveillance', '-m' => true]);
        return 'Model and migration created successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});



Route::get('/migrate', function(){
    try {
        Artisan::call('migrate', ['--path' => '/database/migrations/2024_05_14_175020_create_surveillances_table.php']);
        return 'Migration ran successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});




///////////////////////////////////////  Summernote In Laravel ////////////////////////////////////////////////////////////////


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



////////////////////////////////////// editor in laravel //////////////////////////////////////////////////////////////////

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jodit@3.24.3/build/jodit.min.css">

<textarea class="form-control editor" name="preparation_plans" rows="5" placeholder="Enter Details" required>{{ $course->preparation_plans }}</textarea>
<script src="https://cdn.jsdelivr.net/npm/jodit@3.24.3/build/jodit.min.js"></script>

<script>
    $(document).ready(function() {
        $('.editor').each(function() {
            new Jodit(this, {
                height: 300, // Adjust the editor height
                toolbarSticky: false, // Toolbar will not stick on scroll
                defaultMode: "1", // Start in WYSIWYG mode
                uploader: {
                    insertImageAsBase64URI: true // Allows direct image uploads
                }
            });
        });
    });
</script>


///////////////////////////////////////  select2 In Laravel ////////////////////////////////////////////////////////////////

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
.select2-container--default .select2-selection--single {
    height: 38px !important;
    line-height: 38px !important; 
    padding: 5px 10px;
}

.select2-container--default .select2-selection--multiple {
    min-height: 38px !important; 
    line-height: 28px !important; 
    padding: 5px 10px;
}
<select class="form-control select2" name="member_id">
	<option value="all" selected>All Members</option>
	@foreach($members as $member)
	    <option value="{{ $member->id }}">{{ $member->name }}</option>
	@endforeach
</select>


<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width:'300px'
        });
    });
</script>
