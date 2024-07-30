
		 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

@if (Session::has('success') || Session::has('error') || $errors->any())
<script>
    @if (Session::has('success'))
        var messageType = 'success';
        var messageColor = 'green';
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




use Illuminate\Validation\ValidationException;

catch (ValidationException $e) {
    return back()->withErrors($e->validator)->withInput();
}catch(\Exception $e){
    return back()->with('error', 'Warning : ' .$e->getMessage());
}







************ Another Method ***********************
@if(session()->get('success'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success') }}
    </div>
   @elseif(session()->get('error'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error') }}
    </div>
   @elseif($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
















*********************************************** Sweet Alert With Delete Button *********************************************************

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
				window.location.href = "{{ url('admin/delete-plans', ['id' => '__id__']) }}".replace('__id__', id);				
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


