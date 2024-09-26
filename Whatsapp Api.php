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
