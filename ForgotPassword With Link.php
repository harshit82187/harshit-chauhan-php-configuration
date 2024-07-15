******************************* Forgot Password With Link **********************************************


1. Create A PasswordForgotController
    App\Http\Controllers\Auth\PasswordForgotController


2. Create a Table In Database Whose Name Is -> password_resets

fields name is:-

id      autoincrement
email	varchar 255
token	varchar 255
created_at		timestrap
updated_at		timestrap



3. Add Routes in PasswordForgotController

Route::controller(ForgotPasswordController::class)->group(function (){
    Route::get('/forgetPassword', 'showForgetPasswordForm')->name('forgetPassword');
    Route::post('/forgetPassword', 'submitForgetPasswordForm')->name('postforgetPassword');
    Route::get('/resetPassword/{token}/{email}', 'showResetPasswordForm')->name('resetPassword');
    Route::post('resetPassword', 'submitResetPasswordForm')->name('postresetPassword');
});



4. Here IS PasswordForgotController Side Code.

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\Admin; 
use Mail; 
use Hash;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    

     /**
       * Write code on Method
       *
       * @return response()
       */

       public function showForgetPasswordForm()
       { 
          return view('admin.auth.forgetPassword');
       }

         /**

       * Write code on Method
       *
       * @return response()
       */

       public function submitForgetPasswordForm(Request $request){
        try{

          $request->validate([
            'email' => 'required|email|exists:admins',
          ],[
            'email|exists' => 'This Email Id Is Not Exist',
          ]);

          $token = Str::random(64);
          $email = $request->email;

          

          DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
          ]);

         


          Mail::send('admin.email.forgetPassword', ['token' => $token, 'email' => $email], 
          function($message) use($request, $email){
            $message->to($email);
            $message->subject('Reset Password');

          });

          return back()->with('success', 'We have e-mailed your password reset link!');

        }catch(\Exception $e){
          return back()->with('error','Warning : ' .$e->getMessage());
        }

       }

       /**
       * Write code on Method
       *
       * @return response()
       */

       public function showResetPasswordForm($token, $email){

          // Check if there's an existing valid token for the email
          $existingToken = DB::table('password_resets')
              ->where('email', $email)
              ->where('created_at', '>=', now()->subMinutes(10))  // Token Is Expire In 20 Minutes
              ->first();

              // dd($existingToken);

              if(!$existingToken){
                return redirect()->route('forgetPassword')->with('error', 'Password Token Expired');
              }

              return view('admin.email.forgetPasswordLink', ['token' => $token , 'email' => $email]);

       }


       /**
       * Write code on Method
       *
       * @return response()
       */

       public function submitResetPasswordForm(Request $request){
              // dd($request->all());

              $request->validate([
                'email' => 'required|email|exists:admins',
                'password' => 'required',
                'cpassword' => 'required'
              ]);

              $updatePassword = DB::table('password_resets')->where([
                'email' => $request->email,
                'token' => $request->token,
              ])->first();

              if(!$updatePassword){
                return back()->with('error','Invalid Token');
              }

              $admin = Admin::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
              ]);

              DB::table('password_resets')->where('email', $request->email)->delete();

              return redirect()->route('admin.login')->with('success','Your Password Has Been Changed');

       }

}



5. Create ForgotPassword Blade file.
   in resources/view/admin/auth/forgetPassword

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <title>Password Reset</title>
  <style>
    .admin-login.main_content {
      padding-left: unset;
      padding-bottom: unset;
    }


    .main_content .main_content_iner {
      transition: .5s;
      margin: 20px 30px 30px;
    }

    .main_content {
      padding-left: 270px;
      width: 100%;
      padding-top: 0 !important;
      transition: .5s;
      position: relative;
      min-height: 100vh;
      padding-bottom: 90px;
      overflow: hidden;
    }

    .admin-login {
      display: grid;
      align-items: center;
    }

    .cs_modal {
      background-color: #fef1f2;
    }

    .modal-content {
      position: relative;
      display: flex;
      flex-direction: column;
      width: 100%;
      pointer-events: auto;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, .2);
      border-radius: 0.3rem;
      outline: 0;
    }

    .admin-login .modal-content .modal-header {
      flex-direction: column;
    }

    .cs_modal .modal-header {
      background-color: #D97D77;
      padding: 23px 30px;
      border-bottom: 0 solid transparent;
      align-items: center;
    }

    .cs_modal .modal-body {
      padding: 35px 30px !important;
      background: #fff;
      border-radius: 5px;
    }

    .admin-login .modal-content .modal-header img {
      width: 150px;
      margin-bottom: 5px;
    }

    .cs_modal .modal-header h5 {
      font-size: 22px;
      color: white;
      font-weight: 600;
    }

    .form-control:focus {
      border-color: #d97d77 !important;
      box-shadow: unset;
    }

    .main_content.dashboard_part .btn_1.full_width {
      height: 50px !important;
      background-color: #D97D77 !important;
      color: #fff !important;
      line-height: unset !important;
    }

    .cs_modal .modal-body .btn_1 {
      width: 100%;
      display: block;
      margin-top: 20px;
    }

    .cs_modal .modal-body input,
    .cs_modal .modal-body .nice_Select {
      height: 50px;
      padding: 10px 20px;
      border: 1px solid #f1f3f5;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 21px;
    }

    .AccSign a {
      color: #D97D77;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="admin-login main_content dashboard_part">
    <div class="main_content_iner">
      <div class="container-fluid p-0">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row justify-content-center">
              <div class="col-lg-4">
                <div class="modal-content cs_modal">
                  <div class="modal-header justify-content-center">
                    <img src="https://test.pearl-developer.com/indra/public/asset/Resources/img/(L)Rainbow+WhiteLogo+WhiteText.svg" alt="V-Run">
                  </div>

                  <div class="modal-body">
                    <form action="{{ route('postforgetPassword') }}" method="post">
                      @csrf

                      <div class="">
                        <input type="text" name="email" class="form-control" placeholder="Enter your email" required>
                      </div>

                      <input type="submit" class="btn_1 full_width text-center" value="Sent Password Reset Link">

                    </form>


                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  @if (Session::has('success'))
  <script>
    iziToast.success({
      //title: 'Success',
      message: "{{ Session::get('success') }}",
      position: 'topRight',
      timeout: 4000,
      displayMode: 0,
      color: 'green',
      theme: 'light',
      messageColor: 'black',
    });
  </script>
  @elseif (Session::has('error'))
  <script>
    iziToast.warning({
      //title: 'Success',
      message: "{{ Session::get('error') }}",
      position: 'topRight',
      timeout: 4000,
      displayMode: 0,
      color: 'red',
      theme: 'light',
      messageColor: 'black',
    });
  </script>
  @endif
</body>

</html>





6. Create EmailTemplate blade file.
         in resources/view/admin/email/forgetPassword

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400;500;600;700;800;900&display=swap');


        * {
            font-family: 'Jost', sans-serif;
        }
    </style>

</head>

<body>
    <table style="width:600px;margin:20px auto;border:1px solid #ccc;padding:20px 20px 35px; ">

        <tbody>



            <tr>
                <td>
                    <h3 style="font-size: 24px; text-align: center; text-transform: uppercase;">Password Reset</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="color: gray; font-weight: 400; font-size: 14px; text-align: center;">Seems like you forgot your password for login. if
                        this is true, click below to reset your password</p>

                </td>
            </tr>

            <tr>
                <td>
                    <div style="text-align: center;">
                        <a href="{{ route('resetPassword', [$token, $email]) }}" style="margin-top: 5px; background-color: green;  font-weight: 700; color: white; border: none; padding: 12px; border-radius: 4px; font-size: 14px; display: inline-block; text-decoration: none;">Reset
                            My Password</a>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <p style="color: gray; font-weight: 400; font-size: 14px; text-align: center;">if you did not forgot your passowrd you can safely ignore this email</p>

                </td>
            </tr>



        </tbody>
    </table>
</body>

</html>



7. Create Password and confirmPassword blade file.
         in resources/view/admin/auth/forgetPasswordLink

         <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
  <title>Password Reset</title>
  <style>
    .admin-login.main_content {
      padding-left: unset;
      padding-bottom: unset;
    }


    .main_content .main_content_iner {
      transition: .5s;
      margin: 20px 30px 30px;
    }

    .main_content {
      padding-left: 270px;
      width: 100%;
      padding-top: 0 !important;
      transition: .5s;
      position: relative;
      min-height: 100vh;
      padding-bottom: 90px;
      overflow: hidden;
    }

    .admin-login {
      display: grid;
      align-items: center;
    }

    .cs_modal {
      background-color: #fef1f2;
    }

    .modal-content {
      position: relative;
      display: flex;
      flex-direction: column;
      width: 100%;
      pointer-events: auto;
      background-color: #fff;
      background-clip: padding-box;
      border: 1px solid rgba(0, 0, 0, .2);
      border-radius: 0.3rem;
      outline: 0;
    }

    .admin-login .modal-content .modal-header {
      flex-direction: column;
    }

    .cs_modal .modal-header {
      background-color: #D97D77;
      padding: 23px 30px;
      border-bottom: 0 solid transparent;
      align-items: center;
    }

    .cs_modal .modal-body {
      padding: 35px 30px !important;
      background: #fff;
      border-radius: 5px;
    }

    .admin-login .modal-content .modal-header img {
      width: 150px;
      margin-bottom: 5px;
    }

    .cs_modal .modal-header h5 {
      font-size: 22px;
      color: white;
      font-weight: 600;
    }

    .form-control:focus {
      border-color: #d97d77 !important;
      box-shadow: unset;
    }

    .main_content.dashboard_part .btn_1.full_width {
      height: 50px !important;
      background-color: #D97D77 !important;
      color: #fff !important;
      line-height: unset !important;
    }

    .cs_modal .modal-body .btn_1 {
      width: 100%;
      display: block;
      margin-top: 20px;
    }

    .cs_modal .modal-body input,
    .cs_modal .modal-body .nice_Select {
      height: 50px;
      padding: 10px 20px;
      border: 1px solid #f1f3f5;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 21px;
    }

    .AccSign a {
      color: #D97D77;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="admin-login main_content dashboard_part">
    <div class="main_content_iner">
      <div class="container-fluid p-0">
        <div class="row justify-content-center">
          <div class="col-lg-12">
            <div class="row justify-content-center">
              <div class="col-lg-4">
                <div class="modal-content cs_modal">
                  <div class="modal-header justify-content-center">
                    <img src="https://test.pearl-developer.com/indra/public/asset/Resources/img/(L)Rainbow+WhiteLogo+WhiteText.svg" alt="V-Run">
                  </div>

                  <div class="modal-body">
                    <form action="{{ route('postresetPassword') }}" method="post">
                      @csrf
                      <input type="hidden" name="token" value="{{ $token }}">

                      <div class="">
                        <input type="text" name="email" class="form-control" value="{{ $email }}" required readonly>
                      </div>

                      <div class="">
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" 
                         autocomplete="one-time-code" autofocus required>
                      </div>

                      <div class="">
                        <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Enter your Confirm Password" autocomplete="one-time-code" autofocus required>                       
                      </div>

                      <input type="submit" class="btn_1 full_width text-center" value="Reset Password">

                    </form>


                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
  @if (Session::has('success'))
  <script>
    iziToast.success({
      //title: 'Success',
      message: "{{ Session::get('success') }}",
      position: 'topRight',
      timeout: 4000,
      displayMode: 0,
      color: 'green',
      theme: 'light',
      messageColor: 'black',
    });
  </script>
  @elseif (Session::has('error'))
  <script>
    iziToast.warning({
      //title: 'Success',
      message: "{{ Session::get('error') }}",
      position: 'topRight',
      timeout: 4000,
      displayMode: 0,
      color: 'red',
      theme: 'light',
      messageColor: 'black',
    });
  </script>
  @endif
</body>

</html>














/////////////////// Add Task ///////////////////////////////////
1. Create Forgot PAssword Blade File.
2. Create ForgotPassword Controller In Auth Folder.
3. Add Neccasarry Route In Web File.
4. Import Hash,Mail,Db Class In ForgetPasswordController.
5. If User Enter Wrong Email Address And Move Submit Button It Raise An Error The Selected Email Is Invalid.
6. If USer Enter Valid Email-id, A Password Reset Link Is Sent His Email-id.
7. User Click This Password Reset Link It Show a Forgot Password Foam And Fill Password And Confirm PAssword Fields And Submit The foam.
8. His Password Change SucessFully Without Any Error.
9. In This token User Can Change Only one Time Change The Password, If Changes After Sometime the password It Raise an Error- Invalid Token
10. If the user sent the password reset link to his email and does not change the password within 10 minutes, the link will expire.
12 If the user enters an wrong confirm password it will generate an error - 'Your Password Do Not Match' and will also disable the Submit button, until the user enters the correct password:












////////////////// Add Password And Confirm PAssword Fields ////////////////////////////

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        let password = $("#password");
        let cpassword = $("#cpassword");
        var button = $('#submit_button');
        
        cpassword.on('input', function(){
            if(password.val() != cpassword.val()){
                $('#password_error').text("Password Do Not Match");
                button.prop('disabled', true);
            } else {
                $('#password_error').text("");
                button.prop('disabled', false);
            }
        });
    });
</script>






MAIL_MAILER=smtp
MAIL_HOST=eskayinvestments.in
MAIL_PORT=465
MAIL_USERNAME=development@eskayinvestments.in
MAIL_PASSWORD="development@1230"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="development@eskayinvestments.in"
MAIL_FROM_NAME="${APP_NAME}"



MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@asianbloom.com
MAIL_PASSWORD="Asianbloom@123"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@asianbloom.com"
MAIL_FROM_NAME="${APP_NAME}"


MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@bharatnews360tv.com
MAIL_PASSWORD=Info@12390
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=info@bharatnews360tv.com
MAIL_FROM_NAME="${APP_WEB}"

