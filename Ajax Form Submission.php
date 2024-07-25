<div class="card shadow-card" onload="reloadPage()">
    <div class="card-body">
        <form id="products" method="POST" >   
            @csrf  
            <div class="row">                    

                <div class="col-md-12">
                    <div class="mb-3">
                    <label for="question">Product Image</label>
                    <input type="file" class="form-control"  name="image" required >
                    </div>
                </div>     
                
                <div class="col-md-12">
                    <div class="mb-3">
                    <label for="question">Product Name</label>
                    <input type="text" class="form-control"  name="name" required >
                    </div>
                </div>    
                
                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="question">Product Color</label>
                    <input type="text" class="form-control"  name="colour" required >
                    </div>
                </div>       
                
                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="question">Product Quantity</label>
                    <input type="text" class="form-control"  name="qty" required >
                    </div>
                </div>  
                
                <div class="col-md-2">
                    <div class="mb-3">
                        <button type="submit" id="product_submit" class="btn btn-success" >Submit</button>             
                    </div>
                </div> 
        
        
        
        


            </div>
        </form>        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        $("#product_submit").click(function(e){
            e.preventDefault();
            let form = $('#products')[0];
            let data = new FormData(form);
           
            $.ajax({
                url: "{{ route('storeProduct') }}",
                type: "POST",
                data: data,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(response) {
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
                        $('#products')[0].reset();
                        console.log(response);
                        $('#closeModal').trigger('click');
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#dataTable').load(location.href + " #dataTable");

                    }
                },
                error: function(xhr, status, error) {
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
</script>





******************************** Add Controller Side Code ********************************************
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

public function storeProduct(Request $req){
        // dd($req->all());

        $rules = [
            'image' => 'required|image', // Added image validation
            'name' => 'required|string',
            'colour' => 'required|string',
            'qty' => 'required|integer', // Assuming qty should be an integer
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
            'colour' => $req->colour,
            'qty'   => $req->qty,
        ];

        if($req->image != null){
            $file = $req->image;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product'),$filename);
            $data['image'] = $filename;
        }

        Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product added successfully' 
        ], 201);
}









*******************************    Multiple Image Or video Save In the Database    ********************************************************


<!-- Blade File Code -->

<form action="{{ url('admin/videos/store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label for="name" class="form-label">Video Name</label>
                <input type="text" class="form-control" placeholder="name" name="name" id="name" required autocomplete="off">
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label for="videos" class="form-label">Upload Videos</label>
                <input type="file" class="form-control" placeholder="videos" name="videos[]" id="videos" multiple required autocomplete="off">
            </div>
        </div>

            <div class="col-lg-12">
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
    </div>
</form>


<!-- Controller Side Code  -->

public function store(Request $request)
    {
        // dd($request->all());
        try {
            $requestData = $request->all();
            $videoName = $request->input('name'); 
           

            if ($request->hasFile('videos')) {
                $file = $request->file('videos');
                $videoPaths = [];

                foreach($file as $videos){
                    $filename = uniqid() .'.'. $videos->getClientOriginalExtension();
                    $videos->move(public_path('uploads/videos'),$filename);
                    $videoPaths[] = $filename;
                }
                


                
                DB::table('videos')->insert([
                    'name' => $videoName,
                    'video' => json_encode($videoPaths),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                return redirect()->back()->with('success', 'Videos uploaded and saved successfully.');
            }

            return redirect()->back()->with('error', 'No videos were uploaded.');
        } catch (\Exception $e) {
            return back()->with('error', 'Warning: ' . $e->getMessage());
        }
    }





*******************************  Prevoius photo delete when i update new pic *****************************************************************


<!-- Controller Side Code  -->


if($request->hasFile('profile_photo')){

    $currentData =  DB::table('vouchers')->where('id',$request->id)->first();

    // Delete the previous profile_photo
    if (!empty($currentData->profile_photo)) {
        $previousFilePath = public_path('assets/images/teams/') . $currentData->profile_photo;
        if (file_exists($previousFilePath)) {
            unlink($previousFilePath);
        }
    }


    $file = $request->file('profile_photo');
    $filename = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('assets/images/teams'), $filename);
    $data['profile_photo'] = $filename;
}



******************************* Form Submission with modal *****************************************************************

<div class="modal" id="add">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="margin-left:172px; width:697px; margin-top:75px;">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Add Study Material</h4>
                    <button type="button" id="closeModal" class="close"  data-dismiss="modal" style="border:0px; background-color:transparent;" >&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <form id="material_form" method="post" enctype="multipart/form-data"  >
                            @csrf
                            
                    <div class="col-md-12">
                        <div class="mb-3">
                        <label for="question">Title</label>
                        <input type="text" class="form-control"  name="title" >
                        </div>
                    </div>                

                    

                    <div class="col-md-12">
                        <div class="mb-3">
                        <label for="answer">Upload File</label>
                        <input type="file" class="form-control" name="material">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" id="submit"  >Submit</button>
                    </div>
                    </form>                   



               



                    </div>
                                                                                
                </div>
            </div>
        </div>
</div>


<script>

    

$("#submit").click(function(e){
        // alert(1221);
        e.preventDefault();
        let form = $('#material_form')[0];
        let data = new FormData(form);
       
        $.ajax({
            url: "{{ url('admin/study_materials') }}",
            type: "POST",
            data: data,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(response) {
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
                    $('#material_form')[0].reset();
                    console.log(response);
                    $('#closeModal').trigger('click'); // Trigger click on close button
                   
                    iziToast.success({
                        message: response.message,
                        position: 'topRight'
                    });
                    $('#dataTable').load(location.href + " #dataTable");
                }
            },
            error: function(xhr, status, error) {
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

</script>
