<meta name="csrf-token" content="{{ csrf_token() }}">




<div class="col-md-4">
    <div class="form-group">
        <label for="contact_id">Contact ID:</label>
        <div class="input-group">
            <span class="input-group-addon">
            <i class="fa fa-id-badge"></i>
            </span>
            <input class="form-control" placeholder="Contact ID" name="contact_id" type="text" id="contact_ids">
        </div>
        <div style="color: red;" id="error_contact_id"></div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#contact_ids').on('keyup',function(){
            var value = $(this).val();
            var button =  $('#submit_button');

            console.log("cONTACT iD : " +value);
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
			var dataToSend = {
               '_token' : csrfToken,
               value : value,
           };

           $.ajax({
			  url : "{{ route('getDetails') }}",
			  method: 'POST',
              cache: false,
              data : dataToSend,
              success:function(response){
					if(response.available){
						$('#error_contact_id').text("");
						button.prop('disabled', false);
					}else{
						$('#error_contact_id').text("Contact Id Is Already Exist");
						button.prop('disabled', true);
					}	
					
				},
              error:function(error){
                  console.error("Error sending data: " + error);
              }
               
           });
        });


    });
</script>




public function getDetails(Request $req) {
    $customer = Contact::where('type', 'customer')->where('contact_id', $req->value)->first();
    if ($customer) {
        return response()->json(['available' => false]);
    } else {
        return response()->json(['available' => true]);
    }
}