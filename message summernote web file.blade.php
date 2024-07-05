
		 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>

@if (Session::has('success') || Session::has('error'))
    <script>
        @if (Session::has('success'))
            var messageType = 'success';
            var messageColor = 'green';
            @elseif (Session::has('error'))
                var messageType = 'warning';
                var messageColor = 'orange';
        @endif

        iziToast[messageType]({
            message: "{{ Session::get('success') ?: Session::get('error') }}",
            position: 'topRight',
            timeout: 4000,
            displayMode: 0,
            color: messageColor,
            theme: 'light',
            messageColor: 'black',
        });
    </script>
@endif









************ Another Method ***********************
@if (session()->get('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @elseif (session()->get('error'))
        <div class="alert alert-danger" role="alert">
            {{ session()->get('error') }}
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
                window.location.href = "{{ url('passport-delete') }}/"+id;
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




///////////////////////////////////////  Summernotr In Laravel ////////////////////////////////////////////////////////////////


<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">


<textarea rows="4" name="description" class="form-control summernote"></textarea>



<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function() {
        
        // Initialize Summernote for textareas with the .summernote class
        $('.summernote').summernote({                   
            height: 200, // Adjust the height as needed
            
            // Add more configurations as needed
        });
    });
</script>





------------------------------------------ 404 Page Not Found Logic ------------------------------------------
app/Exceptions/Handler.php 

public function register()
{
    $this->reportable(function (Throwable $e) {
        //
    });
}

public function render($request, Throwable $exception)
      {
          if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
              return response()->view('errors.404', [], 404);
          }

          return parent::render($request, $exception);
      }
