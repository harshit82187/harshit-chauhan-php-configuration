
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
    $toEmail = 'recipient-email@example.com';
    $subject = 'Test Email';
    $body = 'This is a test email sent using raw content to check if email functionality is working.';

    Mail::raw($body, function ($message) use ($toEmail, $subject) {
        $message->to($toEmail)
                ->subject($subject);
    });

    return 'Raw test email sent successfully!';
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
    Route::get('send-mail-to-active-users', 'sendMailToActiveUsers')->name('send-mail-to-active-users');


Step :2 Controller Side Code

use App\Mail\MyCustomMail;
use Mail;
use App\Models\User;

public function sendMailToActiveUsers()
{
        try{
            $users = User::where('status', 1)->get();
            if ($users->isEmpty()) {
                return response()->json(['message' => 'No active users found.']);
            }
            // dd($users);
             Mail::to('harshitk@pearlorganisation.com')->queue(new MyCustomMail($users)); 
            return response()->json(['message' => 'Emails sent successfully to active users!']);
        }catch(\Exception $e){
            return response()->json(['message' => 'Error: ' . $e->getMessage()]);
        }
}



Step :3 app/Mail/MyCustomMail.php

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyCustomMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
                    ->subject('Important Notification')
                    ->view('email.web.custom-mail')
                    ->with('users', $this->users);
    }
}


