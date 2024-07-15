
************************** Step 1 *******************************

<!-- Create Table in the Database -->

table name - voucher_edit

id    int(11)   auto increment
type1  longtext
type2  longtext 
agency_name  longtext 
created_at 
updated_at 





************************** Step 2 *******************************


<!-- create_transport.blade.php file code  -->
@component('components.widget', ['class' => 'box-primary'])
       
       @slot('tool')
           <div class="row">
               <div class="col-lg-6" >
               <h3 class="heading">Transport One </h3>
               </div>
               <div class=" col-lg-6 box-tools">
                   <button  type="button" class="btn btn-block btn-primary btn-modal btnntn" 
                   data-toggle="modal" data-target="#add_transport1">
                   <i class="fa fa-plus"></i> @lang('messages.add')</button>
               </div>
           </div>
          
       @endslot
  
   
   <!--dd(auth()->user()->email);-->
       <div class="table-responsive">
           <table class="table table-bordered table-striped" id="contact_table1">
               <thead>
                   <tr>
                           <th>S No.</th>  
                           <th>Transport Type</th>  
                           <th>@lang('messages.action')</th>
                      
                   </tr>
               </thead>

               <tbody>
                   
                   @foreach($voucher_edit as $data)
                       @php
                           $decodedType1 = json_decode($data->type1, true);
                       @endphp

                           @if(is_array($decodedType1))
                             
                              @foreach($decodedType1 as $index => $type)
                               <tr class="bg-gray font-17 text-center footer-total">
                                   <td>{{ $loop->iteration }}</td>
                                   <td>{{ $type}}</td>
                                   <td>
                                       <a href="#" data-toggle="modal" data-target="#transport_1_edit{{$index}}" class="btn btn-info btn-sm mr-4">Edit</a>

                                       <a href="{{ action('LabelsController@delete_transport1', $index) }}" onclick="return confirm('Are you want delete?')" class="btn btn-danger btn-sm mr-4">Delete</a>
                                       
                                   </td>                           
                                   
                               </tr>

                            <!-- Edit Transport 1 Modal -->
                                <div class="modal" id="transport_1_edit{{$index}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="margin-left:273px; margin-top:71px; width:424px">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Transport Two</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal Body -->
                                            <div class="modal-body">
                                                <!-- Your Form -->
                                                {!! Form::open(['url' => action('LabelsController@edit_transport1'), 'method' => 'post']) !!}
                                                    
                                                    <input type="hidden" name="index" value="{{ $index }}">											
                                                    
                                                    <div class="form-group">
                                                        <label for="question">Enter Transport Name</label>
                                                        <input type="text" class="form-control" required name="type1" value="{{$type}}" >
                                                    </div>	
                                                    
                                                    <div class="form-group">
                                                    <select class="form-control" name="status">
                                                    <option value="1" {{ $categories->status == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ $categories->status == 0 ? 'selected' : '' }}>In-Active</option>
                                                    </select>

                                                    </Mdiv>
                                                    
                                                    
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- End Edit Transport 1 Modal -->
                                   
                            
                            @endforeach
                           @endif						

                   @endforeach
               </tbody>
           </table>
       </div>


@endcomponent


************************** Step 3 *******************************

<!-- Add Transport Modal Code -->
<!-- Modal Bootsrap Js  -->

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   
     <div class="modal" id="add_transport1">
							<div class="modal-dialog modal-lg">
								<div class="modal-content" style="margin-left:273px; margin-top:71px; width:424px">
									<!-- Modal Header -->
									<div class="modal-header">
										<h4 class="modal-title">Add Transport One</h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<!-- Modal Body -->
									<div class="modal-body">
										<!-- Your Form -->
										{!! Form::open(['url' => action('LabelsController@create_transport1'), 'method' => 'post']) !!}
											

											
											<div class="form-group">
												<label for="question">Enter Transport Name</label>
												<input type="text" class="form-control" required name="type1" >
											</div>



											
											<div class="form-group">
												<button type="submit" class="btn btn-success">Save</button>
											</div>
                                            {!! Form::close() !!}
									</div>
								</div>
							</div>
     </div>
                         <!-- End Edit Two Wheeler Modal -->




    
</section>
<!-- End Add Transport Modal Code -->






************************** Step 4 *******************************

<!-- Controller Side Code To Add, Edit And Delete Function  -->

public function create_transport1(Request $request){
        // dd($request->all());
       
        $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();

        if ($latestRecord) {
            $t1 = json_decode($latestRecord->type1, true);
            $t1[] = $request->type1;
            
            DB::table('voucher_edit')
                ->where('id', $latestRecord->id)
                ->update(['type1' => json_encode($t1)]);
        }else {
            // Handle the case when there are no records in the table yet
            DB::table('voucher_edit')->insert(['type1' => json_encode([$request->type1])]);
        }

       
        return back()->with('success','Details Add Successfully');
    }

    public function edit_transport1(Request $request)
    {
        // Validate the request
        $request->validate([
            'index' => 'required|integer', // Adjust as needed
            'type1' => 'required|string',   // Adjust as needed
        ]);
    
        try {
            // Retrieve the latest record
            $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();
    
            if ($latestRecord) {
                // Decode the existing JSON data
                $t1 = json_decode($latestRecord->type1, true);
    
                // Update the specified index with the new type1 value
                $t1[$request->index] = $request->type1;
    
                // Update the record in the database
                DB::table('voucher_edit')
                    ->where('id', $latestRecord->id)
                    ->update(['type1' => json_encode($t1)]);
    
                return back()->with('success', 'Details updated successfully');
            } else {
                return back()->with('error', 'Record not found');
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    

    public function delete_transport1($id){
       
        $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();
        if ($latestRecord) {
            // Decode the existing JSON data
            $t1 = json_decode($latestRecord->type1, true);


            // Delete the value at the specified index
            unset($t1[$id]);

            // Reindex the array after deletion
            $t1 = array_values($t1);

            // Update the record in the database
            DB::table('voucher_edit')
                ->where('id', $latestRecord->id)
                ->update(['type1' => json_encode($t1)]);

            return back()->with('error', 'Details Delete successfully');
        } else {
            return back()->with('error', 'Record not found');
        }
        return back()->with('error','Details Delete Successfully');

    }





    ************************** Step 5 *******************************

    <!-- Route File Code -->
    Route::post('/save-transport1', 'LabelsController@create_transport1');
    Route::post('/edit-transport1', 'LabelsController@edit_transport1');
    Route::get('/delete-transport1/{id}', 'LabelsController@delete_transport1');










    *************************** Step 6 ************************************
    <!-- Show Data On Frotend -->
    @php
			$description = json_decode(DB::table('voucher_edit')->first()->description, true);
			@endphp

			@foreach($description as $data)
			<li>
				** {{$data }}
			</li>
	@endforeach








    /////////////////////// if you have edit multiple column and that column show in one table ////////////////////////////////
    @component('components.widget', ['class' => 'box-primary'])
       
         @slot('tool')
		        <div class="row">
					<div class="col-lg-6" >
						<h3 class="heading">Company Contact Details</h3>
					</div>
					<div class=" col-lg-6 box-tools">
						<button  type="button" class="btn btn-block btn-primary btn-modal btnntn" 
						data-toggle="modal" data-target="#add_company_contact">
						<i class="fa fa-plus"></i> @lang('messages.add')</button>
					</div>
				</div>
         @endslot
   
   
		 <div class="table-responsive">
    <table class="table table-bordered table-striped" id="contact_table5">
        <thead>
            <tr>
                <th>S No.</th>
                <th>Location1</th>
                <th>Location1 Name1</th>
                <th>Location1 No1</th>
                <th>Location1 Name2</th>
                <th>Location1 No2</th>
                <th>Location2</th>
                <th>Location2 Name1</th>
                <th>Location2 No1</th>
                <th>Location2 Name2</th>
                <th>Location2 No2</th>
                <th>@lang('messages.action')</th>
            </tr>
        </thead>

        <tbody>
            @foreach($voucher_edit as $index => $data)
                @php
                    $decodedType1 = json_decode($data->location1, true);
                    $decodedType2 = json_decode($data->location1_name1, true);
                    $decodedType3 = json_decode($data->location1_no1, true);
                    $decodedType4 = json_decode($data->location1_name2, true);
                    $decodedType5 = json_decode($data->location1_no2, true);
                    $decodedType6 = json_decode($data->location2, true);
                    $decodedType7 = json_decode($data->location2_name1, true);
                    $decodedType8 = json_decode($data->location2_no1, true);
                    $decodedType9 = json_decode($data->location2_name2, true);
                    $decodedType10 = json_decode($data->location2_no2, true);
                @endphp

                @if(is_array($decodedType1))
                    @foreach($decodedType1 as $innerIndex => $type)
                        <tr class="bg-gray font-17 text-center footer-total">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type }}</td>
                            <td>{{ $decodedType2[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType3[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType4[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType5[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType6[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType7[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType8[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType9[$innerIndex] ?? '' }}</td>
                            <td>{{ $decodedType10[$innerIndex] ?? '' }}</td>

                            <td style="display:flex; gap:2px;">
                                <a href="#" data-toggle="modal" data-target="#description_name{{ $index }}_{{ $innerIndex }}" class="btn btn-info btn-sm mr-4">Edit</a>
                                <a href="{{ action('LabelsController@delete_company_details', $innerIndex) }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-sm mr-4">Delete</a>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal" id="description_name{{ $index }}_{{ $innerIndex }}">
                            <!-- Modal Content -->
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="margin-left:184px; margin-top:71px; width:718px">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Company Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <!-- Your Form -->
                                        {!! Form::open(['url' => action('LabelsController@edit_company_details'), 'method' => 'post']) !!}
											<div class="row">
												<input type="hidden" name="index" value="{{ $innerIndex }}">
												
												<!-- Add other hidden fields as needed -->



												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_english" class="form-label">First Location Name </span></label>
														<input type="text" class="form-control" name="location1" value="{{ $type }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Name</label>
														<input type="text" class="form-control" name="location1_name1" value="{{ $decodedType2[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Mobile No</label>
														<input type="text" class="form-control" name="location1_no1" value="{{ $decodedType3[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Name</label>
														<input type="text" class="form-control" name="location1_name2" value="{{ $decodedType4[$innerIndex] }}"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Mobile No</label>
														<input type="text" class="form-control" name="location1_no2" value="{{ $decodedType5[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>


											</div><br><br>

											<div class="row">

											
												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_english" class="form-label">Enter Second Location Name </span></label>
														<input type="text" class="form-control" name="location2" value="{{ $decodedType6[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Name</label>
														<input type="text" class="form-control" name="location2_name1" value="{{ $decodedType7[$innerIndex] }}"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Mobile No</label>
														<input type="text" class="form-control" name="location2_no1"  value="{{ $decodedType8[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Name</label>
														<input type="text" class="form-control" name="location2_name2" value="{{ $decodedType9[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Mobile No</label>
														<input type="text" class="form-control" name="location2_no2" value="{{ $decodedType10[$innerIndex] }}" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
													</div>
													
												</div>


												<div class="col-md-6">
												 <button type="submit" class="btn btn-success" style="margin-top: 73px; margin-left: -357px;">Update</button>
											    </div>
												{!! Form::close() !!}
                                            



											</div>
                                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Modal -->
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>





    <!-- Add Modal -->

    <div class="modal" id="add_company_contact">
							<div class="modal-dialog modal-lg">
								<div class="modal-content" style="margin-left:184px; margin-top:71px; width:718px">
									<!-- Modal Header -->
									<div class="modal-header">
										<h4 class="modal-title">Add Company Name </h4>
										<button type="button" class="close" data-dismiss="modal">&times;</button>
									</div>
									<!-- Modal Body -->
									<div class="modal-body">
										<!-- Your Form -->
										{!! Form::open(['url' => action('LabelsController@create_add_company_contact'), 'method' => 'post']) !!}

											<div class="row">

											
												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_english" class="form-label">Enter First Location Name </span></label>
														<input type="text" class="form-control" name="location1" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Name</label>
														<input type="text" class="form-control" name="location1_name1"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Mobile No</label>
														<input type="text" class="form-control" name="location1_no1"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Name</label>
														<input type="text" class="form-control" name="location1_name2"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Mobile No</label>
														<input type="text" class="form-control" name="location1_no2"  required autocomplete="off">
													</div>
												</div>



											</div><br><br>

											<div class="row">

											
												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_english" class="form-label">Enter Second Location Name </span></label>
														<input type="text" class="form-control" name="location2" required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Name</label>
														<input type="text" class="form-control" name="location2_name1"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter First Person Mobile No</label>
														<input type="text" class="form-control" name="location2_no1"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Name</label>
														<input type="text" class="form-control" name="location2_name2"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
														<label for="title_hindi" class="form-label">Enter Second Person Mobile No</label>
														<input type="text" class="form-control" name="location2_no2"  required autocomplete="off">
													</div>
												</div>

												<div class="col-md-6">
													<div class="mb-3">
													</div>
													
												</div>


												<div class="col-md-6">
												 <button type="submit" class="btn btn-success" style="margin-top: 73px; margin-left: -357px;">Save</button>
											    </div>
                                             {!! Form::close() !!}



											</div>
											
											
											
											
									</div>
								</div>
							</div>
    </div>






    ******************************** Web File Code ************************************
    Route::post('/save-company-name', 'LabelsController@create_add_company_contact'); 
    Route::post('/edit-company-name', 'LabelsController@edit_company_details');
    Route::get('/delete-company-name/{id}', 'LabelsController@delete_company_details');




    <!------------------------------- Controller Side Code ------------------------  -->


    public function create_add_company_contact(Request $request){
        try {
            $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();
    
            if ($latestRecord) {
                $location1 = json_decode($latestRecord->location1, true);
                $location1 = is_array($location1) ? $location1 : [];
                $location1[] = $request->location1;

                $location1_name1 = json_decode($latestRecord->location1_name1, true);
                $location1_name1 = is_array($location1_name1) ? $location1_name1 : [];
                $location1_name1[] = $request->location1_name1;

                $location1_no1 = json_decode($latestRecord->location1_no1, true);
                $location1_no1 = is_array($location1_no1) ? $location1_no1 : [];
                $location1_no1[] = $request->location1_no1;

                $location1_name2 = json_decode($latestRecord->location1_name2, true);
                $location1_name2 = is_array($location1_name2) ? $location1_name2 : [];
                $location1_name2[] = $request->location1_name2;

                $location1_no2 = json_decode($latestRecord->location1_no2, true);
                $location1_no2 = is_array($location1_no2) ? $location1_no2 : [];
                $location1_no2[] = $request->location1_no2;

                $location2 = json_decode($latestRecord->location2, true);
                $location2 = is_array($location2) ? $location2 : [];
                $location2[] = $request->location2;

                $location2_name1 = json_decode($latestRecord->location2_name1, true);
                $location2_name1 = is_array($location2_name1) ? $location2_name1 : [];
                $location2_name1[] = $request->location2_name1;

                $location2_no1 = json_decode($latestRecord->location2_no1, true);
                $location2_no1 = is_array($location2_no1) ? $location2_no1 : [];
                $location2_no1[] = $request->location2_no1;

                $location2_name2 = json_decode($latestRecord->location2_name2, true);
                $location2_name2 = is_array($location2_name2) ? $location2_name2 : [];
                $location2_name2[] = $request->location2_name2;

                $location2_no2 = json_decode($latestRecord->location2_no2, true);
                $location2_no2 = is_array($location2_no2) ? $location2_no2 : [];
                $location2_no2[] = $request->location2_no2;

    
    
                DB::table('voucher_edit')
                    ->where('id', $latestRecord->id)
                    ->update([
                        'location1' => json_encode($location1),
                        'location1_name1' => json_encode($location1_name1),
                        'location1_no1' => json_encode($location1_no1),
                        'location1_name2' => json_encode($location1_name2),
                        'location1_no2' => json_encode($location1_no2),
                        'location2' => json_encode($location2),
                        'location2_name1' => json_encode($location2_name1),
                        'location2_no1' => json_encode($location2_no1),
                        'location2_name2' => json_encode($location2_name2),
                        'location2_no2' => json_encode($location2_no2),
                    ]);
            } else {

                $data = [
                        'location1' => json_encode([$request->location1]),
                        'location1_name1' => json_encode([$request->location1_name1]),
                        'location1_no1' => json_encode([$request->location1_no1]),
                        'location1_name2' => json_encode([$request->location1_name2]),
                        'location1_no2' => json_encode([$request->location1_no2]),
                        'location2' => json_encode([$request->location2]),
                        'location2_name1' => json_encode([$request->location2_name1]),
                        'location2_no1' => json_encode([$request->location2_no1]),
                        'location2_name2' => json_encode([$request->location2_name2]),
                        'location2_no2' => json_encode([$request->location2_no2]),
                    
                ];

                DB::table('voucher_edit')->insert($data);
            }
    
            return back()->with('success', 'Company Details Add Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Warning: ' . $e->getMessage());
        }        
    }

    public function edit_company_details(Request $request){
        // dd($request->all());
        try {
            // Retrieve the latest record
            $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();
    
            if ($latestRecord) {
                // Decode the existing JSON data
                $t1 = json_decode($latestRecord->location1, true);
                $t2 = json_decode($latestRecord->location1_name1, true);
                $t3 = json_decode($latestRecord->location1_no1, true);
                $t4 = json_decode($latestRecord->location1_name2, true);
                $t5 = json_decode($latestRecord->location1_no2, true);
                $t6 = json_decode($latestRecord->location2, true);
                $t7 = json_decode($latestRecord->location2_name1, true);
                $t8 = json_decode($latestRecord->location2_no1, true);
                $t9 = json_decode($latestRecord->location2_name2, true);
                $t10 = json_decode($latestRecord->location2_no2, true);
                
    
                // Update the specified index with the new type1 value
                $t1[$request->index] = $request->location1;
                $t2[$request->index] = $request->location1_name1;
                $t3[$request->index] = $request->location1_no1;
                $t4[$request->index] = $request->location1_name2;
                $t5[$request->index] = $request->location1_no2;

                $t6[$request->index] = $request->location2;
                $t7[$request->index] = $request->location2_name1;
                $t8[$request->index] = $request->location2_no1;
                $t9[$request->index] = $request->location2_name2;
                $t10[$request->index] = $request->location2_no2;
    
                // Update the record in the database
                DB::table('voucher_edit')
                ->where('id', $latestRecord->id)
                ->update([
                    'location1' => json_encode($t1),
                    'location1_name1' => json_encode($t2),
                    'location1_no1' => json_encode($t3),
                    'location1_name2' => json_encode($t4),
                    'location1_no2' => json_encode($t5),
                    'location2' => json_encode($t6),
                    'location2_name1' => json_encode($t7),
                    'location2_no1' => json_encode($t8),
                    'location2_name2' => json_encode($t9),
                    'location2_no2' => json_encode($t10),
                ]);
    
                return back()->with('success', 'Details updated successfully');
            } else {
                return back()->with('error', 'Record not found');
            }
        } catch (\Exception $e) {
            // Handle any exceptions or errors
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function delete_company_details($id){
        // dd($id);
        $latestRecord = DB::table('voucher_edit')->latest('created_at')->first();
        if ($latestRecord) {
            // Decode the existing JSON data
            $t1 = json_decode($latestRecord->location1, true);
            $t2 = json_decode($latestRecord->location1_name1, true);
            $t3 = json_decode($latestRecord->location1_no1, true);
            $t4 = json_decode($latestRecord->location1_name2, true);
            $t5 = json_decode($latestRecord->location1_no2, true);
            $t6 = json_decode($latestRecord->location2, true);
            $t7 = json_decode($latestRecord->location2_name1, true);
            $t8 = json_decode($latestRecord->location2_no1, true);
            $t9 = json_decode($latestRecord->location2_name2, true);
            $t10 = json_decode($latestRecord->location2_no2, true);
           


            // Delete the value at the specified index
            unset($t1[$id]);
            unset($t2[$id]);
            unset($t3[$id]);
            unset($t4[$id]);
            unset($t5[$id]);
            unset($t6[$id]);
            unset($t7[$id]);
            unset($t8[$id]);
            unset($t9[$id]);
            unset($t10[$id]);

            // Reindex the array after deletion
            $t1 = array_values($t1);
            $t2 = array_values($t2);
            $t3 = array_values($t3);
            $t4 = array_values($t4);
            $t5 = array_values($t5);
            $t6 = array_values($t6);
            $t7 = array_values($t7);
            $t8 = array_values($t8);
            $t9 = array_values($t9);
            $t10 = array_values($t10);


            // Update the record in the database
            DB::table('voucher_edit')
                ->where('id', $latestRecord->id)
                ->update([
                    'location1' => json_encode($t1),
                    'location1_name1' => json_encode($t2),
                    'location1_no1' => json_encode($t3),
                    'location1_name2' => json_encode($t4),
                    'location1_no2' => json_encode($t5),
                    'location2' => json_encode($t6),
                    'location2_name1' => json_encode($t7),
                    'location2_no1' => json_encode($t8),
                    'location2_name2' => json_encode($t9),
                    'location2_no2' => json_encode($t10),

                ]);

            return back()->with('error', 'Details Delete successfully');
        } else {
            return back()->with('error', 'Record not found');
        }
        return back()->with('error','Details Delete Successfully');
    }