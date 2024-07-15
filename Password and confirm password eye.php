
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

<style>
    .available {
        color: green;
    }

    .not_available {
        color: red;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">



<div class="form-group row form-div">
    <div>
        <label class="col-sm-3 control-label">Mobile No</label>
        <div>
            <input type="number" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" autofocus>
        </div>
        <div id="contact_error" style="color:red;"></div>
    </div>
</div>



<div class="form-group row form-div">
    <label for="" class="col-sm-3 control-label">Password</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required id="password">
            <span class="input-group-text">
                <i  class="fa fa-eye-slash" id="tooglePassword"></i>
            </span>
        </div>
    </div>
</div>

<div class="form-group row form-div">
    <label for="" class="col-sm-3 control-label">Confirm Password</label>
    <div class="col-sm-9">
        <div class="input-group">
            <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" autocomplete="off">
            <span class="input-group-text">
                <i class="fa fa-eye-slash" id="ctooglePassword"></i>
            </span>
        </div>
        <!-- ERROR CONTAINER FOR PASSWORD MISSMATCH -->
        <div id="password_error" style="color:red;"></div>
    </div>
</div>

<div class="form-group row">
    <div class="offset-sm-3 col-sm-9 login-btn">
        <button class="form-div-button" id="submit_button" type="submit">Register</button>
    </div>
</div>


************************** Add Script To See Password ********************************
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let password = document.getElementById("password");
    let tooglePassword = document.getElementById("tooglePassword");
    let cpassword = document.getElementById("cpassword");
    let ctooglePassword = document.getElementById("ctooglePassword");
    var button =  $('#submit_button');
    console.log(password);
    console.log(tooglePassword);

    tooglePassword.onclick = function() {
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }

        tooglePassword.classList.toggle('fa-eye-slash');
        tooglePassword.classList.toggle('fa-eye');
    }

    ctooglePassword.onclick = function() {
        // alert('hy');
        if (cpassword.type === "password") {
            cpassword.type = "text";
        } else {
            cpassword.type = "password";
        }
        ctooglePassword.classList.toggle('fa-eye-slash');
        ctooglePassword.classList.toggle('fa-eye');
    }

    cpassword.addEventListener('input', function() {
        if (password.value != cpassword.value) {
            password_error.textContent = "Password Do Not Match";
            button.prop('disabled', true);
        } else {
            password_error.textContent = "";
            button.prop('disabled', false);
        }
    });
</script>

********************** Add Keyup Search Functionality UserName In The Database ******************************


<script>
    $(document).ready(function(){
        console.log("Script is running");          
           
       $('#contact').on('keyup', function(){
           
           var contact = $('#contact').val();
           var button =  $('#submit_button');
           console.log(contact);
           
           var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           
           var dataToSend = {
               '_token' : csrfToken,
               contact : contact,
           };
           
           $.ajax({
              url : "{{ route('admin.checkContact') }}",
              method: 'POST',
              cache: false,
              data : dataToSend,
              success:function(response){
                  if(response.available){
                      $('#contact_error').text("");
                      button.prop('disabled', false);
                  }else{
                      $('#contact_error').text("Mobile No Is Already Exist");
                      button.prop('disabled', true);
                  }
                  
                  
                  
              },
              error:function(error){
                  console.error("Error sending data: " + error);
              }
               
           });
           
           
       }) ;
    });
</script>




//////////////////// Controller Side Code /////////////////////////////////////
public function checkUsernames(Request $request){
// dd($request->all());
$username = $request->username;
$user = User::where('username',$username)->first();

if($user){
return response()->json(['available'=>false]);
}
return response()->json(['available'=>true]);
}