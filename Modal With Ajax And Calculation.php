
Step : 1

<a href="#" class="book-now-btn show-details" data-url="{{ route('booknowmodal', $card->id) }}">	Book Now	</a>


Step : 2

Route::get('/book-now/{id}', [WebsiteController::class, 'booknowmodal'])->name('booknowmodal');


Step : 3


<script>

$(document).ready(function() {

    var today = new Date().toISOString().split('T')[0];
    $('#checkin_date').attr('min', today);

    $('#checkin_date').on('change', function() {
            var checkInDate = $(this).val();
            
            $('#checkout_date').attr('min', checkInDate);
        });

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
                                <label for="checkin_date" class="form-label">Check In Date : </label>
                                <input type="date" class="form-control" name="date_from"  id="checkin_date">
                            </div>

                            <div class="col-md-6 col-12">
                                <label for="email" class="form-label">Check Out Date : </label>
                                <input type="date" class="form-control" name="date_to" id="checkout_date" />
                            </div>

                            </div>
                    </div>
                </div>
            </div>
           
            <div class="mb-3" id="total_price">
                <label for="email" class="form-label">Total Price:</label>
            </div>
            <button type="submit" class="btn btn-primary textcolor modal-submit">Submit</button>
        </form>
    </div>
</div>























************************************************ Edit Modal With Details *****************************************************************

Step : 1

<a href="javascript:void(0)" class="btn btn-primary btn-sm edit-details" data-url="{{ route('admin.editPropertyDetail', $property->id) }}" >Edit</a>

Step : 2

{{-- Edit Modal --}}
@php $categorys = DB::table('property_categorys')->where('status','1')->get();  @endphp
<div class="modal fade" id="editproperty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Edit Property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" autocomplete="off" action="{{ route('admin.updatePropertyDetail') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="property_id" id="property-id">

                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" class="form-control" name="slug" required readonly >

                       
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="image-field" class="form-label">Existing Images</label>
                                <div id="existing-images" class="mb-3">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="image-field" class="form-label">Upload New Images</label>
                                <input type="file" class="form-control" name="image[]" multiple>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Category</label>
                                @if($categorys->isNotEmpty())
                                <select class="form-control" name="property_category_id" id="property_category_id" >                                  
                                    @foreach($categorys as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == "property_category_id" ? 'selected' : '' }} > {{ $category->name }} </option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Title</label>
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Description</label>
                                <textarea class="form-control" rows="6" cols="5" name="description" id="description"  ></textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address" required>

                            </div>
                        </div>

                        <div class="col-12" id="facility-inputs2">
                            <label for="facility-field" class="form-label">Previous Facility</label>
                            <!-- Facilities will be dynamically added here -->
                        </div>

                        <div class="col-12" id="facility-inputs3" >
                            <div class="mb-3">
                                <label for="facility-field" class="form-label">Add New Facility</label>
                                <div class="input-group">
                                    <input type="text" class="form-control"  id="new-facility2" name="facilities[]">
                                    <button type="button" class="btn btn-outline-secondary" id="add-facility2" ><img src="{{ asset('backend/images/add.png') }}" style="height:17px;" ></button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


Step : 3

Route::get('property/detail/edit/{id}', 'editPropertyDetail')->name('editPropertyDetail');
Route::post('remove/propert/image', 'removePropertyImage')->name('removePropertyImage');
Route::post('property/detail/update', 'updatePropertyDetail')->name('updatePropertyDetail');

Step : 4 

public function editPropertyDetail($id){
        try{
            $detail = Property::findOrFail($id);
            return response()->json($detail);


        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());       }
   
    }

public function removePropertyImage(Request $req){
    // dd($req->all());

    $image = $req->input('image');
    $propertyId = $req->input('property_id');
    $index = $req->input('index');

    $req->validate([
        'image' => 'required|string',
        'property_id' => 'required|integer',
    ]);

    $property = Property::find($propertyId);
    if($property){
        $t1 = json_decode($property->image, true);
        unset($t1[$index]);
        $t1 = array_values($t1);
        $property->update(['image' => json_encode($t1) ]);   
        Storage::disk('public')->delete('front/img/propertys/' . $image); 
        return response()->json(['success' => true]);


    }else{
        return response()->json(['success' => false, 'message' => 'Image index not found.'], 404);

    }

    return response()->json([
                    'success' => false,
                    'message' => 'Property not found.'
        ], 404);

}


public function updatePropertyDetail(Request $req){
        // dd($req->all());

        try{
            
            $req->validate([
                'property_id' => 'required|numeric|exists:propertys,id',
                'title' => 'required|string',
                'description' => 'required|string',           
                'facilities' => 'required', 
                'address' => 'required',                   
            ]);

            $property = Property::findOrFail($req->property_id);

            $data = [                
                'description' => $req->description,
                'address'     => $req->address,
                'property_category_id' => $req->property_category_id,
                'facilities' => json_encode($req->facilities),
            ];

            if($property->title != $req->title){
                // dd('Title has changed, updating slug...');
                $req->validate([                   
                    'slug' => 'required|string|unique:propertys,slug',
                ],
                [
                    'slug' => 'This Title Already Exist In the Database.'
                ]
            );

                $data['slug'] = Str::slug($req->title);
                $data['title'] = $req->title;
            }

            if ($req->hasFile('image')) {   
                $existingImages = json_decode($property->image, true) ?? [];

                $newImages = [];                
                foreach($req->file('image') as $file){
                    $filename = uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('front/img/propertys'), $filename);
                    $newImages[] = $filename;
                }
                $data['image'] = json_encode(array_merge($existingImages, $newImages));
            } 

            $property->update($data);
            return back()->with('success', 'Property details updated successfully.');



        }catch (ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }catch(\Exception $e){
            return back()->with('error', 'Warning : ' .$e->getMessage());       }
    }


Step : 5 


<script>
    $(document).ready(function(){
        $('.edit-details').on('click',function(e){          
            e.preventDefault();
            var url = $(this).data('url');
            // alert(url);
            $.ajax({
                url : url,
                method: 'GET',
                success:function(response){
                    if(response){
                        var dataToString = JSON.stringify(response);
                        console.log(dataToString);
                        $("#editproperty").modal('show');
                        $("#property-id").val(response.id);
                        $("#title").val(response.title);
                        $("#property_category_id").val(response.property_category_id);
                        $("#description").val(response.description);
                        $("#address").val(response.address);
                        $("#existing-images").empty();

                        var images = JSON.parse(response.image);
                        images.forEach(function(image, index){
                            var imageElement = `
                            <div class="image-item" style="display: inline-block; margin-right: 5px;">
                                <img src="{{ asset('front/img/propertys/${image}') }}" class="img-thumbnail" style="width: 100px; height: auto;">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-image="${image}" data-index="${index}" style="display: block; margin-top: 5px;">Delete</button>
                            </div>
                            `;
                            
                            $("#existing-images").append(imageElement);
                        });

                        var facilitiess = JSON.parse(response.facilities);
                        // alert(facilitiess);
                        facilitiess.forEach(function(facility, index){
                            var facilitiesElement = `
                             <div class="col-12" id="facility-inputs2">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="facilities[]" value="${facility}">
                                        <button type="button" class="btn btn-outline-secondary remove-facility" data-index="${index}">
                                            <img src="{{ asset('backend/images/minus.png') }}" style="height:17px;">
                                        </button>
                                    </div>
                                </div>
                            </div>

                            `;
                            $("#facility-inputs2").append(facilitiesElement);

                        });

                        var modalTitle = "Edit " + response.title + " Property";
                        $(".modal-title").text(modalTitle);


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

        $(document).on('click', '.remove-facility', function(){
            $(this).closest('.mb-3').remove();
        });

        $(document).on('click', '#add-facility2', function() {      
          
                // alert(121);
                var newRow = `
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" name="facilities[]">
                            <button type="button" class="btn btn-outline-secondary remove-facility"><img src="{{ asset('backend/images/minus.png') }}" style="height:17px;" ></button>
                        </div>
                    </div>
                `;
                $("#facility-inputs3").append(newRow);
           
        });

        $('form').on('submit', function() {
            $('input[name="facilities[]"]').each(function() {
                if (!$(this).val()) {
                    $(this).closest('.mb-3').remove();
                }
            });
        });



        $(document).on('click','.delete-image', function(){
            var image = $(this).data('image');
            var index = $(this).data('index');
            // alert(image);
            var $imagePath = $(this).closest('.image-item');

            if(confirm('Are you Sure Want To Delete This Image?')){
                $imagePath.remove();

                $.ajax({
                    url : '{{ url('admin/remove/propert/image') }}',
                    method : 'POST',
                    data : {
                        _token: '{{ csrf_token() }}',
                        image: image,
                        index: index,
                        property_id: $("#property-id").val()
                    },
                    success:function(success){
                        if(success){
                            console.log("Image Path Delete Successfully!");
                            $imageItem.fadeOut(400, function() {
                                $(this).remove();
                            });
                        }else{
                            console.error("Error deleting image:", response.message);
                            alert("Error deleting image: " + response.message);
                        }
                    },
                    error:function(error){
                        console.log("An Error occurred:", error);
                    }
                });

              
            } // end of if
        });
    });
</script>
    
