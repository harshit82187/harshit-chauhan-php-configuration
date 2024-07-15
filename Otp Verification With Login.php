******************************* Otp Verification With Login **********************************************


1. Create a Table In Database Whose Name Is -> user_otps

fields name is:-

id      autoincrement
email	varchar 255
token	varchar 255
otp   varchar 255
created_at		timestrap
updated_at		timestrap



2. Add Routes in FrontController

Route::get('otp-send',[FrontController::class, 'otp'])->name('otp');
Route::post('otp-send-email',[FrontController::class, 'otp_send'])->name('otp_send');
Route::get('otp-verify/{token}/{email}',[FrontController::class, 'otp_verify'])->name('otp_verify');
Route::post('otp-verifys',[FrontController::class, 'otp_verifys'])->name('otp_verifys');
Route::get('/resend-otp', [FrontController::class, 'resend_otp'])->name('resend_otp');

Route::get('/logout', [FrontController::class, 'logout'])->name('logout');


3. Here IS FrontController Side Code.

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


class FrontController extends Controller
{
    

        public function otp(){
          return view('front.otp-send');
      }

      public function otp_send(Request $request){
        // dd($request->all());
        try{
          $otp = mt_rand(100000, 999999);
          $token = Str::random(64);
          $data = [
            'email' => $request->email, 
            'otp'   => $otp,
            'token' => $token,
          ];
          $subject = 'Otp Verfication';
          $email = $request->email;

          
          DB::table('user_otps')->insert([
            'email' => $email,
            'token' => $token,
            'otp' => $otp,
            'created_at' => Carbon::now()
          ]);

          

          // Send email to the owner
          Mail::send('mail.otp_mail', $data, function($message) use($subject, $email) {
            $message->to($email);
            $message->subject($subject);
          });

          return redirect()->route('otp_verify', [$token, $email])->with('success','OTP Send Successfully Send Your Email');

        }catch(\Exception $e){
          return back()->with('error', 'Warning : ' .$e->getMessage());
        }		

      }


      public function otp_verify($token, $email){
        // dd("Reached otp_verify method");
        return view('front.otp-verify', ['token' => $token, 'email' => $email]);
      }

      public function otp_verifys(Request $request){
        // dd($request->all());
    
        try{
          $email = $request->email;
              $otp = $request->otp;
    
            // Retrieve the latest OTP from the database for the given email
          $record =  DB::table('user_otps')->where('email', $email)->latest()->first();
    
          // dd($record);
    
          if(!$record){
            return back()->with('error','Invalid OTP. Please Enter Right OTP');
          }
    
          $storeOtp = $record->otp;
          $createdAt = Carbon::parse($record->created_at);
    
          // Check if the OTP is still valid (e.g., within a certain time frame)
          $otpDuration = 5; // Set your desired validity duration in minutes
          if ($createdAt->addMinutes($otpDuration)->isPast()) {
            return back()->with('error', 'OTP has expired. Please request a new one.');
          }
    
          if($otp == $storeOtp){
            
            DB::table('user_otps')->where('email', $email)->delete();
            session(['user_email' => $email]);
            
    
            return redirect('/');
          }else{
            return back()->with('error', 'Invalid OTP. Please try again.');
          }
          
    
        }catch(\Exception $e){
          return back()->with('error', 'Warning : ' .$e->getMessage());
        }	
    
    
      }

      public function resend_otp(){
        // dd($request->all());
        try{
          $otp = mt_rand(100000, 999999);
          $token = Str::random(64);
          $email = session('user_email');
          // dd($email);
    
          $data = [
            'email' => $email, 
            'otp'   => $otp,
            'token' => $token,
          ];
          $subject = 'Otp Verfication';
          
    
          
          DB::table('user_otps')->insert([
            'email' => $email,
            'token' => $token,
            'otp' => $otp,
            'created_at' => Carbon::now()
          ]);
    
          
    
          // Send email to the owner
          Mail::send('mail.otp_mail', $data, function($message) use($subject, $email) {
            $message->to($email);
            $message->subject($subject);
          });
    
          return redirect()->route('otp_verify', [$token, $email])->with('success','OTP Again Send Successfully Your Email');
    
        }catch(\Exception $e){
          return back()->with('error', 'Warning : ' .$e->getMessage());
        }		
    
    
      }

      public function logout(){
        session()->forget('user_email');

        return redirect('/');
      }

}



4. Create otp-send Blade file.
   in resources/view/front/otp-send

   <!DOCTYPE html>
   <html lang="en">
   
   <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
     <title>Bharat News 360 Tv </title>
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
         background-color: #002765;
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
         background-color: #002765 !important;
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
                       <img src="http://bharatnews360tv.com/public/web-assets/img/news-logo-2.png" alt="logo">
                     </div>
   
                     <div class="modal-body">
                          
                       <form action="{{ route('otp_send') }}" method="post">
                         @csrf
   
                         <div class="">
                           <input type="text" name="email" class="form-control" placeholder="Enter your email" required>
                         </div>
   
                         <input type="submit" class="btn_1 full_width text-center" value="Sent Otp">
   
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





5. Create EmailTemplate for send otp blade file.
         in resources/view/mail/otp_mail
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
                             <p>Dear {{$email}},</p>
                             <h3>Your OTP for verification is: <strong>{{ $otp }}</strong></h3>
                             <p>Thank you for using our service!</p>
                         </td>
                     </tr>
         
                     <!-- <tr>
                         <td>
                             <p style="color: gray; font-weight: 400; font-size: 14px; text-align: center;">Seems like you forgot your password for login. if
                                 this is true, click below to reset your password</p>
         
                         </td>
                     </tr> -->
         
                    
         
                     <!-- <tr>
                         <td>
                             <p style="color: gray; font-weight: 400; font-size: 14px; text-align: center;">if you did not forgot your passowrd you can safely ignore this email</p>
         
                         </td>
                     </tr> -->
         
                     <tr>
               <td
                 align="center"
                 valign="top"
                 style="padding: 20px 0px 18px; font-size: 16px"
                 >
                 <span
                   style="
                   font-weight: 600;
                   color: black;
                   display: block;
                   font-family: Calibri;
                   "
                   >
                 Follow us and write us by</span
                   >
               </td>
             </tr>
         
         
             <tr>
               <td align="center" valign="top">
                 <ul
                   style="
                   margin: 0px;
                   list-style-type: none;
                   padding: 0;
                   display: inline-flex;
                   "
                   >
                             
                 
                   <li style="margin: 0 7px">
         
                                  <a class="btn btn-outline-secondary border-light text-center mr-2 px-0" style="width: 38px; height: 38px; color:#fff;" href="#"><i class="fab fa-twitter"></i>
                                    <img src="{{ asset('') }}">
                                 </a>
                   </li>
                   
                   <li style="margin: 0 7px">
                                  <a class="btn btn-outline-secondary border-light text-center mr-2 px-0" style="width: 38px; height: 38px; color:#fff;" href="#"><i class="fab fa-facebook-f"></i></a>
                   </li>
         
                   <li style="margin: 0 7px">
                                  <a class="btn btn-outline-secondary border-light text-center mr-2 px-0" style="width: 38px; height: 38px; color:#fff;" href="#"><i class="fab fa-linkedin-in"></i></a>
                   </li>
         
                   <li style="margin: 0 7px">
                                  <a class="btn btn-outline-secondary border-light text-center mr-2 px-0" style="width: 38px; height: 38px; color:#fff;" href="#"><i class="fab fa-instagram"></i></a>
                   </li>
         
                             <li style="margin: 0 7px">
                                   <a class="btn btn-outline-secondary border-light text-center mr-2 px-0" style="width: 38px; height: 38px; color:#fff;" href="#"><i class="fab fa-youtube"></i></a>
                   </li>
         
         
                   
                 </ul>
               </td>
             </tr>
         
         
             <tr>
               <td
                 align="center"
                 valign="top"
                 style="padding: 0px 0px 10px; font-size: 16px"
                 >
                 <p style="color: black; margin: 0px; font-family: calibri">
                         Copyright © <?php echo date("Y"); ?> by <a href="https://bharatnews360tv.com/" class="text-muted" target="_blank">Bharat News 360 TV</a>. All rights reserved.
                 </p>
               </td>
             </tr>
         
         
             <tr>
               <td align="center" valign="top" style="font-size: 15px">
                 <div style="text-align: center; color: #c80000 !important">
                   <a
                     style="
                     text-decoration: none;
                     display: inline-block;
                     color: #c80000 !important;
                     font-size: 12px;
                     font-weight: 700;
                     "
                     >
                   Contact Us
                   </a>
                   <span style="color: black; padding: 0px 1px">|</span>
                   <a
                     style="
                     text-decoration: none;
                     display: inline-block;
                     color: #c80000;
                     font-size: 12px;
                     font-weight: 700;
                     "
                     >
                   Privacy policies
                   </a>
                   <span style="color: black; padding: 0px 1px">|</span>
                   <a
                     style="
                     text-decoration: none;
                     display: inline-block;
                     color: #c80000;
                     font-size: 12px;
                     font-weight: 700;
                     "
                     >
                   Terms and Conditions
                   </a>
                 </div>
               </td>
             </tr>
         
         
         
                 </tbody>
             </table>
         </body>
         
         </html>



6. Create otp-verify blade file.
    in resources/view/front/otp-verify

    <!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
      <title>Bharat News 360 Tv </title>
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
          background-color: #002765;
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
          background-color: #002765 !important;
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
                        <img src="http://bharatnews360tv.com/public/web-assets/img/news-logo-2.png" alt="logo">
                      </div>
    
                      <div class="modal-body">
    
                          
                        <form action="{{ route('otp_verifys') }}" method="post">
                          @csrf
                          <input type="hidden" name="token" value="{{ $token }}">
                          <input type="hidden" name="email" value="{{ $email }}">
    
                          <div class="">
                            <input type="text" name="otp" class="form-control" placeholder="Enter your otp" maxlength="6" required>
                          </div>
    
                          <input type="submit" class="btn_1 full_width text-center" value="Verify Otp">

                          <a href="{{ url('logout') }}" class="btn_1 full_width text-center home-btn" style="width: 116px; margin-left:1px; text-decoration: none; height: 28px !important;">Back To Home</a>

                          <a href="{{ route('resend_otp') }}" class="btn_1 full_width text-center home-btn" style="width: 116px; margin-left:235px; margin-top:-29px; text-decoration: none; height: 28px !important;">Resend OTP</a>
        
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