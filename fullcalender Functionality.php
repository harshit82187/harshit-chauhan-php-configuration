********************************* Web File Code *****************************************************************

Route::get('/', function () {
    return view('calender');
});

Route::get('/events', [FullCalenderController::class, 'index']);
Route::post('/events', [FullCalenderController::class, 'store']);
Route::put('/events/{id}', [FullCalenderController::class, 'update']);
Route::delete('/events/{id}', [FullCalenderController::class, 'destroy']);




********************************* events table schema **************************************************************

id              bigint(20)             AUTO_INCREMENT
title           varchar(255) 
start           datetime
end             datetime
created_at      timestamp
updated_at      timestamp



********************************** calender.blade.php ********************************************************************
<!DOCTYPE html>
<html>
<head>
    <title>FullCalendar with Laravel</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.10.1/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@5.10.1/main.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div id='calendar'></div>

<script>
    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var selectedEvent = null;
    
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            events: '/events',
            timeZone: 'local', // Ensures local time zone handling
            eventDrop: function(info) {
                console.log('Event dropped:', info.event.id);
                $.ajax({
                    url: '/events/' + info.event.id,
                    method: 'PUT',
                    data: {
                        _token: csrfToken,
                        title: info.event.title,
                        start: info.event.start.toISOString(), // Send as ISO string
                        end: info.event.end ? info.event.end.toISOString() : null
                    },
                    success: function(response) {
                        console.log('Update success:', response);
                        alert('Event updated successfully');
                    },
                    error: function(xhr, status, error) {
                        console.log('Update error:', xhr.responseText);
                        alert('Error updating event: ' + error);
                    }
                });
            },
            select: function(selectionInfo) {
                selectedEvent = null;
                $('#eventTitle').val('');
                $('#eventStart').val(selectionInfo.startStr);
                $('#eventEnd').val(selectionInfo.endStr);
                $('#deleteEvent').hide();
                $('#eventModal').modal('show');
    
                $('#saveEvent').off('click').on('click', function() {
                    var title = $('#eventTitle').val();
                    var start = $('#eventStart').val();
                    var end = $('#eventEnd').val();
    
                    if (title && start) {
                        $.ajax({
                            url: '/events',
                            method: 'POST',
                            data: {
                                _token: csrfToken,
                                title: title,
                                start: new Date(start).toISOString(), // Convert to ISO string
                                end: end ? new Date(end).toISOString() : null
                            },
                            success: function(response) {
                                calendar.addEvent({
                                    id: response.id,
                                    title: response.title,
                                    start: response.start,
                                    end: response.end,
                                });
                                $('#eventModal').modal('hide');
                                alert('Event added successfully');
                            },
                            error: function(xhr, status, error) {
                                console.log('Add error:', xhr.responseText);
                                alert('Error adding event: ' + error);
                            }
                        });
                    }
                });
            },
            eventClick: function(info) {
                selectedEvent = info.event;
                $('#eventTitle').val(info.event.title);
                $('#eventStart').val(new Date(info.event.start).toISOString().slice(0, 16)); // Format correctly
                $('#eventEnd').val(info.event.end ? new Date(info.event.end).toISOString().slice(0, 16) : '');
                $('#deleteEvent').show();
                $('#eventModal').modal('show');
    
                $('#saveEvent').off('click').on('click', function() {
                    var title = $('#eventTitle').val();
                    var start = $('#eventStart').val();
                    var end = $('#eventEnd').val();
    
                    if (title && start) {
                        $.ajax({
                            url: '/events/' + selectedEvent.id,
                            method: 'PUT',
                            data: {
                                _token: csrfToken,
                                title: title,
                                start: new Date(start).toISOString(), // Convert to ISO string
                                end: end ? new Date(end).toISOString() : null
                            },
                            success: function(response) {
                                selectedEvent.setProp('title', response.title);
                                selectedEvent.setStart(response.start);
                                selectedEvent.setEnd(response.end);
                                $('#eventModal').modal('hide');
                                alert('Event updated successfully');
                            },
                            error: function(xhr, status, error) {
                                console.log('Update error:', xhr.responseText);
                                alert('Error updating event: ' + error);
                            }
                        });
                    }
                });
    
                $('#deleteEvent').off('click').on('click', function() {
                    if (confirm('Are you sure you want to delete this event?')) {
                        $.ajax({
                            url: '/events/' + selectedEvent.id,
                            method: 'DELETE',
                            data: {
                                _token: csrfToken
                            },
                            success: function(response) {
                                selectedEvent.remove();
                                $('#eventModal').modal('hide');
                                alert('Event deleted successfully');
                            },
                            error: function(xhr, status, error) {
                                console.log('Delete error:', xhr.responseText);
                                alert('Error deleting event: ' + error);
                            }
                        });
                    }
                });
            }
        });
    
        calendar.render();
    });
    </script>


<!-- Modal HTML -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="eventForm">
            <div class="form-group">
              <label for="eventTitle">Title</label>
              <input type="text" class="form-control" id="eventTitle" placeholder="Event Title">
            </div>
            <div class="form-group">
              <label for="eventStart">Start Time</label>
              <input type="datetime-local" class="form-control" id="eventStart">
            </div>
            <div class="form-group">
              <label for="eventEnd">End Time</label>
              <input type="datetime-local" class="form-control" id="eventEnd">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id="deleteEvent" style="display: none;">Delete</button>
          <button type="button" class="btn btn-primary" id="saveEvent">Save</button>
        </div>
      </div>
    </div>
</div>
  

</body>
</html>





************************************ Controller Side Code ***************************************************************

<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FullCalenderController extends Controller
{

    

    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function store(Request $request)
    {
        // Log the request data to check the format
        \Log::info('Request Data:', $request->all());

     

        // Create the event
        $event = Event::create([
            'title' => $request->title,
            'start' => Carbon::parse($request->start)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
            'end' => $request->end ? Carbon::parse($request->end)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : null
        ]);

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'title' => $request->title,
            'start' => Carbon::parse($request->start)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s'),
            'end' => $request->end ? Carbon::parse($request->end)->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s') : null
        ]);
        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return response()->json(['success' => 'Event deleted']);
    }

}

