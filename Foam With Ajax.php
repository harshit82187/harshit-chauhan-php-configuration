    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form Example</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    
</head>
<body>
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
						<h4 class="mb-sm-0">Our Teams</h4>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-xxl-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title mb-0">Add Our Teams</h4>
						</div>

						<div class="card-body">
							<form action="{{ url('admin/our-teams/store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row">	
									
									
								    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_english" class="form-label">Profile Photo <span style="color: red;">*</span></label>
											<input type="file" class="form-control" name="profile_photo" required >
										</div>
									</div>

									

									<div class="col-md-6">
										<div class="mb-3">
											<label for="title_english" class="form-label">Name <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="Enter Name " name="name" required autocomplete="off">
										</div>
									</div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Designation <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="Enter Designation " name="designation"  required autocomplete="off">
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Description <span style="color: red;">*</span></label>
											<input type="text" class="form-control" placeholder="Enter Description " name="description"  required autocomplete="off">
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Facebook</label>
											<input type="text" class="form-control" placeholder="Enter Facebook Link " name="facebook"   autocomplete="off">
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Instagram</label>
											<input type="text" class="form-control" placeholder="Enter Instagram Link " name="instagram"  required autocomplete="off">
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Twitter</label>
											<input type="text" class="form-control" placeholder="Enter Twitter Link " name="twitter"   autocomplete="off">
										</div>
									</div>

                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="title_hindi" class="form-label">Linkedin</label>
											<input type="text" class="form-control" placeholder="Enter Linkedin " name="linkedin"   autocomplete="off">
										</div>
									</div>

									
									<div class="col-lg-12">
										<div class="">
											<button type="submit" class="btn btn-primary saveBtn">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			

		</div>
	</div>


    

    <!-- Add Bootstrap JS and jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $('#myForm').submit(function(e){
                e.preventDefault();
                // alert("hello");
                var formData = new FormData(this);
                var imageInput = document.querySelector('input[name="image"]');
                if(imageInput.files.length > 0){
                    formData.append('image', imageInput.files[0]);
                }
                

                $.ajax({
                    type: 'POST',
                    url: '{{ route('add-student') }}',
                    data: formData,
                    processData: false, 
                    contentType: false,
                    success:function(response){
                        if(response.success){
                            $('#successMsg').show();
                            $('#myForm')[0].reset();
                            console.log(response);
                        }
                    },
                    error:function(response){
                        $('#nameError').text(response.responseJSON.errors.name);
                        $('#imageError').text(response.responseJSON.errors.image);
                        $('#emailError').text(response.responseJSON.errors.email);
                        $('#mobileError').text(response.responseJSON.errors.mobile);
                        $('#genderError').text(response.responseJSON.errors.gender);
                        $('#courseError').text(response.responseJSON.errors.course);
                        var errorMessage = response.responseJSON.message || 'An error occurred.';
                        $('#errorMsg').text(errorMessage).show();
                        console.log(response);
                    }
                });

            });
        }); 
    
    </script>







</body>
</html>






******************************** Add Controller Side Code ********************************************

@if ($errors->any())
<div class="alert alert-danger" role="alert">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

use Illuminate\Validation\ValidationException;


public function addStudent(Request $request){
    if($request->isMethod('get')){
        return view('form');
    }

    if($request->isMethod('post')){
        
            // dd($request->all());

            $validator = Validator::make($request->all(),[
                'name' => 'required|string',
                'image' => 'required|image|mimes:jpg,jpeg,png',
                'mobile' => 'required|digits:10|unique:users,contact',
                'email' => 'required|email',
                'gender' => 'required',
                'course' => 'required',
            ]);

            if($validator -> fails()){
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

          try{

            if($request->file('image') != null){
                $file = $request->file('image');
                $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files'), $filename);
            }

            $form = new Form();
            $form->name = $request->name;
            $form->image = $filename;
            $form->email = $request->email;
            $form->mobile = $request->mobile;
            $form->gender = $request->gender;

            $form->save();
            return response()->json(['success'=>'Successfully']);


        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();

        }catch(\Exception $e){
            return response()->json([
                'message' => 'An Error Occurred : '.$e->getMessage()
            ],500);
        }

    }
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