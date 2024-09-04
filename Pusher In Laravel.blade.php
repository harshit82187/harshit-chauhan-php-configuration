//////////////////////////////// Pusher In Laravel ///////////////////////////////////////////////////////////////////

Step :1   Composer require pusher/pusher-php-server

Step :2     Setup pusher key in .env file


BROADCAST_DRIVER=pusher
BROADCAST_CONNECTION=pusher
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database


PUSHER_APP_ID=1837278
PUSHER_APP_KEY=d629fe4208f6a5174bdb
PUSHER_APP_SECRET=a006e93ddebb0c545b10
PUSHER_APP_CLUSTER=ap2


Step :3     app\Events\TestNotification.php 


<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * The channel the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('notification');
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'test.notification';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return $this->data;
    }
}



Step 4 : config/broadcasting.php 

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcaster that will be used by the
    | framework when an event needs to be broadcast. You may set this to
    | any of the connections defined in the "connections" array below.
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the broadcast connections that will be used
    | to broadcast events to other systems or over websockets. Samples of
    | each available type of connection are provided inside this array.
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];


Step : 5  Controller Side Code

public function project(Request $req){
    if($req->isMethod('get')){
        $projects = Project::where('status','0')->get();
        return view('admin.project.index', compact('projects'));
    }else{
        
        try{
            $data = [
                'project_name' => $req->project_name
            ];

            $project = Project::create($data);

                // Dispatch the event with the post data
            event(new TestNotification([
                'project_name' => $project->project_name,
                'created_at' => $project->created_at,
            ]));
            \Log::info('Broadcasting Event: ', $data);


            return back()->with('success','Project Add Successfully!');

        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());

        }
    }
}


Step : 6 pusher.blade.php 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Test with Icons</title>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Toastr JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Pusher JavaScript -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <style>
        /* Custom style for Toastr notifications */
        .toast-info .toast-message {
            display: flex;
            align-items: center;
        }
        .toast-info .toast-message i {
            margin-right: 10px;
        }
        .toast-info .toast-message .notification-content {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
    </style>
    <script>
        Pusher.logToConsole = true;

        // Initialize Pusher
        var pusher = new Pusher('d629fe4208f6a5174bdb', {
            cluster: 'ap2',
            useTLS: true
        });

        // Subscribe to the channel
        var channel = pusher.subscribe('notification');

        // Bind to the event
        channel.bind('test.notification', function(data) {
            console.log('Received data:', data); // Debugging line

            // Display Toastr notification with icons and inline content
            if (data.project_name && data.created_at) {
                toastr.info(
                    `<div class="notification-content">
                        <i class="fas fa-project-diagram"></i> 
                        <span>Project Name: ${data.project_name}</span><br>
                        <i class="fas fa-clock"></i> 
                        <span>Created At: ${new Date(data.created_at).toLocaleString()}</span>
                    </div>`,
                    'New Project Added',
                    {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000, // Adjust this as needed
                        extendedTimeOut: 2000,
                        positionClass: 'toast-top-right',
                        enableHtml: true
                    }
                );
            }else {
                console.error('Invalid data received:', data);
            }
        });

        // Debugging line
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected');
        });
    </script>
</head>
<body>
    <h1>Pusher Test with Icons</h1>
    <p>
        Try publishing an event to channel <code>notification</code>
        with event name <code>test.notification</code>.
    </p>
</body>
</html>

