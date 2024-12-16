
////////////// Here is Blade File Code ///////////////////////////////////
<div class="col-md-4">
    <div class="card-2">
        <div class="box">
            <div class="img">
                <a href="{{ route('offerPackages') }}"> <img class="img-fluid"
                        src="https://www.experienceandamans.com/lpg/images/04.jpg"> </a>
            </div>
            <h2>Andaman Delight<br><span>Rs. 12500/-</span> 
                <span> <a href="javascript:void(0)"
                        class="proceedToPay" style="color:white">Pay Now</a>
                </span></h2>
            <p>Top Holiday Packages Incl Sightseeing + Hotels + Cruise &amp; Water Activity </p>

        </div>
    </div>
</div>





/////// Add Foam In Blade File //////////////////////////////////////////////////
<form method="POST" id="razorpay-form" action="{{ url('booking-store') }}">
    @csrf
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="transaction_via" value="razorpay">
    <input type="hidden" name="order_id" value="<?=rand(11111,99999).time();?>">
</form>






///////// Add Script In the Code //////////////////////////////////////////////////
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var razorpay_options = {
        key: "rzp_test_Y2okL9veQEr5BY",
        amount: "1000",
        name: 'Harshit Chauhan',
        description: "product service",
        netbanking: true,
        currency: "INR",
        prefill: {
            name: 'Harshit Chauhan',
            email: 'harshit@pearlorganisation.com',
            contact: '8218756792',
        },
        notes: {
            soolegal_order_id: '11702624235',
        },
        handler: function(transaction) {
            // console.log(transaction);
            document.getElementById('razorpay_payment_id').value = transaction.razorpay_payment_id;
            document.getElementById('razorpay-form').submit();
        },
        "modal": {
            "ondismiss": function() {
                location.reload()
            }
        }
    };
    var razorpay_submit_btn, razorpay_instance;

    function razorpaySubmit(el) {
        if (typeof Razorpay == 'undefined') {
            setTimeout(razorpaySubmit, 200);
            if (!razorpay_submit_btn && el) {
                razorpay_submit_btn = el;
                el.disabled = true;
                el.value = 'Please wait...';
            }
        } else {
            if (!razorpay_instance) {
                razorpay_instance = new Razorpay(razorpay_options);
                if (razorpay_submit_btn) {
                    razorpay_submit_btn.disabled = false;
                    razorpay_submit_btn.value = "Pay Now";
                }
            }
            razorpay_instance.open();
        }
    }

    $(".proceedToPay").click(function(e) {
        e.preventDefault();
        razorpaySubmit(e);
    });
</script>




/////////// Add Web File Code //////////////////////////////////
Route::post('booking-store', 'bookingStore');



/////////// Add Controller Side Code /////////////////////////////


public function get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode)  {
    $url = 'https://api.razorpay.com/v1/payments/'.$razorpayPaymentId.'/capture';
    $key_id = 'rzp_test_dYBsRTVP3NxryK';
    $key_secret = 'kS2hj2UAfhb8MP2giaUJF6eL';
    $arr = ['amount' => $amount, 'currency' => $currencyCode];

    $arr1 = json_encode($arr);
    $fields_string = $arr1;
    //cURL Request      
    //cURL Request
    $ch = curl_init();
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    return $ch;
}





public function bookingStore(Request $request){

    // echo '<pre>';
    // print_r($request);
    // die;




    if (!empty($request->input('razorpay_payment_id')) && !empty($request->input('order_id'))) {
        $razorpayPaymentId = $request->input('razorpay_payment_id');
        $order_id = $request->input('order_id');
        $currencyCode = $request->input('currency_code');
        $amount = round((intval($request->input('merchant_total')) * 100), 0);
        $success = false;
        $error = '';
        try {                
            $ch = $this->get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode);
            //execute post
            $result = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            $data = [
                'razorpay_payment_id' => $razorpayPaymentId,
                'transaction_via'     => 'razorpay',
                'order_id'            =>  $order_id,
                'user_id'             => Auth::user()->id,
                
            ];

            DB::table('transactions')->insert($data);

            if($result === false){
                $success = false;
                $error = 'Curl error: '.curl_error($ch);
            }else{
                $response_array = json_decode($result, true);
                // echo '<pre>';
                // print_r($response_array);
                // die;
                // dd($response_array);
                if ($http_status === 200 and isset($response_array['error']) === false) {
                    $success = true;
                } else {
                    $success = false;
                    if (!empty($response_array['error']['code'])) {
                        $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                    } else {
                        $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                    }
                }
            }
            //close connection
            curl_close($ch);
        } catch (Exception $e) {
            $success = false;
            $error = 'OPENCART_ERROR:Request to Razorpay Failed';
        }
        if ($success === true) {
            $transactionId = $response_array['id'];
            return redirect()->to($request->input('merchant_surl_id'));
        } else {
            return redirect()->to($request->input('merchant_furl_id'));
        }
    } else {
        echo 'An error occured. Contact site administrator, please!';
        die;
    }
}



Card Details :- 4111 1111 1111 1111















*************************************************** Stripe Payment Gateway *******************************************************************

composer require stripe/stripe-php
                    
/////////////////// web file code ///////////////////
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});



 ///////////////////// Blade File Code ///////////////

<!DOCTYPE html>
<html>
<head>
    <title>Laravel - Stripe Payment Gateway Integration Example </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
    
<div class="container">    
    <h1>Laravel - Stripe Payment Gateway Integration Example <br/> Harshit Chauhan</h1>    
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                        <h3 class="panel-title" >Payment Details</h3>
                </div>
                <div class="panel-body">
    
                    @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
    
                    <form 
                            role="form" 
                            action="{{ route('stripe.post') }}" 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                        @csrf
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group required'>
                                <label class='control-label'>Name on Card</label> <input
                                    class='form-control' size='4' type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 form-group card required'>
                                <label class='control-label'>Card Number</label> <input
                                    autocomplete='off' class='form-control card-number' size='20'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-xs-12 col-md-4 form-group cvc required'>
                                <label class='control-label'>CVC</label> <input autocomplete='off'
                                    class='form-control card-cvc' placeholder='ex. 311' size='4'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Month</label> <input
                                    class='form-control card-expiry-month' placeholder='MM' size='2'
                                    type='text'>
                            </div>
                            <div class='col-xs-12 col-md-4 form-group expiration required'>
                                <label class='control-label'>Expiration Year</label> <input
                                    class='form-control card-expiry-year' placeholder='YYYY' size='4'
                                    type='text'>
                            </div>
                        </div>
    
                        <div class='form-row row'>
                            <div class='col-md-12 error form-group hide'>
                                <div class='alert-danger alert'>Please correct the errors and try
                                    again.</div>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now ($100)</button>
                            </div>
                        </div>
                            
                    </form>
                </div>
            </div>        
        </div>
    </div>        
</div>
    
</body>    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">  
$(function() {
    
    var $form = $(".require-validation");
     
    $('form.require-validation').bind('submit', function(e) {
        var $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
                         'input[type=text]', 'input[type=file]',
                         'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');
    
        $('.has-error').removeClass('has-error');
        $inputs.each(function(i, el) {
          var $input = $(el);
          if ($input.val() === '') {
            $input.parent().addClass('has-error');
            $errorMessage.removeClass('hide');
            e.preventDefault();
          }
        });
     
        if (!$form.data('cc-on-file')) {
          e.preventDefault();
          Stripe.setPublishableKey($form.data('stripe-publishable-key'));
          Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
          }, stripeResponseHandler);
        }
    
    });
      
    /*------------------------------------------
    --------------------------------------------
    Stripe Response Handler
    --------------------------------------------
    --------------------------------------------*/
    function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
                 
            $form.find('input[type=text]').empty();
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }
    }
     
});
</script>
</html>



/////////////// Controller Side Code //////////////////////
use Session;
use Stripe;

public function stripe()
    {
        return view('stripe.index');
    }

public function stripePost(Request $request)
    {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));  

        $customer = Stripe\Customer::create(array(

                "address" => [
                        "line1" => "Virani Chowk",
                        "postal_code" => "360001",
                        "city" => "Rajkot",
                        "state" => "GJ",
                        "country" => "IN",
                    ],

                "email" => "demo@gmail.com",
                "name" => "Hardik Savani",
                "source" => $request->stripeToken
            ));

    

        Stripe\Charge::create ([
                "amount" => 100 * 100,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => "Test payment from itsolutionstuff.com.",
                "shipping" => [
                "name" => "Jenny Rosen",
                "address" => [
                    "line1" => "510 Townsend St",
                    "postal_code" => "98140",
                    "city" => "San Francisco",
                    "state" => "CA",
                    "country" => "US",
                ],
                ]
        ]);  
        Session::flash('success', 'Payment successful!');      

        return back();

    }



Card Details    :-  4242 4242 4242 4242
                    12/34
                    567

Stripe Login    :- chauhanharshit350@gmail.com 
       Password :- Harshit@8218756792


STRIPE_KEY=pk_test_51PkJ4d06ShRfWNZFtQI3nuM25eMT1cbHjjSJRFHbNozetlH26nH2PENmyDVQt7F166VQk2KgSm48OKnrqE291A4A00F4WbmBYM
STRIPE_SECRET=sk_test_51PkJ4d06ShRfWNZFV7KHIsD30YoFGbrNyraAoieOKqTg79e5Boh2RNr9tIrOui5lOZcwbqXSbqok42HxxsUAGS3m00QtRBYLdk









************************************************** Second Method Razorpay Payment Gateway ***************************************************



 public function get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode)
    {
        $url = 'https://api.razorpay.com/v1/payments/' . $razorpayPaymentId . '/capture';
        $key_id = env('RAZORPAY_KEY_ID');
        $key_secret = env('RAZORPAY_SECRET');
        // $arr = ['amount' => $amount, 'currency' => $currencyCode];
        $arr = ['amount' => $amount * 100, 'currency' => $currencyCode];
	Log::info('Using Razorpay Key', ['key' => env('RAZORPAY_KEY')]);
	Log::info('Using Razorpay Secret', ['secret' => env('RAZORPAY_SECRET')]);
	Log::info('Razorpay API Request Data', ['data' => $arr]);

        $arr1 = json_encode($arr);
        $fields_string = $arr1;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        return $ch;
    }

                    

 public function proceedPayment($request)
    {
        try {
            if (!empty($request['razorpay_payment_id']) || !empty($request['merchant_order_id'])) {
                $razorpayPaymentId = $request['razorpay_payment_id'];
                $merchant_order_id = $request['merchant_order_id'];
                $booking_type = $request['booking_type'] ?? '0';
                $relative_table_id = $request['relative_table_id'] ?? '0';
                $currencyCode = "INR";
                $amount = $request['amount'];
                $success = false;
                $error = '';

                Log::info('Starting payment process', [
                    'razorpay_payment_id' => $razorpayPaymentId,
                    'merchant_order_id' => $merchant_order_id,
                    'amount' => $amount,
                    'currency' => $currencyCode
                ]);
                $user = Auth::User();

                $data = [
                    'booking_type'    => $booking_type,
                    'user_id'         => $user->id,
                    'relative_table_id' => $relative_table_id,
                    'currency' => $currencyCode,
                    'amount' => $amount,
                    'razorpay_payment_id' => $razorpayPaymentId,
                    'transaction_via'     => 'razorpay',
                    'merchant_order_id' => $merchant_order_id,                        
                ];

                Transaction::create($data);

                try {
                    $ch = $this->get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode);
                    
                    $result = curl_exec($ch);
                    // dd($result);
                    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    Log::info('Razorpay cURL Result', ['result' => $result, 'http_status' => $http_status]);

                    if ($result === false) {
                        $success = false;
                        $error = 'Curl error: ' . curl_error($ch);
                        Log::error('Curl execution failed: ' . curl_error($ch));
                    } else {
                        $response_array = json_decode($result, true);
                        Log::info('Razorpay Response', $response_array);

                        if ($http_status === 200 && isset($response_array['status'])) {
                            if ($response_array['status'] == 'captured') {
                                $email = Auth::user()->email;
                                $payment = Payment::create([
                                    'r_payment_id' => $response_array['id'],
                                    'method' => $response_array['method'],
                                    'currency' => $response_array['currency'],
                                    'user_email' => $email,
                                    'amount' => $response_array['amount'] / 100,
                                    'json_response' => $result,
                                ]);

                                Log::info('Payment successfully captured', ['status' => $response_array['status']]);
                                return 'captured';
                            } else {
                                $error = 'Payment capture failed: ' . $response_array['status'];
                                Log::error('Payment capture failed', ['status' => $response_array['status']]);
                                return 'failed';
                            }
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'] . ': ' . $response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR: Invalid Response';
                            }
                            Log::error('Razorpay API error', ['error' => $error]);
                        }
                    }

                    curl_close($ch);
                } catch (Exception $e) {
                    $success = false;
                    $error = 'OPENCART_ERROR: Request to Razorpay Failed - ' . $e->getMessage();
                    Log::error('Error processing payment: ' . $e->getMessage());
                }
            } else {
                $error = 'Missing required payment data';
                Log::error('Error processing payment: ' . $error);
            }
        } catch (Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            Log::error('Error processing payment: ' . $error);
        }

        if ($error) {
            Log::error('Final error during payment: ' . $error);
            return 'An error occurred. Contact site administrator, please!';
        }

        return $success;
    }




 public function cabBooking(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'id' => 'required|numeric',         
            'person' => 'required|numeric',
            'booking_date' => 'required',
            'razorpay_payment_id' => 'required',
            'transaction_via' => 'required',
            'amount' => 'required',
            'merchant_order_id' => 'required',
        ]);
          // Proceed with payment
          $bookingDetails = CabBooking::where('id', $request->id)->first();
          $yearMonth = Carbon::now()->format('Ym');
          $today     = Carbon::now()->format('d-M-Y');
          $string = Str::random(500);   
          $randomNumber = rand(100000, 999999);
          if (!empty($bookingDetails)) {
                $paymentData = [
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'merchant_order_id' => $request->merchant_order_id,
                    'amount' => $request->amount,
                    'relative_table_id' => $request->id,
                    'booking_type'      => '1',
                ];
                $payment = $this->proceedPayment($paymentData);
                if ($payment == 'captured') {
                    $user = Auth::user();               
                
                            $booking = new Booking();
                            $booking->userid = Auth::user()->id;
                          
                            $booking->booking_type = 1;               
                            $booking->persons = $request->person;
                            $booking->booking_price = $request->amount;
                            $booking->booking_date = $request->booking_date;
                            $booking->pickup_location = $bookingDetails->pickup_location;
                            $booking->drop_location = $bookingDetails->drop_location;
                            $booking->relative_table_id = $bookingDetails->id;
                            $booking->payment_status = 'success';
                            $booking->invoice = $yearMonth . $randomNumber;
                            $booking->save();
                            
        
                            // Send confirmation emails
                            $subject = 'Cab Booking Invoice';
                            $userEmail = $user->email;
                            $adminEmail = 'reachandamans@gmail.com';
                            try {
                                Mail::send('mail-template.cab-booking-invoice', ['booking' => $booking, 'user' => $user, 'booking_date' => $request->booking_date, 'person' => $request->person, 'amount' => $request->amount, 'cabDetail' => $bookingDetails, 'today' => $today,'adminEmail' => $adminEmail, 'type' => 1], function ($message) use ($subject, $userEmail) {
                                    $message->to($userEmail)->subject($subject);
                                });
                                Mail::send('mail-template.cab-booking-invoice', ['booking' => $booking, 'user' => $user, 'booking_date' => $request->booking_date, 'person' => $request->person, 'amount' => $request->amount, 'cabDetail' => $bookingDetails, 'today' => $today, 'adminEmail' => $adminEmail, 'type' => 1], function ($message) use ($subject, $adminEmail) {
                                    $message->to($adminEmail)->subject($subject);
                                });
                            } catch (Exception $e) {
                              dd($e->getMessage());
                            }
                            return redirect()->route('thank.you',['string' => $string,'booking' => $booking, 'user' => $user, 'booking_date' => $request->booking_date, 'person' => $request->person, 'amount' => $request->amount, 'cabDetail' => $bookingDetails, 'today' => $today,'adminEmail' => $adminEmail, 'type' => 1 ])->with('success', 'Payment successful and booking completed');

                }else {
                    return redirect()->back()->with('error', 'Error in payment');
                }         
            }else {
                return back()->with('error', 'Package details not found!');
            }
    }




Blade File Code :



<input type="hidden" name="activity_booking_modules_table_id" value="{{ $activity->id }}">
<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
<input type="hidden" name="transaction_via" value="razorpay">
<input type="hidden" name="amount" id="paid_amount">
<input type="hidden" name="adult" value="{{ $requestData['adult'] ?? '' }}">
<input type="hidden" name="children" value="{{ $requestData['child'] ?? '' }}">
<input type="hidden" name="passenger" id="passenger__count">
<input type="hidden" name="merchant_order_id" value="<?= rand(11111, 99999) . time() ?>">



<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
	$(document).ready(function() {
	  function updateSummary() {
	      let passengerCount = $(".passenger-row").length; // Count the total passengers
	      let childrenCount = 0; // Fixed at 0 (no age logic)
	      let adultCount = 0;    // Fixed at 0 (no age logic)
	      let totalAmount = 0;
	      let price = @json($activity->price); // Price per passenger
	
	      // Calculate total amount
	      totalAmount = passengerCount * price;
	
	      // Update summary UI
	      $("#passenger_count").text(passengerCount); // Total passenger count
	      $("#adult_count").text(adultCount + " * " + price + " = " + (adultCount * price)); // Adults (always 0)
	      $("#children_count").text(childrenCount + " * " + price + " = " + (childrenCount * price)); // Children (always 0)
	      $("#total_amount").text(passengerCount + " * " + price + " = " + totalAmount); // Total amount calculation
	
	      // Update hidden inputs
	      $("#paid_amount").val(totalAmount);
	      $("#adult").val(adultCount);    // Always 0
	      $("#children").val(childrenCount); // Always 0
	      $('#passenger__count').val(passengerCount);
	
	      console.log("Passenger Count: ", passengerCount);
	      console.log("Adult Count: ", adultCount); // Always 0
	      console.log("Children Count: ", childrenCount); // Always 0
	      console.log("Price per Passenger: ", price);
	      console.log("Total Amount: ", totalAmount);
	
	      return totalAmount;
	  }
	
	  $('#add-passenger').on('click', function (e) {
	      e.preventDefault();
	      let newRow = $('.passenger-row:first').clone(); // Clone the first passenger row
	      newRow.find('input[type="text"], input[type="number"]').val(''); // Clear input values
	      newRow.find('input[type="radio"]').prop('checked', false); // Reset radio buttons
	      let currentIndex = $('.passenger-row').length;
	      newRow.find('input[type="radio"]').each(function () {
	          let nameAttr = $(this).attr('name').replace(/\[\d+\]/, `[${currentIndex}]`);
	          $(this).attr('name', nameAttr);
	      });
	      newRow.find('.delete-row').show();
        newRow.find('.delete-row').removeClass('d-none');
	      $('.form').append(newRow); // Append the new row
	      updateSummary(); // Update the summary
	  });
	
	  $(document).on('click', '.delete-row', function () {
	      $(this).closest('.passenger-row').remove(); // Remove the passenger row
	      updateSummary(); // Update the summary
	  });
	
	  
	
	
	
	
	
	
	  var razorpayPaymentId = ""; // Variable to hold the payment ID
	  let totalAmount = updateSummary(); // Get the calculated total amount in paise
	  console.log("Total Amount: ", totalAmount);
	  var razorpay_options = {
	    key: "{{env('RAZORPAY_KEY_ID')}}", // Your Razorpay key ID
	    amount: totalAmount * 100,
	    name: "Andman", // Company name
	    description: "Booking Service", // Description of the service
	    netbanking: true, // Enable netbanking
	    currency: "INR", // Currency code
	    prefill: {
	      name: "{{ Auth::check() ? Auth::user()->name : '' }}", // Prefill user name
	      email: "{{ Auth::check() ? Auth::user()->email : '' }}", // Prefill email
	      contact: "{{ Auth::check() ? Auth::user()->mobile : '' }}" // Prefill contact number
	    },
	    handler: function(transaction) {
	      razorpayPaymentId = transaction.razorpay_payment_id; // Get the payment ID
	      console.log("Payment ID: " + razorpayPaymentId);
	      document.getElementById('razorpay_payment_id').value = razorpayPaymentId;
	      document.getElementById('passenger-form').submit(); // Submit the form after payment
	    },
	    modal: {
	      ondismiss: function() {
	        location.reload(); // Reload the page if the modal is dismissed
	      }
	    }
	  };
	
	
	
	  function updateRazorpayOptions() {
	    let totalAmount_ = updateSummary(); // Get the calculated total amount in paise
	    let totalAmountInPaise = totalAmount_ * 100;
	    console.log("Amount on Razorpay: " + totalAmountInPaise);
	
	
	    // Update the Razorpay options dynamically with the calculated values
	    razorpay_options.amount = totalAmountInPaise.toString(); // Update the amount in paise
	    razorpay_options.prefill.name = "{{ Auth::check() ? Auth::user()->name : '' }}";
	    razorpay_options.prefill.email = "{{ Auth::check() ? Auth::user()->email : '' }}";
	    razorpay_options.prefill.contact = "{{ Auth::check() ? Auth::user()->mobile : '' }}";
	  }
	
	  var razorpay_submit_btn, razorpay_instance;
	
	  function razorpaySubmit(el) {
	    console.log("Function Called");
	    $('.payAmountBtn').text('Please Wait...'); // Change button text
	    $('.payAmountBtn').prop('disabled', true); // Disable the button
	
	    updateRazorpayOptions(); // Update Razorpay options dynamically before submitting
	
	    if (typeof Razorpay === 'undefined') {
	      console.log("Razorpay is not loaded yet");
	      setTimeout(() => razorpaySubmit(el), 200); // Retry until Razorpay is loaded
	      if (!razorpay_submit_btn && el) {
	        razorpay_submit_btn = el;
	        el.disabled = true;
	        el.value = 'Please wait...';
	      }
	    } else {
	      if (!razorpay_instance) {
	        console.log("Creating Razorpay instance");
	        razorpay_instance = new Razorpay(razorpay_options); // Create new Razorpay instance
	        if (razorpay_submit_btn) {
	          console.log('Payment ID: ' + razorpayPaymentId);
	          razorpay_submit_btn.disabled = false; // Enable button
	          razorpay_submit_btn.value = "Pay Now"; // Reset button text
	        }
	      }
	      console.log('Opening Razorpay checkout');
	      razorpay_instance.open(); // Open the Razorpay checkout
	    }
	  }
	
	
	  // Handle form submission
	  $("#passenger-form").submit(function(e) {
	    // alert(121);
	    e.preventDefault();
	    let isValid = true;
	    const bookingDate = $("#booking_date_new").val();
	
	    $(".passenger-row").each(function() {
	      const row = $(this);
	
	      // Get values from the current row
	      const passengerName = row.find(".passenger-name").val();
	      const passengerPhone = row.find(".passenger-phone").val();
	      const passengerAge = row.find(".passenger-age").val();
	      const passengerGender = row.find(".passenger-gender:checked").val();
	
	
	      console.log("Passenger Name:", passengerName);
	      console.log("Passenger Phone:", passengerPhone);
	      console.log("Passenger Age:", passengerAge);
	      console.log("Passenger Gender:", passengerGender);
	
	
	
	
	      // Validate name
	      if (!passengerName) {
	        row.find(".passenger-name-error").text("Please enter passenger name.");
	        isValid = false;
	      } else {
	        row.find(".passenger-name-error").text("");
	      }
	
	      // Validate phone
	      if (!passengerPhone || passengerPhone.trim() === "" || passengerPhone.length !== 10) {
	        row.find(".passenger-phone-error").text("Please enter passenger mobile no.");
	        isValid = false;
	      } else {
	        row.find(".passenger-phone-error").text("");
	      }
	
	      // Validate age
	      if (!passengerAge || passengerAge <= 0) {
	        row.find(".passenger-age-error").text("Please enter passenger age.");
	        isValid = false;
	      } else {
	        row.find(".passenger-age-error").text("");
	      }
	
	      if (!passengerGender) {
	        row.find(".passenger-gender-error").text("Please select a gender.");
	        isValid = false;
	      } else {
	        row.find(".passenger-gender-error").text("");
	      }
	    });
	
	 
	
	    if (!bookingDate) {
	      $("#booking_date_new_error").text("Please select your booking date.");
	      isValid = false;
	    } else {
	      $("#booking_date_new_error").text(""); // Clear the error if a package is selected
	    }
	
	    if (isValid === true) {
	      razorpaySubmit(this);
	    }
	  });
	
	
	});
</script>



