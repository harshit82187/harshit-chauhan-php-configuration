
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



Card Details :-  4242 4242 4242 4242
                 12/34
                 567

Stripe Login    :- chauhanharshit350@gmail.com 
       Password :- Harshit@8218756792






