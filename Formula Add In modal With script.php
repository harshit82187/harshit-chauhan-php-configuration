

****************************** Modal Code ************************************

<div class="modal fade" id="oppo_accept{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content" style="width:134%;";>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">User Opportunity Details</h5>
				<button type="button" class="close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('admin.oppo_accept') }}" method="POST" enctype="multipart/form-data">
				@csrf
			<div class="modal-body">
			
			<div class="row">
				<input type="hidden" name="id" value="{{$data->id}}">
				<input type="hidden" name="user_id" value="{{$data->user_id}}">

					
					<div class="col-lg-6">
						<div >
							<label class="form-label">Tenure (In Months)</label>
							<input type="text" name="tenure" id="tenure_{{ $data->id }}" class="form-control" required autocomplete="off" autofocus>
						</div>
					</div>

										
				
					

					
				
					<div class="col-lg-6">
						<div >
							<label class="form-label">Amount</label>
							<input type="number" name="amount" id="amount_{{ $data->id }}" class="form-control" required  autocomplete="off" autofocus>
						</div>
					</div>

					<div class="col-lg-6">
						<div >
							<label class="form-label">Rate Of Intrest</label>
							<input type="text" name="intrest" id="intrest_{{ $data->id }}" class="form-control" required  autocomplete="off" autofocus>
						</div>
					</div>

					<div class="col-lg-6">
						<div >
							<label class="form-label">Future Value</label>
							<input type="text" name="future_value" id="future_value_{{ $data->id }}" class="form-control" required  autocomplete="off">
						</div>
					</div>
					
						
			
				
				</div>
					</div><br><br>
					
					<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-sm">Submit</button>
					<button type="button" class="btn btn-secondary btn-sm" >Close</button>
					<!--<button type="button" class="btn btn-primary">Save</button>-->
					</div>

			</form>
			

			</div>
		</div>
</div>





**************************** Add Script *************************************
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
		// Function to calculate future value
		function calculateFutureValue(id) {
			const amount = parseFloat($('#amount_' + id).val()) || 0;
			const tenure = parseFloat($('#tenure_' + id).val()) || 0;
			const interest = parseFloat($('#intrest_' + id).val()) || 0; // Fix variable name

			console.log(amount); console.log(tenure); console.log(interest);

			const tenure1 = (tenure) / 12;
			const roundedTenure1 = parseFloat(tenure1.toFixed(2));

			const futureValue = amount * Math.pow((1 + interest), roundedTenure1);
			$('#future_value_' + id).val(futureValue.toFixed(2));
			console.log(futureValue);
		}

		// Attach event listeners to relevant input fields
		$('input[id^="amount_"], input[id^="tenure_"], input[id^="intrest_"]').on('input', function() {
			const id = $(this).attr('id').split('_')[1];
			calculateFutureValue(id);
		});

		$('.btn-secondary').on('click', function(){
			location.reload(true);
		});

		$('.close').on('click', function(){
			location.reload(true);
		});
</script>
