****************************************************** Blade File Code **************************************************************************************



@extends('backend.layouts.app')

@section('content')

@php 
$user = Auth::User();  
use Carbon\Carbon;
$today = Carbon::now();
$todayFormatted = $today->format('Y-m-d');

$is_delay_Count = \App\Models\FollowUp::where('college_id', $user->college_id)
                              ->where('user_id', $user->id)                            
                              ->where('is_delay', '!=', '0')
                              ->count();

$today_follow_up_Count = \App\Models\FollowUp::where('college_id', $user->college_id)
                              ->where('user_id', $user->id)                            
                              ->whereDate('created_at',$todayFormatted)
                              ->count();
@endphp

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex  ">
                    <h4 class="mb-sm-0">Manage Student Leads</h4>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title mb-0">Manage Student Leads </h4>
                        <div>
                       
                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#leadModal" class="btn btn-sm btn-primary">Add Leads</a>
                        </div>                       
                        
                    </div><br>

                    <form method="GET" >
                        <div class="row">
                            <div class="col-md-1"></div>
                                <div class="col-md-2">
                                    <select class="form-select js-example-basic-single" name="country" id="country" style="line-height:0.9;">
                                        <option value="" selected disabled >--Select Country--</option>
                                        @php $countrys = \App\Models\Country::all(); @endphp
                                        @if($countrys->isNotEmpty())
                                            @foreach($countrys as $country)
                                            <option value="{{ $country->id }}" >{{ $country->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>    
                                <div class="col-md-2">

                                    <select class="form-select js-example-basic-single" id="state" name="state" style="line-height:0.9;">
                                        <option value="" selected disabled>--Select State--</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select class="form-select js-example-basic-single" id="city" name="city" style="line-height:0.9;">
                                        <option value="" selected disabled>--Select City--</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <select class="form-select" type="filter_source_type" style="line-height:0.9;">
                                        <option value="" selected disabled>--Select Source Type--</option>
                                        <option>By College Forum</option>
                                        <option>By Self</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <select class="form-select" name="filter_course" style="line-height:0.9;">
                                        <option value="" selected disabled>--Select Course--</option>
                                        <option value="B.Tech">B.Tech</option>
                                        <option value="B.Sc">B.Sc</option>
                                        <option value="BCA">BCA</option>
                                        <option value="MCA">MCA</option>
                                        <option value="B.Pharma">B.Pharma</option>
                                        <option value="D.Pharma">D.Pharma</option>


                                    </select>
                                </div>


                        </div>
                    </form>
                  
                        

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">
                            <div class="table-responsive table-card mt-3 mb-1">
                                <div class="row">
                                    <div class="col-2">
                               
                                    </div>
                                    <div class="col-8" style="left:3%;">
                                        <a href="javascript:void(0)"  class="btn btn-sm btn-primary manage-student-btn2 me-2" >Today Convert (0)</a>
                                        <a href="javascript:void(0)" id="filter_"  class="btn btn-sm btn-danger manage-student-btn me-2">Total Delay ({{$is_delay_Count ?? ''}})</a>
                                        <a href="javascript:void(0)"  class="btn btn-sm btn-dark manage-student-btn2 me-2">Today Follow Up ({{ $today_follow_up_Count ?? '' }})</a>
                                        <a href="javascript:void(0)"  class="btn btn-sm btn-success manage-student-btn me-2">All Leads(5)</a>
                                        <a href="javascript:void(0)"  class="btn btn-sm btn-success manage-student-btn me-2">Total Admission(1)</a>
                                        <a href="javascript:void(0)"  class="btn btn-sm btn-danger manage-student-btn me-2">Other College (50)</a>
                                        <a href="{{ route('counsellor.manage.student') }}"  class="btn btn-sm btn-success manage-student-btn me-2">Reset</a>
                                                                                
                                    </div>
                                    <div class="col-2">
                                            <select class="form-select" style="line-height:0.8; width:90%;" name="filter_lead_type" id="filter_lead_type" >
                                                <option value="" selected disabled >-- Select Status--</option>
                                                <option value="1" >Hot</option>
                                                <option value="2">Warm</option>
                                                <option value="3">Cold</option>
                                            </select>
                                    </div>
                                </div>
                          
                                <table class="table align-middle table-nowrap datatable" id="leadTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student Details</th>
                                            <th>State & City</th>
                                            <th>Source </th>
                                            <th>Follow Up</th>
                                            <th>Propose Mail</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- end card -->

                </div>
                <!-- end col -->
            </div>
        </div>

      







    </div>
</div>

  

    <!-- Send Message Modal -->
    <div class="modal fade" id="sendMessageModal" tabindex="-1" aria-labelledby="leadModalLabel" backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">Send Message </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="">
                        @csrf

                        <div class="mb-3">
                            <label for="state" class="form-label">Select Type <span class="text-danger" >*</span> </label>
                            <select name="type" id="type" class="form-control" required >
                                <option value="" selected disabled >--Chosse Template--</option>
                                <option value="Custom" >Custom</option>
                                <option value="Common" >Common</option>                              
                            </select>
                        </div>

                        <div class="mb-3" id="extra-input" ></div>

                        <div class="mb-3">
                            <label class="form-label"> Message Type <span class="text-danger" >*</span> </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="messagetype" id="sendByWhatsapp" value="sendbywhatsapp">
                                <label class="form-check-label" for="sendByWhatsapp">Send by Whatsapp</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="messagetype" id="sendbyemail" value="sendbyemail">
                                <label class="form-check-label" for="sendbyemail">Send by Email</label>
                            </div>

                          
                           
                           
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="">Submit</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Follow Up Modal -->
     <div class="modal fade" id="followUpModal" tabindex="-1" aria-labelledby="followUpModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="right:234px; top:35px; width:244%;">
                <div class="modal-header">
                    <h5 class="modal-title" id="followUpModalLabel">Follow Up</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <hr>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6" style="width:30%;" >
                            <form id="followUpForm">
                                @csrf

                        

                                <!-- Radio button options for follow-up status -->
                                <div class="mb-3">
                                    <label class="form-label">Follow-Up Status <span class="text-danger" >*</span> </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="callBackLater" value="Call Back Later">
                                        <label class="form-check-label" for="callBackLater">Call Back Later</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="notInterested" value="Not Interested">
                                        <label class="form-check-label" for="notInterested">Not Interested</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="wrongInfo" value="Wrong Information">
                                        <label class="form-check-label" for="wrongInfo">Wrong Information</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="notPickedUp" value="Not Picked Up">
                                        <label class="form-check-label" for="notPickedUp">Not Picked Up</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="admissionInOtherCollege" value="Admission in Other College">
                                        <label class="form-check-label" for="admissionInOtherCollege">Admission in Other College</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="followUpStatus" id="Others" value="Other">
                                        <label class="form-check-label" for="Others">Other</label>
                                    </div>
                                    
                                </div>

                                <div class="mb-3">
                                    <label for="followUpMessage" class="form-label">Remarks <span class="text-danger" >(Maximum 50 Words)</span></label>
                                    <textarea class="form-control" id="followUpMessage" name="remark" cols="5" rows="5"></textarea>
                                    <small id="charCount" class="text-muted">50 characters remaining</small>
                                </div>
                                <div class="row">

                                <div class="col-6">
                                    <label for="followUpMessage" class="form-label">Next Follow Up Date <span class="text-danger" >*</span></label>
                                    <input type="date"  id="follow-up-date" class="form-control" name="next_date" required >
                                </div>

                                <div class="col-6">
                                    <label for="followUpMessage" class="form-label">Next Follow Up Time <span class="text-danger" >*</span></label>
                                    <input type="time" class="form-control" name="time" required >
                                </div>
                                </div>
                                <input type="hidden" id="collegeId" >
                                <input type="hidden" id="studentId" >
                            </form>
                        </div>
                        <div class="col-6" style="width:68%;" >
                             <div id="followupList" style="max-height: 489px; overflow-y: auto;font-weight: bold"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-right:69%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitFollowUp">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Modal -->
    <div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">Lead Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="leadForm">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger" >*</span> </label>
                            <input type="text" name="name" required class="form-control" >
                        </div>

                        <div class="mb-3">
                            <label for="mobile_no" class="form-label">Mobile No <span class="text-danger" >*</span> </label>
                            <input type="number" name="mobile_no" required class="form-control" >
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger" >*</span> </label>
                            <input type="email" name="email" required class="form-control" >
                        </div>

                        <div class="mb-3">
                            <label for="student_country" class="form-label">Country <span class="text-danger" >*</span> </label>
                            <select name="student_country" id="student_country" class="form-select js-example-basic-single" required >
                                <option value="" selected disabled >--Select Country--</option>
                                @php $countrys = \App\Models\Country::all(); @endphp
                                @if($countrys->isNotEmpty())
                                    @foreach($countrys as $country)
                                        <option value="{{ $country->id }}" >{{ $country->name ?? '' }}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="student_state" class="form-label">State <span class="text-danger" >*</span> </label>
                            <select name="student_state" id="student_state" class="form-select js-example-basic-single" required >
                                <option value="" selected disabled >--First Chosse State--</option>                            

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="student_city" class="form-label">City <span class="text-danger" >*</span> </label>
                            <select name="student_city" id="student_city" class="form-select js-example-basic-single" required >
                             <option>--First Chosse City--</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="state" class="form-label">Course <span class="text-danger" >*</span> </label>
                            <select name="course" id="course" class="form-control" required >
                                <option value="" selected disabled >--Select Course--</option>
                                <option value="B.Tech" >B.Tech</option>
                                <option value="B.Sc" >B.Sc</option>
                                <option value="BCA" >BCA</option>
                                <option value="MCA" >MCA</option>
                                <option value="B.Pharma" >B.Pharma</option>
                                <option value="D.Pharma" >D.Pharma</option>                              

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lead_type" class="form-label">Lead Type <span class="text-danger" >*</span> </label>
                            <select name="lead_type" class="form-control" required >
                                <option value="" selected disabled >--Select Lead Type--</option>
                                <option value="1" >Hot</option>
                                <option value="2" >Warm</option>
                                <option value="3" >Cold</option>

                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitLead">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Whatsapp Message Modal -->
    <div class="modal fade" id="sendWhatsappMsg" tabindex="-1" aria-labelledby="leadModalLabel" backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">Send Whatsapp Message </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="sendWhatsappMessage" enctype="multipart/form-data" >
                        @csrf 
                        <input type="hidden" id="studentName" name="student_name">
                        <input type="hidden" id="studentMobileNo" name="student_mobile_no">         
                        <input type="hidden" id="collegeIds" name="college_id">
                        <input type="hidden" id="studentIds" name="student_id">  
                        <input type="hidden" id="user_id" name="user_id">         
       
                         
                         <div class="mb-3">
                            <label for="state" class="form-label">Select Type <span class="text-danger" >*</span> </label>
                            <select name="whatsapp_message_type" id="whatsapp_message_type" class="form-control" required >
                                <option value="" selected disabled >--Chosse Template--</option>
                                <option value="Custom" >Custom</option>
                                <option value="Common" >Common</option>                              
                            </select>
                        </div>

                        <div class="mb-3" id="extra-input2" ></div>

                    

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitWhatsappMessage">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Send Gmail Message Modal -->
    <div class="modal fade" id="sendGmailMsg" tabindex="-1" aria-labelledby="leadModalLabel" backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadModalLabel">Send Gmail Message </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="EmailMessageForm">
                        @csrf 
                        <input type="hidden" id="studentName" name="student_name">
                         <input type="hidden" id="studentEmail" name="student_email">   
                         
                         <div class="mb-3">
                            <label for="name" class="form-label">Subject <span class="text-danger" >*</span> </label>
                            <input type="text" placeholder="Type Your Subject" class="form-control" name="subject" >
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Message <span class="text-danger" >*</span> </label>
                            <textarea cols="5" rows="5" placeholder="Type Your Message...!" class="form-control" name="message" ></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitEmailMessage">Submit</button>
                </div>
            </div>
        </div>
    </div>




   






@endsection

@push('js')

<script>
    $(function(){
        var table = $('#leadTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('counsellor.manage.student.get') }}",
                data: function (d) {
                    d.country = $('#country').val();
                    d.state = $('#state').val();
                    d.city = $('#city').val();
                    d.filter_source_type = $('select[name="filter_source_type"]').val(); // Fixed selector
                    d.filter_course = $('select[name="filter_course"]').val();
                    d.filter_lead_type = $('#filter_lead_type').val();
                    console.log(d);
                }
            },
            columns: [                              
                {
                    data: 'student_details',
                    render: function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1 + '. ' + data;
                    },
                    name: 'student_details',
                    orderable: false, 
                    searchable: false
                },
                {data: 'state_city', name: 'state_city'},
                {data: 'source_type', name: 'source_type'},
                {data: 'follow_up', name: 'follow_up'},
                {data: 'send_message', name: 'send_message', orderable: false, searchable: false},
                {data: 'action', name: 'action'},
            ]
        });

        // Event listener for filter change
        $('#country, #state, #city, #filter_lead_type, select[name="filter_source_type"], select[name="filter_course"]').change(function(){
            table.draw();
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#student_country").on('change',function(){
            var countryId = $(this).val();
            console.log(countryId);

            $.ajax({
                url: "{{ url('get-state') }}/"+countryId,
                method : "GET",

                success:function(response){
                    if(response){
                        var dataString = JSON.stringify(response);
                        console.log(dataString);

                        var StatesDropdown = $('select[name="student_state"]');
                        StatesDropdown.empty();
                        StatesDropdown.append('<option selected disabled>--Select State--</option>');

                        $.each(response, function(index, state) {
                            StatesDropdown.append('<option value="' + state.id + '">' + state.name + '</option>');
                        });

                    }else{
                        console.error("Empty response received.");
                        alert("Empty response received.");
                    }


                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                }

            });


        });

        $("#student_state").on('change', function(){
            var stateId = $(this).val();
            console.log(stateId);

            $.ajax({
                url: "{{ url('get-city') }}/"+stateId,
                method : "GET",

                success:function(response){
                    if(response){
                        var dataString = JSON.stringify(response);
                        console.log(dataString);

                        var cityDropdown = $('select[name="student_city"]');
                        cityDropdown.empty();
                        cityDropdown.append('<option selected disabled>--Select City--</option>');

                        $.each(response, function(index, city) {
                            cityDropdown.append('<option value="' + city.id + '">' + city.name + '</option>');
                        });

                    }else{
                        console.error("Empty response received.");
                        alert("Empty response received.");
                    }


                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                }

            });


        });
    })
</script>


<script>


    function formatDate(dateString) {
        var date = new Date(dateString);
        var day = String(date.getDate()).padStart(2, '0');
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var year = date.getFullYear();
        return day + '-' + month + '-' + year;
    }

    $(document).on('click', '.follow-up-btn', function() {
        var collegeId = $(this).data('college-id');
        var collegeName = $(this).data('college-name');
        var studentId = $(this).data('student-id');
        console.log('Follow Up for College ID:', collegeId);
        console.log('Follow Up College Name :', collegeName);
        console.log('Follow Up Student ID :', studentId);


        var today = new Date().toISOString().split('T')[0];
        $('#follow-up-date').attr('min', today);


        var modalTitle = "Follow Up for " + collegeName;
        $('.modal-title').text(modalTitle);        

        $('#collegeId').val(collegeId);
        $('#studentId').val(studentId);

        $('#followupList').html('Loading...!');

        $.ajax({
            url: 'college/' + collegeId + '/' + studentId + '/follow-up-get',
            method: "GET",
            success:function(response){
                if(response.success){
                    console.log('Staff Users:', response.followups); 
                    $("#followupList").empty();

                    if(response.followups && response.followups.length > 0 ){
                        var table = '<table class="table table-striped">';
                        table += '<thead><tr><th>Status</th><th>Remark</th><th>Follow Date</th><th>Next Follow Date</th><th>Time</th></tr></thead> <tbody>';

                        $.each(response.followups, function(index, followup) {
                            var formattedDate = formatDate(followup.next_date);
                            var formattedCreatedAt = formatDate(followup.created_at); 

                            var delayButton = followup.delay_in_day > 0 
                            ? '<button class="btn btn-sm btn-danger ms-2">' + followup.delay_in_day + ' Day Delay' + '</button>' 
                            : ''; 

                            table += 
                                '<tr>' +                                    
                                    '<td>' + followup.follow_up_status + ' ' + delayButton + '</td>' +  // Status and delay in the same cell
                                    '</td>' +
                                    '<td>' + followup.remark + '</td>' +
                                    '<td>' + (formattedCreatedAt || 'N/A') + '</td>' + 
                                    '<td>' + (formattedDate || 'N/A') + '</td>' +
                                    '<td>' + followup.time + '</td>' +
                                '</tr>';
                        });

                        table += '</tbody></table>';
                        $('#followupList').append(table);
                    }else{
                        $('#followupList').html('No Follow up found!');

                    }

                }else{
                    $('#followupList').html('Error: ' + response.message);
                }
                $('#followUpModal').modal('show');
            },
            error:function(error, xhr, status){
                console.error(error);
                $('#followupList').html('No followup found.');            }
        })

    });

    $(document).on('click', '.send-whatsapp-message', function(){
        var studentName = $(this).data('student-name');
        var studentMobileNo = $(this).data('student-mobile_no');
        var studentId = $(this).data('student-student_id');
        var userId = $(this).data('user_id');
        var collegeId = $(this).data('college_id');

        console.log('Student Name :', studentName);
        console.log('Student Mobile No :', studentMobileNo);
        console.log('Student Id :', studentId);
        console.log('User Id :', userId);
        console.log('College Id :', collegeId);



        var modalTitle = "Send Whatsapp Message To :  " + studentName;
        $('.modal-title').text(modalTitle);        

        $('#studentName').val(studentName);
        $('#studentMobileNo').val(studentMobileNo);
        $('#collegeIds').val(collegeId);
        $('#studentIds').val(studentId);
        $('#user_id').val(userId);
        $("#extra-input2").empty();


        $('#sendWhatsappMsg').modal('show');
    });

    $(document).on('change','#whatsapp_message_type', function(){
        var type = $(this).val();
        console.log("type value : ",type);

        $("#extra-input2").empty();


        if(type == 'Custom'){
            var newRow = `              

                <div class="mb-3">
                    <label for="message" class="form-label ">Message <span class="text-danger" >*</span> </label>
                    <textarea cols="5" rows="5" required class="form-control summernote" name="message"  ></textarea>
                    <small id="charCount2" class="text-muted">50 characters remaining</small>

                </div>

                
                <div class="mb-3">
                    <label for="message" class="form-label ">Attchment (If You Want To Send) </label>
                    <input type="file" class="form-control" name="attachment"  accept="image/*,application/pdf">
                </div>
            `;
            $("#extra-input2").append(newRow);


        }else if(type == 'Common'){
            var newRow = `
                <div class="mb-3">
                    <label for="title" class="form-label">Select Template <span class="text-danger" >*</span> </label>
                    <select name="type" id="type" class="form-control" required >
                        <option value="" selected disabled >--Chosse Template--</option>
                        <option value="1" >College Course Brochure</option>
                        <option value="2" >College Hostel Brochure</option>     
                        <option value="3" >College Sports Brochure</option>                              
                         
                    </select>
                </div>               
            `;
            $("#extra-input2").append(newRow);

        }
    });

    $('#submitWhatsappMessage').on('click', function(e){
        e.preventDefault();
        const submitButton = $(this);
        submitButton.text('Please Wait...');

        let form = $('#sendWhatsappMessage')[0];
        let data = new FormData(form); 
     



        $.ajax({
            url: '{{ route('counsellor.college.send.whatsapp.message') }}',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false, 
            success: function(response) {
                submitButton.text('Submit');
                if (response.errors) {
                    var errorMsg = '';
                        $.each(response.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                } else {
                        $('#sendWhatsappMessage')[0].reset();
                        $('#sendWhatsappMsg').modal('hide');
                        $('#leadTable').DataTable().ajax.reload(null, false);
                        console.log(response);
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                }
            },
            error: function(xhr, status, error) {
                submitButton.text('Submit');
                let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    } else {
                        errorMessage += ': ' + error;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    }
            }
        });

    });

    $(document).on('click', '.send-gmail-message', function(){
        var studentName = $(this).data('student-name');
        var studentEmail = $(this).data('student-email');
        console.log('Student Name :', studentName);
        console.log('Student Email :', studentEmail);

        var modalTitle = "Send Gmail Message To :  " + studentName;
        $('.modal-title').text(modalTitle);        

        $('#studentName').val(studentName);
        $('#studentEmail').val(studentEmail);
        $('#sendGmailMsg').modal('show');
    });

    $('#submitEmailMessage').on('click', function(e){
        e.preventDefault();
        const submitButton = $(this);
        submitButton.text('Please Wait...').prop('disabled', true); // Disable the button to prevent multiple clicks


        let form = $('#EmailMessageForm')[0];
        let data = new FormData(form); 
        let studentName = $('#studentName').val();
        let studentEmail = $('#studentEmail').val();

        $.ajax({
            url: '{{ route('counsellor.college.send.email.message') }}',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false, 
            success: function(response) {
                if (response.errors) {
                    var errorMsg = '';
                        $.each(response.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                } else {
                        $('#EmailMessageForm')[0].reset();
                        $('#sendGmailMsg').modal('hide');
                        $('#leadTable').DataTable().ajax.reload(null, false);
                        console.log(response);
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    } else {
                        errorMessage += ': ' + error;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    }
            },
            complete: function() {
                // Revert button text back to original and enable it again
                submitButton.text('Submit').prop('disabled', false);
            }
        });

    });


    $('#followUpMessage').on('input', function() {
        let input = $(this).val();
        let sanitizedInput = input.toLowerCase().replace(/(^\s*|\.\s*)([a-z])/g, function(match) {
            return match.toUpperCase();
        });

        $(this).val(sanitizedInput);
        
        let maxLength = 50;
        let currentLength = sanitizedInput.length;

        if (currentLength > maxLength) {
            $(this).val(sanitizedInput.substring(0, maxLength));
            currentLength = maxLength;
        }

        $('#charCount').text((maxLength - currentLength) + ' characters remaining');
    });


    $('#submitFollowUp').on('click', function(e) {
       e.preventDefault();
       let form = $('#followUpForm')[0];
       let data = new FormData(form); // Properly create FormData from the form element
       let collegeId = $('#collegeId').val();
       let studentId = $('#studentId').val();

        $.ajax({
            url: 'college/' + collegeId + '/' + studentId + '/follow-up',
            method: 'POST',
            data: data,
            processData: false,
            contentType: false, 
            success: function(response) {
                if (response.errors) {
                    var errorMsg = '';
                        $.each(response.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                } else {
                        $('#followUpForm')[0].reset();
                        $('#followUpModal').modal('hide');
                        $('#leadTable').DataTable().ajax.reload(null, false);
                        console.log(response);
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    } else {
                        errorMessage += ': ' + error;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    }
            }
        });
    });



     $('#submitLead').on('click', function(e) {
        e.preventDefault();
        
        let form = $('#leadForm')[0];
        let data = new FormData(form);


       

        $.ajax({
            url: "{{ route('counsellor.college.lead.save') }}",  // Update this with your route
            method: 'POST',
            data: data,
            dataType: "JSON",
            processData: false,
            contentType: false,        
            success: function(response) {
                if (response.errors) {
                    var errorMsg = '';
                        $.each(response.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });

                }else{
                       $('#leadForm')[0].reset();
                        $('#leadModal').modal('hide');
                        $('#leadTable').DataTable().ajax.reload(null, false);
                        console.log(response);
                        iziToast.success({
                            message: response.message,
                            position: 'topRight'
                        });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errorMsg = '';
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $.each(errors, function(index, error) {
                                errorMsg += error + '<br>';
                            });
                        });
                        iziToast.error({
                            message: errorMsg,
                            position: 'topRight'
                        });
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    } else {
                        errorMessage += ': ' + error;
                        iziToast.error({
                            message: errorMessage,
                            position: 'topRight'
                        });
                    }
            }
        });
    });


    $(document).on('click','.send-message', function(){
        var leadId = $(this).data('lead-id');
        var leadName = $(this).data('lead-name');
        console.log("Lead Id :", leadId);
        console.log("Lead Name :", leadName);

        var modalTitle = "Send Message For : "+ leadName;
        $(".modal-title").text(modalTitle);
        $("#sendMessageModal").modal('show');
    });

    $(document).on('change','#type', function(){
        var type = $(this).val();
        console.log("type value : ",type);

        $("#extra-input").empty();


        if(type == 'Custom'){
            var newRow = `
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger" >*</span> </label>
                    <input type="text" name="title" required class="form-control" >
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label ">Message <span class="text-danger" >*</span> </label>
                    <textarea cols="5" rows="5" class="form-control summernote" name="message"  ></textarea>
                </div>
            `;
            $("#extra-input").append(newRow);


        }else if(type == 'Common'){
            var newRow = `
                <div class="mb-3">
                    <label for="title" class="form-label">Select Template <span class="text-danger" >*</span> </label>
                    <select name="type" id="type" class="form-control" required >
                        <option value="" selected disabled >--Chosse Template--</option>
                        <option value="1" >Call Back</option>
                        <option value="2" >Follow Up Message For Updates</option>     
                        <option value="3" >Switch Off</option>                              
                         
                    </select>
                </div>               
            `;
            $("#extra-input").append(newRow);

        }
    });
</script>



<script>
    $(document).ready(function() {
        // Initialize Select2 for all existing elements
        $('.js-example-basic-single').select2();

        // When modal is shown, reinitialize Select2 inside the modal
        $('#leadModal').on('shown.bs.modal', function () {
            $('#student_country, #student_state, #student_city').select2({
                dropdownParent: $('#leadModal')
            });
        });
    });
</script>



@endpush




***************************************************** Controller Side Code *******************************************************************


    public function manageStudentGet(Request $request){
        
        $user = Auth::User();    
        $college_id = $user->college_id;  
        // dd($request->all()); 
            
        try{
           

            $query = Lead::where('college_id', $college_id);
         
         

            // Apply filters
            if ($request->has('country') && $request->country) {
                $query->where('country', $request->country);

            }

            if ($request->has('state') && $request->state) {
                $query->where('state', $request->state);
            }

            if ($request->has('city') && $request->city) {
                $query->where('city', $request->city);
            }

            if ($request->has('source_type') && $request->source_type) {
                $query->where('source_type', $request->source_type);
            }

            if ($request->has('filter_course') && $request->filter_course) {
                Log::info("Filtering by course: " . $request->filter_course);
                $query->where('course', $request->filter_course);
            }

            if ($request->has('filter_lead_type') && $request->filter_lead_type) {
                $query->where('lead_type', $request->filter_lead_type);
            }

            if ($request->has('filter_total_delay') && $request->filter_total_delay) {
                $query->where('lead_type', '1');
            }


            Log::info("Query after filters: " . $query->toSql() . " with bindings: " . json_encode($query->getBindings()));

            $leads = $query->get();
            // Log::info($request->all());
            // dd($query->toSql(), $query->getBindings());
            // dd($leads);
            
            return Datatables::of($leads)
                ->addIndexColumn()
                ->addColumn('student_details', function ($row) {                          
                   
                    $studentName = $row->name ? $row->name : 'N/A';
                    $studentMobile = $row->mobile_no 
                        ? '<a style="font-size:12px; left:6%;" href="tel:' . $row->mobile_no . '">' . $row->mobile_no . '</a>' 
                        : 'N/A';
                    $studentEmail = $row->email 
                        ? '<a style="font-size:12px; left:6%;" href="mailto:' . $row->email . '">' . $row->email . '</a>' 
                        : 'N/A';
                    $studentCreatedat = $row->created_at 
                        ? '<span style="font-size:10px; margin-left:6% !important;"> Added By : ' . $row->created_at . '</span>'
                        : 'N/A';

                    $studentState = $row->statename->name  ? $row->statename->name : 'N/A';
                    $studentCity = $row->cityname->name  ? $row->cityname->name : 'N/A';  

                    $studentCourse = $row->course  
                        ? '<span style="font-size:10px; margin-left:6% !important;"> ' . $row->course . '</span>'
                        : 'N/A';

                        $studentleadType = '';

                        if ($row->lead_type == 1) {
                            $studentleadType = '<span class="btn btn-danger btn-sm py-0 px-2" style="font-size:68%;">Hot</span>';
                        } elseif ($row->lead_type == 2) {
                            $studentleadType = '<span class="btn btn-primary btn-sm py-0 px-2" style="font-size:68%;">Warm</span>';
                        } elseif ($row->lead_type == 3) {
                            $studentleadType = '<span class="btn btn-success btn-sm py-0 px-2" style="font-size:68%;">Cold</span>';
                        } else {
                            $studentleadType = 'N/A'; // Fallback if lead_type is not 1, 2, or 3
                        }
                    


            
                   return $studentName .   '<br>' . $studentCourse .  ' | ' . $studentleadType .  '<br>' . $studentMobile . '<br>' . $studentEmail . '<br>' . $studentCreatedat ;
                 })

                 ->addColumn('source_type', function($row){
                    return 'Website';
                })

               

                ->addColumn('follow_up', function($row) {
                    $followUpCount = $row->followUps->count();

                    $lastFollowUp = $row->followUps->sortByDesc('created_at')->first();
                    $lastFollowUpDate = $lastFollowUp ? date('d-m-Y', strtotime($lastFollowUp->created_at)) : 'N/A';
                    $delaydays = $lastFollowUp ? now()->diffInDays($lastFollowUp->created_at) : 0;
                    $delaydaysMessage = $delaydays > 0
                    ? '<span style="font-size:68%; color:red;"><button class="btn btn-danger btn-sm py-0 px-2">Last Followup date expired : ' . $delaydays . ' days ago</button></span>' 
                    : '';


                    $delay = $row->followUps->where('is_delay','!=',0)->count();
                    $remark = $lastFollowUp ? $lastFollowUp->remark : 'No remark available';
                    


                    $delayMessage = $delay > 0
                            ? '<span style="font-size:68%; color:red;"><button class="btn btn-danger btn-sm py-0 px-2">Delay: ' . $delay . '</button></span>' 
                            : '';


                    return '<button type="button" class="btn btn-warning btn-sm follow-up-btn" data-college-id="' . $row->college_id . '" data-college-name="' . $row->name . '" data-student-id = "' . $row->student_id . '" data-bs-toggle="modal" data-bs-target="#followUpModal">Follow Up (' . $followUpCount . ')</button>'
                            . '<br><span style="font-size:10px;">Last Follow Up: ' . $lastFollowUpDate . ' '
                            . '<i class="fas fa-info-circle" title="' . htmlspecialchars($remark) . '" style="color: black; cursor: pointer;"></i></span><br>' . $delayMessage . '<br>' . $delaydaysMessage;

                })

                ->addColumn('state_city', function($row){
                    $studentState = $row->statename->name  ? $row->statename->name : 'N/A';
                    $studentCity = $row->cityname->name  ? $row->cityname->name : 'N/A';
                     return '<span class="normal-text" style="font-weight:bold;" >' . $studentState . '</span><br>' .
                            '<span class="normal-text">' . $studentCity . '</span>';
             
                })

                

                ->addColumn('send_message', function($row){                     
                    $btn = '<a href="" class="send-message btn btn-primary btn-sm me-2" data-lead-id=" '.$row->id.' " data-lead-name=" '.$row->name.' " data-bs-toggle="modal" data-bs-target="#sendMessageModal"  >Send Broucher</a>';     
                    $btn .= '<a href="" class="send-whatsapp-message me-2" data-user_id="' . $row->user_id . '" data-student-student_id="' . $row->student_id . '" data-college_id="' . $row->college_id . '"  data-student-mobile_no="' . $row->mobile_no . '" data-student-name="' . $row->name . '" data-bs-toggle="modal" data-bs-target="#sendWhatsappMsg">'
                             . '<img src="' . asset('backend/whatsapp.png') . '" alt="WhatsApp Icon" style="width: 27px; height: 27px; margin-right: 5px;"></a>';                                                                              
                    
                    $btn .= '<a href="" class="send-gmail-message me-2" data-student-name="' . $row->name . '" data-student-email="' . $row->email . '" data-bs-toggle="modal" data-bs-target="#sendGmailMsg">'
                            . '<img src="' . asset('backend/gmail.png') . '" alt="Gmail Icon" style="width: 27px; height: 27px; margin-right: 5px;"></a>';                                         
                    return $btn;
                })

                ->addColumn('action', function($row){                     
                    $btn = '<a href="" class="paid-mark btn btn-primary btn-sm me-2" data-lead-id=" '.$row->id.' " data-lead-name=" '.$row->name.' " data-bs-toggle="modal" data-bs-target="#paidMark"  >Mark As Admission</a>';     
                    $btn .= '<a href="" class="reject btn btn-danger btn-sm me-2" data-lead-id=" '.$row->id.' " data-lead-name=" '.$row->name.' " data-bs-toggle="modal" data-bs-target="#reject"  >Reject</a>';     

                    return $btn;
                })

              


                ->rawColumns(['college_details','student_details','follow_up','website_link','state_city','send_message','action'])
                ->make(true);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
