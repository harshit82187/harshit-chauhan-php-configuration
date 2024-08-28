
/////////////////////////////// Run Command //////////////////////////////////////////////////////

php artisan make:middleware AdminMiddleware


/////////////////////////////// config>auth ////////////////////////////////////////////////////

'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],



    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],


////////////////////////////// app\Http\Middleware\AdminMiddleware //////////////////////////////
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // dd('Middleware executed');
        // Check if the user is authenticated and is an admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->with('error','Unautorized user!'); // Redirect to admin login if not authenticated
        }

        return $next($request);
    }
}





//////////////////////////// app\http\kernal.php /////////////////////////////////////////////////
protected $middlewareAliases = [

  'admin'    => \App\Http\Middleware\AdminMiddleware::class,
];




///////////////////////// web.php //////////////////////////////////////////////////////////////

Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    
    dd('clear');
});


Route::match(['get','post'], 'admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::prefix('admin/')->name('admin.')->middleware('admin')->group(function(){
        Route::controller(AuthController::class)->group(function(){
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('users', 'users')->name('users');

            Route::get('logout', 'logout')->name('logout');

        });
});



public function logout(){
    Auth::guard('admin')->logout();
    session()->flush();
    // dd('Logged out');
    return redirect()->route('admin.login')->with('error','Logout Successfully!');
}


public function login(Request $req){

    try{
        if($req->isMethod('get')){
            // dd(121);
            // dd(Auth::guard('admin')->check());
            return view('backend.auth.login');

        }else{

            $req->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $email = $req->email;
            $password = $req->password;

            $admin = Admin::where('email',$email)->first();
            if($admin){
                if(Auth::guard('admin')->attempt([ 'email' => $email, 'password' => $password ])){
                    return redirect()->route('admin.dashboard')->with('success','Login Successfully!');
                }else{
                    return back()->with('error','Wrong Credentials!');
                }    
            }else{
                return back()->with('error','Record Not Found!');
            }   
            
        }

    }catch (ValidationException $e) {
        return back()->withErrors($e->validator)->withInput();
    }catch(\Exception $e){
        return back()->with('error', 'Warning : ' .$e->getMessage());
    }

    
}






///////////////////////////////////// Create Middleware In Laravel 11 /////////////////////////////////////////////



/////////////////////////////// Run Command //////////////////////////////////////////////////////

php artisan make:middleware AdminMiddleware


////////////////////////////// app\Http\Middleware\AdminMiddleware //////////////////////////////
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 121) {
            // User is authenticated and has the required role
            return $next($request);
        }

        // Redirect to login page or show an error message
        return redirect()->route('admin.login')->with('error', 'Unauthorized access');
    }
}



//////////////////////////////// bootstrap/app.php //////////////////////////////////////////////////

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {      
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();



///////////////////////////////// web.php file //////////////////////////////////////////////////////////
use App\Http\Middleware\AdminMiddleware;





Route::prefix('admin')->name('admin.')->group(function (){
    Route::controller(AdminController::class)->group(function (){
        Route::match(['get', 'post'], 'login', 'login')->name('login');

        Route::get('dashboard', 'dashboard')->name('dashboard')->middleware(AdminMiddleware::class);;

        Route::get('user', 'user_listing')->name('user_listing')->middleware(AdminMiddleware::class);;

        Route::get('approve-loan-amount/{id}', 'approve_loan')->name('approve_loan')->middleware(AdminMiddleware::class);;

        Route::get('logout', 'logout')->name('logout');
    });
});

