
composer create-project laravel/laravel:^10.0 ecommerece


***************************************** Add Modal **********************************************************************

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
                        <div class="col-md-6 mb-3">
                            <label for="name">Profile Photo</label>
                            <input type="file" class="form-control" name="profile_photo" accept=".jpg,.png,.jpeg" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="mobile">Mobile</label>
                            <input type="number" class="form-control" name="mobile_no" placeholder="Enter your mobile number">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter your password">
                        </div>

                        <div class="col-md-6 mb-3">
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

                        <div class="col-md-6 mb-3">
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




***************************************** Add Modal Script **************************************************************

<script>
        $("#submit").click(function(e){
            e.preventDefault();
            let form = $('#studentForm')[0];
            let data = new FormData(form);
           
            $.ajax({
                url: "{{ route('register') }}",
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
                        $('#studentForm')[0].reset();
                        console.log(response);
                        $('#closeModal').trigger('click');
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
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




*************************************** Controller Side Code To Add ************************************************************
use Illuminate\Support\Facades\File;

public function register(Request $req){
        // dd($req->all());

        $rules = [
            'profile_photo' => 'required|image', 
            'name' => 'required|string',
            'mobile_no' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'gender' => 'required', 
            'hobby' => 'required', 

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
            'gender'   => $req->gender,
            'hobby'    => json_encode($req->hobby),
        ];


        if($request->profile_photo != null){
            $file = $request->profile_photo;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("users/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $data['profile_photo'] = "users/{$year}/{$month}/" . $filename;
        }


      **************** when image come in array form ****************************
        if($req->images != null){
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

       

        User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Student Added Successfully' 
        ], 201);
}



***************************************** Edit Modal **********************************************************************

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


***************************************** Edit Modal Script **************************************************************
<script>
    $(document).ready(function() {
        // Use a dynamic selector for each form submission
        $('[id^="submit_user_"]').click(function(e) {
            e.preventDefault();
            let formId = $(this).attr('id').replace('submit_user_', '');
            let form = $('#update_user_' + formId)[0];
            let data = new FormData(form);
           
            $.ajax({
                url: "/user-update", // Ensure this URL matches your route
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
                        console.log(response);
                        $('[id^="close"]').trigger('click'); // Close the modal
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#dataTable').load(location.href + " #dataTable");
                        form.reset();
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
    });
</script>



*************************************** Controller Side Code To Edit ************************************************************
public function userUpdate(Request $req){
        // dd($req->all());
        $user = User::findOrFail($req->user_id);

        $rules = [
            'name' => 'required|string',
            'mobile_no' => 'required|digits:10',
            'email' => 'required|email',
            'gender' => 'required', 
            'hobby' => 'required', 
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
            'gender'   => $req->gender,
            'hobby'    => json_encode($req->hobby),
        ];

        if($request->profile_photo != null){
         
            $file = $request->profile_photo;
            $filename = time(). '.' . $file->getClientOriginalExtension();
            $year = now()->year;
            $month = now()->format('M');
            $folderPath = public_path("users/{$year}/{$month}");
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);  
            }
            $file->move($folderPath, $filename);
            $data['profile_photo'] = "users/{$year}/{$month}/" . $filename;
        }

        if($user->email != $req->email){
            $rules = [
                'email' => 'unique:users,email'
            ];

            
            $validator = Validator::make($req->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data['email'] = $req->email;

        }

        if($user->mobile_no != $req->mobile_no){
            $rules = [
                'mobile_no' => 'unique:users,mobile_no'
            ];

            
            $validator = Validator::make($req->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data['mobile_no'] = $req->mobile_no;

        }

       
        if($user){
            $user->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Student Added Successfully' 
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Something Wrong!' 
            ], 422);

        }

       
}





