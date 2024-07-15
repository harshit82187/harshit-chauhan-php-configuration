// get curl handle for razorpay
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

// website booking store
public function bookingStore(){
    if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
        $razorpayPaymentId = $this->input->post('razorpay_payment_id');
        $merchant_order_id = $this->input->post('merchant_order_id');
        $currencyCode = $this->input->post('currency_code');
        $amount = round((intval($this->input->post('merchant_total'))*100),0);
        $success = false;
        $error = '';
        try {                
            $ch = $this->get_curl_handle_razorpay($razorpayPaymentId, $amount, $currencyCode);
            //execute post
            $result = curl_exec($ch);
            $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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
            redirect($this->input->post('merchant_surl_id'));
        } else {
            redirect($this->input->post('merchant_furl_id'));
        }
    } else {
        echo 'An error occured. Contact site administrator, please!';
        die;
    }
}












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


