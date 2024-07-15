<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.1/css/bootstrap-grid.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style>
	.CloneContainer,
	.CloneContainerBilling,
	.CloneContainerHotel,
	.ticket-container,
	.CloneContainerSales,
	.CloneContainerPassport {
	align-items: center !important;
	}
	.CloneContainer ion-icon,
	.CloneContainerHotel ion-icon,
	.CloneContainerBilling ion-icon,
	.CloneContainerInvoice ion-icon,
	.CloneContainerHajji ion-icon {
	font-size: 25px;
	cursor: pointer;
	color: green;
	}
	.deleteRowBtn,
	.deletbtn {
	color: red;
	font-size: 13px;
	border: 1px solid red;
	border-radius: 50%;
	height: 20px;
	width: 20px;
	display: flex;
	justify-content: center;
	align-items: center;
	}
	.ticktet-deletbtn {
	color: grey;
	border: 1px solid grey;
	}
	label span {
	color: red;
	}
	.billing-icon {}
	#customer_list {
	width: 139px;
	}
	.container {}
	.row {
	margin-top: 20px;
	background: #dfe4eb;
	padding: 10px;
	border-radius: 4px;
	}
	.form-control {
	border-radius: 4px;
	}
	label {
	font-weight: 500;
	font-size: 15px;
	}
	.minimize-icon {
	margin-top: 29px;
	}
	.input-box {
	position: relative;
	}
	.select-box-icon {
	position: absolute;
	bottom: 0px;
	right: 0px;
	}
	.select-box-icon select {
	background-color: transparent;
	border: none;
	}
	input.session-date {
	position: relative;
	overflow: hidden;
	}
	input.session-date::-webkit-calendar-picker-indicator {
	display: block;
	top: 0;
	left: 0;
	background: #0000;
	position: absolute;
	transform: scale(12)
	}
	input[type="hidden"]+span.select2.select2-container {
	display: none;
	}
	.select2-container .select2-selection--single {
	height: 33px !important;
	}
	.select2-container{
	width: 100%!important;
	}
	.content-header {
	display: flex;
	justify-content: space-between;
	align-items: center;
	padding: 15px;
	border-bottom: 3px solid #3c8dbc;
	}
	.content-header .btn{
	background-color: #3c8dbc;
	color: #fff;
	padding: 5px 20px;
	}
	.content-header .btn a{
	color:#fff!important;
	}
</style>


<div class="row CloneContainerInvoice">
				<div>
					<legend>Invoice Information</legend>
				</div>
				<div class="col-xl-2  col-md-3 col-6">
					<label>Service Name<span>*</span></label>
					<select class="form-control js-example-basic-one" required name="service[]" id="">
						<option selected disabled>-Select Service-</option>
						<option value="Hajj Service Package A">Hajj Service Package A</option>
						<option value="Hajj Service Package B">Hajj Service Package B</option>
						<option value="Hajj Service Package C">Hajj Service Package C</option>
						<option value="Hajj Service Package VIP">Hajj Service Package VIP</option>
						<option value="Hajj Service General">Hajj Service General</option>
					</select>
				</div>
				<div class="col-xl-2  col-md-3 col-6">
					<label>Service Type</label>
					<input type="text" name="service_type[]" autocomplete="off" id="service_type" class="form-control">

				</div>
				<div class="col-xl-2  col-md-3 col-6">
					<label>Pax Name<span>*</span></label>
					<input type="text" name="pax[]" autocomplete="off" id="pax" required class="form-control">
				</div>
				<div class="col-2">
					<label>Quantity<span>*</span></label>
					<input type="tel" name="quantity[]" id="quantity" oninput="validateNumericInput(this)" required class="quantity form-control">
				</div>
				<div class="col-2">
					<label>Unit price<span>*</span></label>
					<input type="tel" name="unit_price[]" id="unit_price" oninput="validateNumericInput(this)" required class="unit_price form-control">
				</div>
				<div class="col-2">
					<label>Cost Price</label>
					<input type="tel" name="cost_price[]" id="cost_price" oninput="validateNumericInput(this)" required class="cost_price form-control">
				</div>
				<div class="col-2">
					<label>Total Price</label>
					<input type="tel" name="total_sales[]" id="total_sales" oninput="validateNumericInput(this)" required class="total_sales form-control">
				</div>
				<div class="col-2">
					<label>Toatal Cost Price</label>
					<input type="tel" name="total_cost[]" id="total_cost" oninput="validateNumericInput(this)" required class="total_cost form-control">
				</div>
				<div class="col-2">
					<label>Profit</label>
					<input type="tel" name="profit[]" id="profit" required class="profit form-control">
				</div>
				<div class="col-lg-2">
					<label>Vendor<span>*</span></label>
					<input type="hidden" name="vendor_id[]" >	              
					<select class="form-control js-example-basic-one" name="vendor[]" required>
						<option selected disabled>-Select Vendor-</option>
						@foreach($vendor as $data)
						<option value="{{ $data->name  }}" data-id="{{ $data->id }}">{{ $data->name  }}</option>
						@endforeach
					</select>

				</div>
				<div class="col-1">
					<div class="minimize-icon">
						<ion-icon name="add-circle-outline" class="CloneBtn2"></ion-icon>
					</div>
				</div>
</div>

<div class="row">
	<div class="col-lg-2 col-md-3 col-6">
		<label>Sub total</label>
		<input type="tel" name="sub_total" id="sub_total" oninput="validateNumericInput(this)" class="form-control sub_total" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Discount</label>
		<input type="tel" name="discount" id="discount" oninput="validateNumericInput(this)" class="form-control discount" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Service Charge</label>
		<input type="number" name="service_charge" oninput="validateNumericInput(this)" id="service_charge" class="form-control service_charge" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Vat/Tax</label>
		<input type="tex" name="vat_tax" id="vat_tax" oninput="validateNumericInput(this)" class="form-control vat_tax" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Net total</label>
		<input type="tel" name="net_total" id="net_total" oninput="validateNumericInput(this)" class="form-control net_total" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Agent commission</label>
		<input type="text" name="commission" id="commission" class="form-control" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Invoice Due</label>
		<input type="text" name="invoice_due" id="invoice_due" readonly class="form-control" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Present Balance </label>
		<input type="text" name="balance" id="balance" readonly class="form-control" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Reference</label>
		<input type="text" name="refernce" id="subrefernce_total" class="form-control" autocomplete="off">
	</div>
	<div class="col-lg-2 col-md-3 col-6">
		<label>Note</label>
		<input type="text" name="note" class="form-control">
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
	$("#single").select2({
		placeholder: "Select a programming language",
		allowClear: true
	});
	$("#multiple").select2({
		placeholder: "Select a programming language",
		allowClear: true
	});
</script>


<script>
	$(document).ready(function() {
		$('.js-example-basic-one').select2();
	});
</script>

<script>
    $(document).ready(() => {
        function updateSubTotal() {
            let subTotal = 0;
            $('.hajjiCalculation, .CloneContainerInvoice').each(function() {
                let totalSales = parseFloat($(this).find('.total_sales').val()) || 0;
                subTotal += totalSales;
            });

            let discount = parseFloat($('#discount').val()) || 0;
            let serviceCharge = parseFloat($('#service_charge').val()) || 0;
            let vatTax = parseFloat($('#vat_tax').val()) || 0;
            let netTotal = subTotal - discount + serviceCharge + vatTax;

            $('#sub_total').val(subTotal);
            $('#net_total').val(netTotal);
        }

        function calculateRow(row) {
            let quantity = parseFloat(row.find('.quantity').val()) || 0;
            let unit_price = parseFloat(row.find('.unit_price').val()) || 0;
            let cost_price = parseFloat(row.find('.cost_price').val()) || 0;

            let totalSales = unit_price * quantity;
            let totalCostPrice = cost_price * quantity;
            let totalProfit = totalSales - totalCostPrice;

            row.find('.total_sales').val(totalSales);
            row.find('.total_cost').val(totalCostPrice);
            row.find('.profit').val(totalProfit);
        }

		function updateVendorID(row) {
            const vendorSelect = row.find('select[name="vendor[]"]');
            const vendorID = vendorSelect.find('option:selected').data('id');
            row.find('input[name="vendor_id[]"]').val(vendorID);
        }

		$(document).on('change', 'select[name="vendor[]"]', function() {
            let row = $(this).closest('.hajjiCalculation, .CloneContainerInvoice');
            updateVendorID(row);
        });

        $(document).on('keyup change', '.quantity, .unit_price, .cost_price', function() {
            let row = $(this).closest('.hajjiCalculation, .CloneContainerInvoice');
            calculateRow(row);
            updateSubTotal();
        });



        $(document).on('input', '#discount, #service_charge, #vat_tax', function() {
            updateSubTotal();
        });

        $(document).on('click', '.deleteRowBtn', function() {
            $(this).closest('.hajjiCalculation').remove();
            updateSubTotal();
        });

        $('.js-example-basic-one').select2();

        const CloneBtn2 = $(".CloneBtn2");
        const CloneContainerInvoice = $(".CloneContainerInvoice");    

        CloneBtn2.on("click", function() {    
            const inputAmount = 1;    
            for (let i = 0; i < inputAmount; i++) {    
                const newClone = `    
                    <div class="hajjiCalculation">					
                        <div class="row">                        
							    <div class="col-xl-2  col-md-3 col-6">
									<label>Service Name<span>*</span></label>
									<select class="form-control js-example-basic-one" required name="service[]" id="">
										<option value="Hajj Service Package A">Hajj Service Package A</option>
										<option value="Hajj Service Package B">Hajj Service Package B</option>
										<option value="Hajj Service Package C">Hajj Service Package C</option>
										<option value="Hajj Service Package VIP">Hajj Service Package VIP</option>
										<option value="Hajj Service General">Hajj Service General</option>
									</select>
								</div>
								<div class="col-xl-2  col-md-3 col-6">
									<label>Service Type</label>
									<input type="text" name="service_type[]" autocomplete="off" id="service_type" class="form-control">

								</div>
								<div class="col-xl-2  col-md-3 col-6">
									<label>Pax Name<span>*</span></label>
									<input type="text" name="pax[]" autocomplete="off" id="pax" required class="form-control">
								</div>

							<div class="col-2">
								<label>Quantity<span>*</span></label>
								<input type="tel" name="quantity[]" id="quantity" oninput="validateNumericInput(this)" required class="quantity form-control">
							</div>
							<div class="col-2">
								<label>Unit price<span>*</span></label>
								<input type="tel" name="unit_price[]" id="unit_price" oninput="validateNumericInput(this)" required class="unit_price form-control">
							</div>
							<div class="col-2">
								<label>Cost Price</label>
								<input type="tel" name="cost_price[]" id="cost_price" oninput="validateNumericInput(this)" required class="cost_price form-control">
							</div>
							<div class="col-2">
								<label>Total Price</label>
								<input type="tel" name="total_sales[]" id="total_sales" oninput="validateNumericInput(this)" required class="total_sales form-control">
							</div>
							<div class="col-2">
								<label>Toatal Cost Price</label>
								<input type="tel" name="total_cost[]" id="total_cost" oninput="validateNumericInput(this)" required class="total_cost form-control">
							</div>
							<div class="col-2">
								<label>Profit</label>
								<input type="tel" name="profit[]" id="profit" required class="profit form-control">
							</div>
							<div class="col-lg-2">
								<label>Vendor<span>*</span></label>
								<input type="hidden" name="vendor_id[]" >	              
								<select class="form-control js-example-basic-one" name="vendor[]" required>
									<option selected disabled>-Select Vendor-</option>
									@foreach($vendor as $data)
									<option value="{{ $data->name  }}" data-id="{{ $data->id }}">{{ $data->name  }}</option>
									@endforeach
								</select>

							</div>
                            <div class="col-1">    
                                <i class="fa fa-minus deleteRowBtn deletbtn" aria-hidden="true"></i>    
                            </div>    
                        </div>
                    </div>
                `;
    
                CloneContainerInvoice.append(newClone);
                CloneContainerInvoice.find('.js-example-basic-one').select2();    
            }    
        });
    });
</script>