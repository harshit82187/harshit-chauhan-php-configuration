use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


public function sendWhatsappMessage(Request $req){
        // dd($req->all());

        $req->validate([
            'student_name' => 'required|string',
            'student_mobile_no' => 'required|string',
            'message' => 'required|string',
        ]);

        $studentName = $req->input('student_name');
        $studentMobileNo = $req->input('student_mobile_no');
        $message = $req->input('message');

      

        if (!str_starts_with($studentMobileNo, '+91')) {
            $studentMobileNo = '+91' . $studentMobileNo;
        }
        $apiKey = 'EfJ3kJdXG6cz'; 
        $whatsappApiUrl = 'http://api.textmebot.com/send.php';



        $response = Http::get($whatsappApiUrl, [
            'recipient' => $studentMobileNo,
            'apikey' => $apiKey,
            'text' => $message
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'WhatsApp message sent successfully!'
            ], 200);
        } else {
            return response()->json([
                'errors' => ['message' => 'Failed to send WhatsApp message.']
            ], 500);
        }

    }

















************************************************** When you senf pdf or image with message *****************************************************************************
 public function sendWhatsappMessage(Request $req){
        // dd($req->all());

        $req->validate([
            'college_id'   => 'required|numeric',
            'student_id'   => 'required|string',
            'user_id'      => 'required|numeric',
            'student_name' => 'required|string',
            'student_mobile_no' => 'required|string',
            'message' => 'required|string',
            'attachment' => 'file|max:2048',

        ]);

        $studentName = $req->input('student_name');
        $studentMobileNo = $req->input('student_mobile_no');
        $message = "Hello " . $studentName . ",\n" . $req->input('message');
      

        if (!str_starts_with($studentMobileNo, '+91')) {
            $studentMobileNo = '+91' . $studentMobileNo;
        }
        $apiKey = 'EfJ3kJdXG6cz'; 
        $whatsappApiUrl = 'http://api.textmebot.com/send.php';

        $data = [
            'user_id' => $req->user_id,
            'student_id' => $req->student_id,
            'college_id' => $req->college_id,
            'message'    => $req->message,
        ];

        if($req->hasFile('attachment')){
            $file = $req->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('college-conversation/' . $filename);
            $file->move(public_path('college-conversation'),$filename);
            // dd($filePath);
            $data['attachment'] = $filename;
            

            if ($extension === 'pdf') {

                $response = Http::get($whatsappApiUrl, [
                    'recipient' => $studentMobileNo,
                    'apikey' => $apiKey,
                    'text' => $message,
                    'document' => $filePath,
                ]);

            }elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $response = Http::get($whatsappApiUrl, [
                    'recipient' => $studentMobileNo,
                    'apikey' => $apiKey,
                    'text' => $message,
                    'file' => $filePath,
                ]);
               
            }
        }

        $response = Http::get($whatsappApiUrl, [
            'recipient' => $studentMobileNo,
            'apikey' => $apiKey,
            'text' => $message,
        ]);

        WhatsappConversation::create($data);
        

        if ($response->successful()) {
            return response()->json([
                'message' => 'WhatsApp message sent successfully!'
            ], 200);
        } else {
            return response()->json([
                'errors' => ['message' => 'Failed to send WhatsApp message.']
            ], 500);
        }

    }
