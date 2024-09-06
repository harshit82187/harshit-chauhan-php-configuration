
Step : 1

<a href="#" class="book-now-btn show-details" data-url="{{ route('booknowmodal', $card->id) }}">	Book Now	</a>


Step : 2

Route::get('/book-now/{id}', [WebsiteController::class, 'booknowmodal'])->name('booknowmodal');


Step : 3


<script>

$(document).ready(function() {

  var cardPrice = 0;
  $('.show-details').on('click',function(e){   
    e.preventDefault();
    var url = $(this).data('url');
    // alert(url);
    console.log(url);

    $.ajax({
      url:url,
      method:'GET',
      success:function(response){

        if(response){
          // alert(response);
          $('#myModal').modal('show');
          cardPrice = parseFloat(response.price);
          offer_price  = parseFloat(response.offer_price );
          $('#package_id').val(response.package_id);
          $('#tour_card_id').val(response.id);
          $('#card_price').val(response.price);

          var modalTitle = response.card_name + " Booking";
          $('.modal-title').text(modalTitle);

          var dataString = JSON.stringify(response);
          console.log(dataString);
          updateTotalPrice();

        }else{
          console.error("Empty response received.");
          alert("Empty response received.");
        }
      },

      error:function(error){
        console.log("An Error occoured :", error);
      }
      

    });
  });

    function updateTotalPrice() {
          var adults = parseInt($('#adult').val()) || 0;
          var children = parseInt($('#children').val()) || 0;

          var cardOfferPrice = cardPrice * (offer_price/100);
          var finalPrice = cardPrice - cardOfferPrice;

          var childPrice = finalPrice / 2;
          
          var adultFare = finalPrice * adults;
          var childFare = childPrice * children;
          var totalPrice = adultFare + childFare;

          $('#total_price').html('<label for="email" class="form-label">Total Price: </label>' + totalPrice.toFixed(2));
          $('#finalPrice').val(finalPrice.toFixed(2));
          $('#total_price_value').val(totalPrice.toFixed(2));
    }

    $('#adult, #children').on('input', function() {
        updateTotalPrice();
    });

    $('#myModal').on('hidden.bs.modal', function () {
        location.reload(); // Reload the page
    });
});
</script>


Step : 4

public function booknowmodal($id){
//    dd($id);
    try{
        $tour_card = TourCard::findOrFail($id);
        // dd($tour_card);
        return response()->json($tour_card);


    }catch(\Exception $e){
        return response()->json([
            'success' => false,
            'error'   => $e->getMessage(),
        ]);            
    }
    
}

Step : 5


<!-- Modal body -->
<div class="modal-body">
    <div class="container">
        <form action="{{route('save-booking-information')}}" method="post" class="popup-form">
            @csrf
            @if(Auth::check())
            <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
            <input type="hidden" value="{{ $finalPrice }}" name="finalPrice">
            <input type="hidden" name="tour_card_id" id="tour_card_id">
            <input type="hidden" name="package_id" id="package_id" />
            <input type="hidden"  id="card_price" name="card_price" >
            <input type="hidden" id="total_price_value" name="total_price_value" />
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="email" placeholder="Enter name" name="name" value="{{Auth::user()->name}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control"  id="email" placeholder="Enter email" name="email" value="{{Auth::user()->email}}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Number of Adult's:</label>
                        <input type="number" id="adult" class="form-control" placeholder="Enter number of adults" name="adult" id="adult" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Phone Number:</label>
                        <input type="number" class="form-control" id="email" placeholder="Enter phone number" name="phone_number" value="{{Auth::user()->phone_number}}" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="email" class="form-label">Number of Children's:</label>
                        <input type="number" class="form-control" placeholder="Enter number of childrens" id="children" name="children" />
                        <p class="form-note"> Note:  Children between 6 to 12 years old are charged 50% of the adult fare</p>
                    </div>
                </div>
                <div class="mb-3 input-group">
                    <label for="email" class="form-label">Date of Travel:</label>
                    <div>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <label for="email" class="form-label">From: </label>
                                <input type="date" class="form-control" name="date_from" />
                            </div>
                            <div class="col-md-6 col-12">
                                <label for="email" class="form-label">To: </label>
                                <input type="date" class="form-control" name="date_to" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="mb-3">
                <label for="email" class="form-label">Phone Number:</label>
                <input type="number" class="form-control" id="email" placeholder="Enter phone number" name="phone_number" value="{{Auth::user()->phone_number}}" />
                </div>
                @endif    -->
            <div class="mb-3" id="total_price">
                <label for="email" class="form-label">Total Price:</label>
            </div>
            <button type="submit" class="btn btn-primary textcolor modal-submit">Submit</button>
        </form>
    </div>
</div>
