********************** create A Modal When I Click View button fetch the details from the database ********************************************


1. Update Controller SIde code 

public function returnVehiclelisting(){
     
     $id = Auth::guard('staff')->user()->id;
    
     $listing = VehicleReturn::where('created_by',$id)->get();
     // dd($listing);
    
     return view('staff-dashboard.stock.returnvehicleListing', compact('listing'));
     
 }
 
  public function returnVehiclelistingmodal($id){
  
    
    
     $listing = VehicleReturn::where('vin_no',$id)->first();
     // dd($listing);
     // return json_encode($listing);
     // die;
    
     return response()->json($listing);
     
 }




 2. View File code 

@extends('staff-dashboard/layouts/base')
@push('extra_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">

@endpush
@section('content')
 <meta name="csrf-token" content="{{ csrf_token() }}">
<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>Vechicle Details </h4>

                    </div>
                    <div class="QA_table mb_30" style="background: #fff; 
    padding: 25px;">
                       
                        <table class="table lms_table_active" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">S.no</th>
                                    <th scope="col">Vehicle Name </th>
                                    <th scope="col">Driver Name </th>
                                    <!--<th scope="col">Created By</th>-->
                                    <th scope="col">Vehicle Issuee Date</th>
                                    <th scope="col">Vehicle Return Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach( $listing as $data)
                                <tr>
                                    <td>{{ $loop->iteration}}</td>
                                    <td>{{ $data->vin_no }}</td>
                                    <td>{{ $data->name }}</td>
                                    <!--<td>{{ $data->created_by }}</td>-->
                                    <td>{{ date('d-m-Y', strtotime($data->purchase_date)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($data->return_date)) }}</td>
                                    <td>
                                        <a href="#" class="mx-2 show-details"  data-url="{{ route('staff.returnVehiclelistingmodal', $data->vin_no) }}">                                            
                                          <i class="fa fa-eye" style="color:black"></i>
                                        </a>
                                        <a href="#" onclick="return confirm('Are You Sure?')" class="mx-2">
                                            <i class="fa fa-trash" style="color:red"></i>
                                        </a>
                                    </td>

                                </tr>
                               @endforeach 
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userShowModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vechicle Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Vehicle Name</label>
                    <input type="text" name="vin_no" id="vin_no" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Driver Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
             <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile" id="mobile" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Security</label>
                    <input type="text" name="security" id="security" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Extra Km</label>
                    <input type="text" name="extra_km" id="extra_km" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Total Rent</label>
                    <input type="text" name="total_rent" id="total_rent" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Taken Amount</label>
                    <input type="text" name="taken_amount" id="taken_amount" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Wallet</label>
                    <input type="text" name="wallet" id="wallet" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Repair Amount</label>
                    <input type="text" name="repair_amount" id="repair_amount" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Vehicle Issuee Date</label>
                    <input type="text" name="purchase_date" id="purchase_date" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-control border-0 px-0">
                    <label class="form-label">Vehicle Return Date</label>
                    <input type="text" name="return_date" id="return_date" class="form-control rounded-end" readonly autocomplete="off">
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save</button>-->
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>




<script>   
        // When the eye icon is clicked
        $('.show-details').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            var url = $(this).data('url');
            alert(url);

            // Make an AJAX request to fetch data
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    // alert(response);
                    if(response){
                        $('#vin_no').val(response.vin_no);
                        $('#name').val(response.name);
                        $('#mobile').val(response.mobile);
                        $('#security').val(response.security);
                        $('#extra_km').val(response.extra_km);
                        $('#total_rent').val(response.total_rent);
                        $('#taken_amount').val(response.taken_amount);
                        $('#wallet').val(response.wallet);
                        $('#repair_amount').val(response.repair_amount);
                        $('#purchase_date').val(response.purchase_date);
                        $('#return_date').val(response.return_date);

                        // Show the modal
                        $('#userShowModal').modal('show');

                        // Log the dataString to the console
                        var dataString = JSON.stringify(response);
                        console.log(dataString);

                    }else {
                        console.error("Empty response received.");
                        alert("Empty response received.");
                    }               

                },
                error: function(error) {
                    // Handle errors if any
                    console.error("An error occurred:", error);
                }
            });
        });
    
</script>

@endsection