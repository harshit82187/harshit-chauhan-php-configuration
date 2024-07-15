
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



Route::prefix('admin')->name('admin.')->group(function (){
  Route::match(['get','post'], 'login', [AuthController::class, 'login'])->name('login');

  Route::middleware('admin')->group(function (){
      Route::controller(AuthController::class)->group(function(){
          Route::get('dashboard', 'dashboard')->name('dashboard');

          Route::get('logout', 'logout')->name('logout');        

      });
     
  });

});









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

