
*************************** Create Email Template In Resouce Folder*************************
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Form Submission</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #ffffff; box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.02), 0px 0px 0px 1px rgba(27, 31, 35, 0.15);">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <th colspan="2">
                    <img style="width: 100%;" src="https://test.pearl-developer.com/neo-infra/public/assets/images/logo.png" alt="">
                </th>
            </tr>
            <tr>
                <th colspan="2">
                    <h2 style="text-align: center; color: #333;">Enquiry Form Submission</h2>
                </th>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>Name:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['name']  ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>Email:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['email']  ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>Mobile:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['mobile']  ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>Subject:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['subject']  ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>Email Notifications:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['emailNotification']  ?? '' }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;"><strong>WhatsApp Notifications:</strong></td>
                <td style="padding: 10px 0; border-bottom: 1px solid #ddd;">{{ $data['whatsappNotification']  ?? '' }}</td>
            </tr>
        </table>
        <div style="margin-top: 20px; padding: 10px; background-color: #e9ecef; border-left: 6px solid #17a2b8;">
            <p style="margin: 0; color: #333;">We are not sharing your data with any agency.</p>
        </div>
    </div>
</body>

</html>





********************* Changes In .env File ************************




MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=harshitk@pearlorganisation.com
MAIL_PASSWORD=yfmlhtrjyafvoawm
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=harshitk@pearlorganisation.com
MAIL_FROM_NAME="${APP_NAME}"


MAIL_MAILER=smtp
MAIL_HOST=mail.tabsaccol.com.np
MAIL_PORT=465
MAIL_USERNAME=admin@tabsaccol.com.np
MAIL_PASSWORD="Admin@12390"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="admin@tabsaccol.com.np"  
MAIL_FROM_NAME="${APP_NAME}"


MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info_new@test.pearl-developer.com
MAIL_PASSWORD=Info@12390
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info_new@test.pearl-developer.com
MAIL_FROM_NAME="${APP_NAME}"


MAIL_MAILER=smtp
MAIL_HOST=mail.collegeforum.in
MAIL_PORT=465
MAIL_USERNAME=contact@collegeforum.in
MAIL_PASSWORD="?[6_[ibHMVVutpExg4"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=contact@collegeforum.in
MAIL_FROM_NAME="${APP_NAME}"

Route::get('/test-raw-mail', function () {
    $toEmail = 'harshitk@pearlorganisation.com';
    $subject = 'Test Email';
    $body = 'This is a test email sent using raw content to check if email functionality is working.';
    try {
        Mail::raw($body, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)
                    ->subject($subject);
        });
        Log::channel('email')->info('Test email sent successfully.', ['to' => $toEmail, 'subject' => $subject]);
        return response()->json(['message' => 'Raw test email sent successfully!'], 200);
    } catch (\Exception $e) {
        Log::channel('email')->error('Failed to send test email.', ['error' => $e->getMessage(), 'to' => $toEmail]);
        return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], 500);
    }
});


******************* ********************************* Controller Side Code ****************************************************** **************



use Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

 public function ticketAdd(Request $req){
        if($req->isMethod('get')){
            return view('backend.vendor.ticket.add');
        }else{
            // dd($req->all());
            $req->validate([
                'subject' => 'required|string',
                'description' => 'required|string',
            ]);
            $vendor_id = Auth::guard('vendor')->user()->id;
            $yearMonth = Carbon::now()->format('Ym');
            $today     = Carbon::now()->format('d-M-Y');
            $randomNumber = rand(100000, 999999);
            $data = [
                'ticket_no' => $yearMonth . $randomNumber,
                'subject' => $req->subject,
                'description' => $req->description,
                'vendor_id' => $vendor_id,
            ];
            if($req->attachment != null){
                $file = $req->attachment;
                $filename = time(). '.' . $file->getClientOriginalExtension();
                $year = now()->year;
                $month = now()->format('M');
                $folderPath = public_path("tickets/{$year}/{$month}");
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);  
                }
                $file->move($folderPath, $filename);
                $data['attachment'] = "tickets/{$year}/{$month}/" . $filename;
            }
            $ticket = Ticket::create($data);
            $subject = 'Ticket Notification';
            $adminEmail = View::shared('adminEmail');
            $vendorEmail = Auth::guard('vendor')->user()->email ?? null;
            try {
                Mail::send('mails.ticket.ticket-notification', ['ticket' => $ticket, 'adminEmail' => $adminEmail, 'vendorEmail' => $vendorEmail], function ($message) use ($subject, $adminEmail, $vendorEmail) {
                    $message->to($adminEmail); 
                    $message->bcc($vendorEmail); 
                    $message->subject($subject);
                });
                \Log::info('Success to send email to ' . $adminEmail .' ' . $vendorEmail);
            } catch (\Exception $mailException) {
                \Log::error('Failed to send email to ' . $adminEmail . '. Error: ' . $mailException->getMessage());
            }
            return redirect(route('vendor.ticket.list'))->with('success', 'Ticket added successfully!');

            
        }
    }


   public function sendMail(Request $request){
        // dd($request->all());
        $user = auth()->user();
        $certificate = Certificate::where('project_id', $request->project_id)->where('id',$request->document_id)->first();
        if(!$certificate){
            flash('Certificate Entry Not Found')->error();
            return back();
        }
        // dd($certificate->projectInfo->leadInfo->email);
        $subject = "Certificate Notification  " . $certificate->projectInfo->name . " | " . \Carbon\Carbon::today()->format('d-M-Y') . " | " . \Carbon\Carbon::now()->format('h:i A');
        $adminEmail = View::shared('adminEmail');  // BussinessSetting::where('type','email')->value('value')
        $toEmail = $certificate->projectInfo->leadInfo->email;
        try {
            Mail::send('emails.certificate.text', ['certificate' => $certificate,'user' => $user], function ($message) use ($certificate,$subject, $adminEmail, $toEmail) {
                $message->to($toEmail); 
                $message->cc($adminEmail); 
                $message->subject($subject);
                $filePath = public_path($certificate->file_path);
                if (file_exists($filePath)) {
                    $message->attach($filePath);
                }
            });
            \Log::info('Success to send email to ' . $adminEmail .' ' . $toEmail);
         } catch (\Exception $mailException) {
            \Log::channel('email')->error('Failed to send email to ' . $adminEmail . '. Error: ' . $mailException->getMessage());
            return back();
        }
    }





**************************************************** Send MAil In Coer Php *****************************************************************************



  try {
                $to = $request->email;  // Receiver's email address
                $subject = 'Verify Your Company Email';              
                $verificationUrl = route('company.verify', ['token' => $token, 'email' => $to]); // Use the generated token
                
                // Email content
                $message = "
                <html>
                <head>
                    <title>Email Verification</title>
                </head>
                <body style='font-family: Arial, sans-serif; background-color: #f8f9fa; color: #212529; margin: 0; padding: 0;'>
                    <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 0.25rem; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); padding: 2rem; border: 1px solid #dee2e6;'>
                        <div style='text-align: center; padding-bottom: 1.5rem;'>
                            <h1 style='margin: 0; font-size: 1.75rem; color: #343a40;'>Email Verification</h1>
                        </div>
                        <div style='padding-bottom: 1.5rem; font-size: 1rem; line-height: 1.5;'>
                            <p>Hello, {$request->name}</p>
                            <p>Thank you for registering your company with DSOM! We’re excited to welcome you to our network. <br>
                            To finalize your registration, please verify your email address by clicking the button below:

                            </p>
                        </div>
                        <div style='display: block; text-align: center; margin-top: 2rem;'>
                            <a href='{$verificationUrl}' target='_blank' style='display: inline-block; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 600; color: #ffffff; background-color: #007bff; border-color: #007bff; text-decoration: none; border-radius: 0.25rem;'>Verify Email Address</a>
                        </div>
                        <div style='text-align: center; margin-top: 2rem; font-size: 0.875rem; color: #6c757d;'>
                            <p>If you did not initiate this request, no action is required. <br> 
                            We look forward to a successful partnership and supporting your team with our digital marketing expertise.

                            </p>
                            <p>Best regards,<br>DSOM</p>
                        </div>
                    </div>
                </body>
                </html>";
            
                // Set headers
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: contact@dsom.in' . "\r\n";
            
                // Send the email
                if (mail($to, $subject, $message, $headers)) {
                   
                } else {
                    echo 'Error! Email could not be sent.';
                }
                
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage();
            }














********************************************************************************* Sending queue email in laravel *************************************************************************



Step :1 web.php file
        Route::post('get-in-touch', 'getInTouch')->name('get-in-touch');


Step :2 Controller Side Code

use Mail;
use App\Mail\GetInTouchMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;


 public function getInTouch(Request $req){
        // dd($req->all());
        $req->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|numeric',
            'message' => 'required|string',
        ]);
        $getInTouch = new GetInTouch();
        $getInTouch->name = $req->name;
        $getInTouch->email = $req->email;
        $getInTouch->mobile_no = $req->mobile_no;
        $getInTouch->message = $req->message;
        $getInTouch->save();
        $data = [
            'name' => $req->name,
            'email' => $req->email,
            'mobile_no' => $req->mobile_no,
            'message' => $req->message,
        ];
        $email = $req->email;
        try {
            Mail::to($email)->queue(new GetInTouchMail($data));
            Log::channel('email')->info('Success to send email to ' . $email);
        } catch (\Exception $mailException) {
            \Log::error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
        }

    
        return back()->with('success','We will get back to you soon!');

    }




Step :3 app/Mail/GetInTouchMail.php

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetInTouchMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('New Contact Inquiry')
                    ->view('email-template.customer.get-in-touch')
                    ->with('data', $this->data);
    }
}



Step 4 : get-in-touch blade file code

<!DOCTYPE html>
<html>
<head>
    <title>New Contact Inquiry</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            text-align: center; 
            padding: 30px; 
        }
        .card { 
            background: #fff; 
            max-width: 600px; 
            margin: auto; 
            padding: 20px; 
            border-radius: 12px; 
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15); 
            text-align: center;
        }
        .logo { 
            width: 120px; 
            margin-bottom: 15px; 
        }
        h2 { 
            color: #333; 
            margin-bottom: 15px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            border-radius: 8px;
            overflow: hidden;
        }
        th, td { 
            padding: 12px; 
            text-align: left; 
            border-bottom: 1px solid #ddd; 
        }
        th { 
            background: #000; 
            color: white; 
            text-transform: uppercase; 
        }
        tr:nth-child(even) { background: #f9f9f9; }
        tr:nth-child(odd) { background: #e3f2fd; }
        .footer { 
            margin-top: 20px; 
            font-size: 12px; 
            color: #666; 
        }
        .card-section{
			background: white;
			padding: 20px;
			box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
			border-radius: 14px;
		}
        .section-body{
            border: 1px solid #000;
            border-radius:4px;	
            padding: 10px;
            font-weight: 900;
            width: 102%;
		}
    </style>
</head>
<body>
    <div class="card">
        <div class="card-section">
            <div class="card-body section-body">
                <img src="{{ asset('front/images/logo/logo.png') }}" alt="Company Logo" class="logo">
                <h2>We will get back to you soon</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile No</th>
                        <th>Message</th>
                    </tr>
                    <tr>
                        <td>{{ $data['name'] ?? '' }}</td>
                        <td><a href="mailto:{{ $data['email'] }}" style="color: #000; text-decoration: none;">{{ $data['email'] ?? '' }}</a></td>
                        <td>{{ $data['mobile_no'] ?? '' }}</td>
                        <td>{{ $data['message'] ?? '' }}</td>
                    </tr>
                </table>
                <p class="footer">{{ date('Y') }} © All Rights Reserved. <i class="fa fa-heart heart text-danger"></i> By
                    <a href="{{ url('/') }}" target="_blank" style="color: #FF8000;">Makh Stay</a> & Powered By 
                    <a href="https://www.pearlorganisation.com/" target="_blank" style="color: #FF8000;">Pearl Organisation</a>
                </p>

            </div>
           
        </div>
        
    </div>
</body>
</html>



Step :5 js file code

$("#get-in-touch-email").on("keyup", function() {
		console.log("blur event fired");
        let email = $(this).val();
        let emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com|rediffmail\.com|pearlorganisation\.com)$/;

        if (email === "") {
			$('#get-in-touch-email-error').text('Email field cannot be empty.');
			$('#get-in-touch-submit').prop('disabled', true);
        } else if (!emailRegex.test(email)) {
			$('#get-in-touch-email-error').text('Please enter a valid email address');
			$('#get-in-touch-submit').prop('disabled', true);
        }else{
			$('#get-in-touch-email-error').text('');
			$('#get-in-touch-submit').prop('disabled', false);
		}
    });

	$("input[type='number'], .number").on("input", function () {
        this.value = this.value.replace(/[^0-9.]/g, ''); 
         if (this.value.length > 15) {
          this.value = this.value.slice(0, 15); 
      }
    });

	$(".alphabet").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, ''); 
    });

    $(document).on('submit', '#get-in-touch-form', function() {
        let btn = $('button[type="submit"]');
        btn.html('<span class="spinner-border spinner-border-sm"></span> Please Wait...')
            .prop('disabled', true);
    });
                            





