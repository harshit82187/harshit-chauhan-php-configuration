
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
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@test.pearl-developer.com
MAIL_PASSWORD="SMTP@Hostinger#123"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@test.pearl-developer.com"
MAIL_FROM_NAME="${APP_NAME}"

MAIL_MAILER=smtp
MAIL_HOST=mail.devs.pearl-developer.com
MAIL_PORT=587
MAIL_USERNAME=laravel@devs.pearl-developer.com
MAIL_PASSWORD=Laravel@12390
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=laravel@devs.pearl-developer.com
MAIL_FROM_NAME="${APP_NAME}"

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=harshitk@pearlorganisation.com
MAIL_PASSWORD=yfmlhtrjyafvoawm
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=harshitk@pearlorganisation.com
MAIL_FROM_NAME="${APP_NAME}"




MAIL_MAILER=smtp
MAIL_HOST=eskayinvestments.in
MAIL_PORT=465
MAIL_USERNAME=info@eskayinvestments.in
MAIL_PASSWORD="Infoemail@12390"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@eskayinvestments.in"
MAIL_FROM_NAME="${APP_NAME}"

MAIL_MAILER=smtp
MAIL_HOST=smtpout.secureserver.net
MAIL_PORT=465
MAIL_USERNAME=contact@panutility.com
MAIL_PASSWORD="SIPun0000@"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="contact@panutility.com"  # This should be a valid email address
MAIL_FROM_NAME="${APP_NAME}"


MAIL_MAILER=smtp
MAIL_HOST=mail.collegeforum.in
MAIL_PORT=465
MAIL_USERNAME=contact@collegeforum.in
MAIL_PASSWORD="?[6_[ibHMVVutpExg4"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=contact@collegeforum.in
MAIL_FROM_NAME="${APP_NAME}"


******************* ********************************* Controller Side Code ****************************************************** **************



use Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

public function saveContactus(Request $req)
    {
        // dd($req->all());
        try{
            $req->validate([
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required|digits:10',
                'subject' => 'required',
            ]);

            $data = [
                'name'  => $req->name,
                'email'  => $req->email,
                'mobile'  => $req->mobile,
                'subject'  => $req->subject,               
            ];

            if($req->emailNotification == 'on'){
                $data['emailNotification'] = 'on';
            }

            if($req->whatsappNotification == 'on'){
                $data['whatsappNotification'] = 'on';
            }     
    
            Contact::create($data);
            $subject = 'Subscribe Mail';
			$email = $req->email;

            try {
                Mail::send('mail.contact-us', ['data' => $data], function($message) use ($subject, $email) {
                    $message->to($email);
                    $message->subject($subject);
                });
    
                \Log::info('Success to send email to ' . $email);
    
                return redirect()->back()->with('success', 'Your query sent successfully');
            } catch (\Exception $mailException) {
                \Log::error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                return redirect()->back()->with('error', 'Sorry! We could not send the email. Please try again later');
            }


            return redirect()->back()->with('success','Your query send successfully');

        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());
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



