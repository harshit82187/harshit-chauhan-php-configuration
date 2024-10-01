/////////////////////////////////////////////////////////// Create Custom Log Channel////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

*******************config/logging.php**************************

'channels' => [
    // Existing channels...

    'email' => [
        'driver' => 'single',
        'path' => storage_path('logs/email.log'), // Custom log file for email logs
        'level' => 'info', // You can change this to any level: debug, info, error, etc.
    ],
],





******************** controllser side code **********************

   public function sendEmailMessage(Request $req){
        // dd($req->all());
        try{

            $req->validate([
                'student_email' => 'required|string',
                'message' => 'required|string',
                'subject' => 'required|string',

            ]);

            $email = $req->student_email;
            $subject = $req->subject;
            $message = $req->message;

            try {
                Mail::send('mail.student-mail', ['message' => $message], function($message) use ($subject, $email) {
                    $message->to($email);
                    $message->subject($subject);
                });
    
                Log::channel('email')->info('Email sent successfully to ' . $email);
    
                return response()->json([
                    'message' => 'Email Sent Successfully!'
                ], 200);
            } catch (\Exception $mailException) {
                Log::channel('email')->error('Failed to send email to ' . $email . '. Error: ' . $mailException->getMessage());
                return response()->json([
                    'message' => $mailException->getMessage()
                ], 500);   
            }



        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
