///////////// send the data through the ajax (with image upload file) ///////////////////////////////////

<div class="container-fluid steps brand_step_2">
			<form enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-lg-12 text-center mb-4 hide-h1">
						<h1>It would be super easy for us to understand you, if you upload any flyers, brochures or marketing material!</h1>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-10 labels">
						<label for="brand_loc">Product Category</label>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-10 m-auto select-cat">
						<select name="brand_product_category" id="brand_product_category" style="width: 70%;border-bottom: 1px solid white;">
							<option disabled selected hidden>Choose a Category</option>
							<option value="security">Security</option>
							<option value="lighting">Lighting</option>
						
						</select>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-10 labels">
						<label for="brand2_prod">Introduce Product</label>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-8 col-10 m-auto">
						<textarea type="" name="brand_introduce_product" id="brand_introduce_product" placeholder="Write Briefly"></textarea>
					</div>

					<div class="col-lg-4 col-md-4 col-sm-4 col-10  labels">
						<label>Upload Material</label>
					</div>
					<div class="col-lg-8 col-md-6 col-sm-6 col-10 auto-div">
						<ul class="add_input w-100">
							<li><input type="file" name="brand_material_file" id="brand_material_file"  placeholder="Choose File">
								<h2 class="div-add">+</h2>
							</li>
						</ul>
					</div>

					<div class="col-lg-6 next_prev my-4">
						<a onclick="backFun('brand_step_1', 'brand_step_2')"><i class="fa fa-angle-left" aria-hidden="true"></i><span>&nbsp;&nbsp;Prev</span></a>
						<a class="marketing_material" data-form="abd_step_1"><span>Next&nbsp;&nbsp;</span><i class="fa fa-angle-right" aria-hidden="true"></i></a>
					</div>
				</div>
			</form>
		</div>



/////////////////////// Ajax Code //////////////////////////////////////////

<script>
    $(document).ready(function(){
			$(document).on('click', '.marketing_material', function(){
				// alert("hyyy");

				var formdata = new FormData();

				var csrfToken = $('meta[name="csrf-token"]').attr('content');
				var brand_product_category = $('#brand_product_category').val();
				var brand_introduce_product = $('#brand_introduce_product').val();

				var brand_material_file_input = document.querySelector('input[name="brand_material_file"]');
				if(brand_material_file_input.files.length > 0){
					formdata.append('brand_material_file', brand_material_file_input.files[0]);
				}

				formdata.append('_token',csrfToken);
				formdata.append('brand_introduce_product',brand_introduce_product);
				formdata.append('brand_product_category',brand_product_category);

				console.log(brand_product_category);  console.log(brand_introduce_product); console.log(brand_material_file);

				$.ajax({
					type: "POST",
					url: "{{ route('marketing_material') }}",
					data: formdata,		
					processData: false, 
          			contentType: false,			
					success: function (response) {
						if(response.success){
							setTimeout( () => {
								changeClass('brand_step_2', 'brand_step_3');
							}, 500);
							console.log("It would be super easy for us to understand you, if you upload any flyers, brochures or marketing material Sent Successfully");
						}else if (response.status == 422) {
							let data = ['brand_product_category', 'brand_introduce_product', 'brand_material_file'];
							if (response.errors) {
								data.forEach(element => {
									if (response.errors[element]) {
										alert(response.errors[element]);
									}
								});
							}
						}
						console.log(response.errors);
						
					},
					error:function(error){
						console.error("Error Sending Data :" +error);
					}
				});
			});
		});
</script>



********************************** controller side code *********************************************
public function marketingMaterial(Request $request){
    try{
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'brand_product_category'  => 'required',
            'brand_introduce_product' => 'required',
            'brand_material_file'     => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ]);
        }

        $data = $request->all();

        if ($request->hasFile('brand_material_file')) {
            $file = $request->file('brand_material_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploaded_files'), $filename);

        }

        $existingData = Cookie::get('appointments', []);

        if ($existingData && DB::table('appointments')->where('id', $existingData)->exists()) {
                $data = DB::table('appointments')->where('id', $existingData)->update([
                'brand_product_category'  => $data['brand_product_category'],
                'brand_introduce_product' => $data['brand_introduce_product'],
                'brand_material_file'     => $filename,
            ]);
        
        } else {

                $data = DB::table('appointments')->insertGetId([
                    'brand_product_category'  => $data['brand_product_category'],
                    'brand_introduce_product' => $data['brand_introduce_product'],
                    'brand_material_file'     => $filename,
            ]);

            // Store the merged data in the cookie
            Cookie::queue('appointments', $data, 3600);
        }
        return response()->json(['success' => true, 'message' => 'It would be super easy for us to understand you, if you upload any flyers, brochures or marketing material Sent Successfully']);

    }catch(\Exception $e){
        return response()->json(['success' => false, 'catch-message' => 'Error : ' .$e->getMessage()], 500);           
    }



}
