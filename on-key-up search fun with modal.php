

            ******************************** Example OF KEyup Search Functionality In Modal*******************


<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- View  Money Receipt Modal -->
<div class="modal" id="money_receipt{{$data->id}}" aria-hidden="true" data-backdrop="static"> 
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="margin-left:172px; width:697px; margin-top:75px;">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Payment Collection</h4>
                <button type="button" class="close"  data-dismiss="modal" style="border: 50px;background-color:transparent;margin-top: -26px;" >&times;</button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
        {!! Form::open(['url' => action('VisaController@save_umraah_payment'), 'method' => 'post', 'enctype' => 'multipart/form-data'  ]) !!}

                @php 
                $result = $data->net_total - $data->amount;
                @endphp
                <input type="hidden" name="id" value="{{ $data->customer_id }}">
                 
                  <input type="hidden" name="invoice_no" value="{{ $data->invoice_no }}">

                

                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="question">Payment method </label>
                    <select class="form-control" name="payment_method" required>
							<option selected disabled>-Select method-</option>
							<option value="Cash">Cash</option>
							<option value="Bank">Bank</option>
							<option value="Mobile Bank">Mobile Bank</option>
					</select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                    <label for="question">Bank Name</label>
                        <input type="hidden" name="account_number" class="account_number" id="account_number_old">
                        <input type="text" class="form-control acc_no" name="bank_name" id="acc_no" onkeyup="searchAcount(this)" data-id="{{$data->id}}" autocomplete="one-time-code">
                        <div class="show-content-ajax-response" id="show-content-ajax-response-{{$data->id}}" data-id="{{$data->id}}"></div>
                    </div><br>
                </div>

         

                <div class="col-md-6">
                    <div class="mb-3">                   
                </div>

                <div class="col-md-6">
                     <button type="submit" id="submit" style="margin-top: 82px; margin-left: -364px;" class="btn btn-success btn-sm">Update</button>
                </div>
            {!! Form::close() !!}

                



                </div>
                                                                            
            </div>
        </div>
    </div>
</div>
<!-- End  Money Receipt Modal -->







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
    
   $(document).on('click', '.list-group-acc-developer', function() {
        var name = $(this).attr('list-name'); 
        var account_number = $(this).data('account_number');
        var inputEle = $(this).closest('.show-content-ajax-response').prev('input#acc_no');
        console.log(inputEle);
        inputEle.val(name);       
        
        var accountNumber = $(this).closest('.show-content-ajax-response').prevAll('.account_number').first();
        accountNumber.val(account_number);
        
        var selcectionDiv = $(this).closest('.show-content-ajax-response');
        selcectionDiv.hide();
    });
</script>


<script>
    const searchAcount = (e) => {
        var value = $(e).val();
        var dataId = $(e).data('id');
        var divForShow = $('#show-content-ajax-response-' + dataId);
       
        $.ajax({
            url: "{{ url('search-acc-no') }}",
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                value: value
            },
            success: function(data) {
                divForShow.show();
                divForShow.html(data.ul);
            },
            error:function(data){
				console.log(data);
			}

        });
    }
</script>










**************************** Controller Side Code *****************************

public function search_acc_no(Request $req){
        $accQuery  = Account::where('is_closed', '0');
                                    
        if ($req->input('value')) {
            $accQuery->where('name', 'LIKE', '%'.$req->input('value').'%');
        }
        $acc_name = $accQuery->get();

        $output = '<ul class="list-group" style="display:block;position:relative;z-index:1">';
        if (count($acc_name) > 0) {
            foreach ($acc_name as $row) {
                
                $output .= '<li class="list-group-item list-group-acc-developer" list-name="' . $row->name . 
                '" acc-name="' . $row->name .   
                '" data-account_number="' . $row->account_number . 
                '">' . $row->name . '</li>';
            }
        }  else {
        $output .= '<li class="list-group-item">No Data Found</li>';
        }
        $output .= '</ul>';

        return response()->json(['ul' => $output]);

     }
