
********************* Cron Job In Laravel ***********************************

1. Write Command In Terminal : php artisan make:command InActiveUser --command=demo:cron


2. In app/Console/Commands/InActiveUser.php
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use DB;


class InActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactive:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        \Log::info("Cron Is Working Fine");

        $data['userCount'] = DB::table('users')->count();
        $email = 'harshit@pearlorganisation.com';
        $subject = 'Testing Purpose Mail';


        Mail::send('admin.mail.cron-job', $data, function($message) use ($subject, $email) {
            $message->to($email);
            $message->subject($subject);
        });
    }
}




3. In app/Console/Kernel.php

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */

     
     protected $commands = [
        \App\Console\Commands\InActiveUser::class,
    ];



    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inactive:user')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}


4. Clear Or optimize Website

5. Run In Terminal : php artisan schedule:run

6. Check Your Command Run Or Not In Log File : storage/logs/laravel.php
