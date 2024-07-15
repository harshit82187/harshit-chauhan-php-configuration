//////////////////////////////////////// Api Create In Laravel 11 /////////////////////////////////////////////////////////

php artisan install:api

 
*********************************            In api.php file       ******************************************************

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('saved-user', 'signUp')->name('signUp');
});



************************************************ Controller Side Code **************************************************


public function signUp(Request $req){
    $rules = [
        'contact' => 'required|string|min:10|max:15',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ];

    $validator = Validator::make($req->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $req->only([
        'name', 'contact', 'email', 'role','gender','dob'
    ]);

    if($req->image != null){
        $file = $req->image;
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('assets/images'), $filename);
        $data['image'] = $filename;
    }
    
    $data['password'] = Hash::make($req->password);
    User::create($data);
    return response()->json([
        'success' => true,
        'message' => 'User registered successfully'
    ], 201);
}



************************************************ Run In Postman *******************************************************


http://localhost:8000/api/saved-user

Body ke ander form-data me parameter dene h!