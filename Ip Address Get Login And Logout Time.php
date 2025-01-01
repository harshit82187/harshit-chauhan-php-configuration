/////////////////////////////////////////////////////////////////////////// Ip Address Get Login And Logout Time ////////////////////////////////////////////////////////////////////////////////////////////////////



************************************ login_details table schema *****************************************

Schema::create('log_details', function (Blueprint $table) {
    $table->id();
    $table->bigInteger('user_id')->unsigned();  
    $table->string('ip', 250);
    $table->enum('type', ['1', '2']);
    $table->timestamp('time')->nullable();
    $table->timestamps();
});






***************************************** Controller Side Code ********************************************

  public function login(Request $req){
        if($req->isMethod('get')){
                return view('backend.auth.login');
        }else{
            // dd($req->all());
            try{
                $req->validate([
                    'email' =>     'required|email',
                    'password' => 'required|string',
                ]);

                $user = User::where('email',$req->email)->first();
                // dd($user);
                if($user){
                    if(Auth::attempt(['email' => $req->email, 'password' => $req->password ])){
                        // Use the global helper function to generate studentId
                        fetchIp();
                        if($user->isSuperAdmin()){                             
                            return redirect()->route('super-admin.dashboard');
                        }
                        elseif($user->isAdmin()){
                            return redirect()->route('admin.dashboard');
                        }
                        elseif($user->isCollegeAdmin()){                          
                            return redirect()->route('college-admin.dashboard');
                        }
                        elseif($user->isCounsellor()){                          
                            return redirect()->route('counsellor.dashboard');
                        }
                        else{
                            return back()->with('error','Something Wrong');
                        }

                    }else{
                        return back()->with('error','Credentails Do Not Match!');

                    }
                    

                }else{
                    return back()->with('error','Record Not Found!');
                }
    

            }catch (ValidationException $e) {
                return back()->withErrors($e->validator)->withInput();
            }catch(\Exception $e){
                \Log::error('Login Error: ' . $e->getMessage());
                return back()->with('error', 'Warning : ' .$e->getMessage());
            }
            

            

        }
    }





 public function logout(){
        // Use Helper Function
        fetchIpLogout();        
        Auth::logout();   
        return redirect()->route('login')->with('success','Logout Successfully!');
    }




****************************************************************** app\helpers.php **************************************************************************************************
<?php
use App\Models\LogDetails;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon; 



if (!function_exists('generateStudentId')) {
    function generateStudentId($name, $mobile_no)
    {
        // Combine name and mobile_no to form studentId
        $cleanedName = preg_replace('/\s+/', '', strtolower($name)); // Remove spaces and lowercase the name
        return $cleanedName . substr($mobile_no, -4); // Append the last 4 digits of mobile_no
    }
}



if(!function_exists('fetchIp')){
    function fetchIp(){
        if (Auth::check()) {
            $user = Auth::User();
            $data = [
                'user_id' => $user->id,
                'ip' => Request::ip(),
                'time' => Carbon::now(),
                'type' => '1',
            ];
            LogDetails::create($data);
        }
    }

}

if(!function_exists('fetchIpLogout')){
    function fetchIpLogout(){
        if (Auth::check()) {
            $user = Auth::User();
            $data = [
                'user_id' => $user->id,
                'ip' => Request::ip(),
                'time' => Carbon::now(),
                'type' => '2',
            ];
            LogDetails::create($data);
        }
    }

}
