

            ******************************** Example OF KEyup Search Functionality*******************


@extends('admin-dashboard/layouts/base')
@push('extra_css')
<style>
    #vinno_list {
        height: 150px;
        overflow: hidden;
        position: absolute;
        width: 100%;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('content')
<div class="main_content_iner ">
    <div class="container-fluid p-0">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="white_box mb_30">
                    <div class="box_header ">
                        <div class="main-title">
                            <h3 class="mb-0"><img src="{{ asset('/img/icon/8.jpg') }}" style="width: 35px; height: 35px; "> Vehicle Return Details </h3>
                        </div>
                    </div>
                    <form method="post" id="form" action="{{ route('admin.vehiclereturnadd')}}">
                        @if (session()->get('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session()->get('success') }}
                        </div>
                        @endif
                        @csrf
                        <div class="row g-3">

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Vin No</label>
                                    <div>
                                        <input type="text" name="vin_no" id="vin_no" class="form-control rounded-end @error('vin_no') is-invalid @enderror" placeholder="Enter Vin No" value="{{ old('vin_no')}}" required autocomplete="off">
                                        <div id="vinno_list">

                                        </div>
                                        @error('vin_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Driver Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control rounded-end @error('name') is-invalid @enderror" placeholder="Enter Driver Name" value="{{ old('name')}}" require autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Mobile No</label>
                                    <div>
                                        <input type="text" name="mobile" class="form-control rounded-end @error('mobile') is-invalid @enderror" placeholder="Enter Mobile Number" value="{{ old('mobile')}}" require autofocus maxlength="10">
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Date of Renting </label>
                                    <div>
                                        <input type="date" name="purchase_date" class="form-control rounded-end @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date')}}" required autofocus>
                                        @error('purchase_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Return Date </label>
                                    <div>
                                        <input type="date" name="return_date" class="form-control rounded-end @error('return_date') is-invalid @enderror" value="{{ old('return_date')}}" required autofocus>
                                        @error('return_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Security Amount </label>
                                    <div>
                                        <input type="text" name="security" class="form-control rounded-end @error('security') is-invalid @enderror" value="{{ old('security')}}" require autofocus>
                                        @error('security')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Extra KM </label>
                                    <div>
                                        <input type="text" name="extra_km" class="form-control rounded-end @error('extra_km') is-invalid @enderror" value="{{ old('extra_km')}}" require autofocus>
                                        @error('extra_km')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Total Rent </label>
                                    <div>
                                        <input type="text" name="total_rent" class="form-control rounded-end @error('total_rent') is-invalid @enderror" value="{{ old('total_rent')}}" require autofocus>
                                        @error('total_rent')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Taken Amount </label>
                                    <div>
                                        <input type="text" name="taken_amount" class="form-control rounded-end @error('taken_amount') is-invalid @enderror" value="{{ old('taken_amount')}}" require autofocus>
                                        @error('taken_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Refund Amount </label>
                                    <div>
                                        <input type="text" name="refund_amount" class="form-control rounded-end @error('refund_amount') is-invalid @enderror" value="{{ old('refund_amount')}}" require autofocus>
                                        @error('refund_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div>
                                    <label class="form-label">Repair Charges(If Any) </label>
                                    <div>
                                        <input type="text" name="repair_amount" class="form-control rounded-end @error('repair_amount') is-invalid @enderror" value="{{ old('repair_amount')}}" require autofocus>
                                        @error('repair_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6"></div>


                            <div class="col-lg-6">
                                <div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>



                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection







@push('extra_js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $('#vin_no').on('keyup', function() {
            $('#vinno_list').show();
            var value = $(this).val();
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (value != '') {
                $.ajax({
                    url: "{{ route('admin.vehicledata') }}",
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': csrfToken },
                    data: {
                        value: value
                    },
                    success: function(data) {
                        $('#vinno_list').html(data.ul);
                    },
                    error:function(data){
						console.log(data);
					}

                });
            } else {
                $('#vinno_list').empty();
            }
        });
    });
</script>
<script>
    // click on input box auto complete
    // $(document).on('click','.list-group-item-developer',function(){
    //     var list_group_item_name = $(this).attr('list-vin-no');
    //     $('#vin_no').val(list_group_item_name);
    //     $('#vinno_list').hide();
    // });
    $(document).on('click', '.list-group-item-developer', function() {
        var vin = $(this).attr('list-vin-no'); // Get the VIN number from the clicked list item
        var name = $(this).data('name');
        var mobile = $(this).data('mobile');
        var security = $(this).data('security');
        var extra_km = $(this).data('extra_km');
        var total_rent = $(this).data('total_rent');

        console(vin);
        // Get the driver name from the clicked list item
        $('#vin_no').val(vin); // Update the VIN input field with the selected VIN
        $('input[name="name"]').val(name);
        $('input[name="mobile"]').val(mobile);
        $('input[name="security"]').val(security);
        $('input[name="extra_km"]').val(extra_km);
        $('input[name="total_rent"]').val(total_rent);
        $('#vinno_list').hide(); // Hide the suggestion list
    });
</script>
@endpush










**************************** Controller Side Code *****************************

public function vehicledata(Request $request)
{
    $data = Csv::where('vin_no', 'LIKE','%'. $request->input('value') . '%')->get();
    $output = '<ul class="list-group" style="display:block;position:relative;z-index:1">';
        if (count($data) > 0) {
            foreach ($data as $row) {
                
                $output .= '<li class="list-group-item list-group-item-developer" list-vin-no="' . $row->vin_no . 
                '" data-name="' . $row->name . 
                '" data-mobile="' . $row->mobile . 
                '" data-security="' . $row->security . 
                '" data-extra_km="' . $row->extra_km . 
                '" data-total_rent="' . $row->total_rent . 
                '" data-date_taken="' . htmlspecialchars(date('d-m-Y', strtotime($row->date_taken))) .
                '" data-wallet="'. $row->wallet . 
                '">' . $row->vin_no . '</li>';
            }
        }  else {
        $output .= '<li class="list-group-item">No Data Found</li>';
    }
    $output .= '</ul>';

    return response()->json(['ul' => $output]);
}
