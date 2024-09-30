************************************* app\Helpers\helpers.php ***************************************************


<?php

if (!function_exists('generateStudentId')) {
    function generateStudentId($name, $mobile_no)
    {
        // Combine name and mobile_no to form studentId
        $cleanedName = preg_replace('/\s+/', '', strtolower($name)); // Remove spaces and lowercase the name
        return $cleanedName . substr($mobile_no, -4); // Append the last 4 digits of mobile_no
    }
}




******************************** Controller Side Code  ********************************************************

    public function leadCollegeDetailSave(Request $req){
        // dd($req->all());
        $user = Auth::User();
        try{   
            $rules = [
                'name' => 'string|required',
                'mobile_no' => 'required',
                'email' => 'email|required',
                'student_country' => 'required|numeric',
                'student_state' => 'required|numeric',
                'student_city' => 'required|numeric',
                'course' => 'required|string',
                'lead_type' => 'required|string',

            ];

            $validator = Validator::make($req->all(), $rules);

            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Use the global helper function to generate studentId
            $studentId = generateStudentId($req->name, $req->mobile_no);


                $user = Auth::User();
                $data = [
                    'college_id'       => $user->college_id,
                    'user_id'          => $user->id,
                    'student_id'       => $studentId,
                    'name'             => $req->name,
                    'mobile_no'        => $req->mobile_no,
                    'email'            => $req->email,
                    'country'          => $req->student_country,
                    'state'            => $req->student_state,
                    'city'             => $req->student_city,
                    'course'           => $req->course,
                    'lead_type'        => $req->lead_type,

                    ];

            Lead::create($data);
            return response()->json([
                'success' => true,
                'message' => 'Lead Create Successfully!'
            ],201);

    }catch(\Exception $e){

            return response()->json([
                'success' => false,
                'Message' => $e->getMessage()
            ],500);
    }
    }
