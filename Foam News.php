@extends('front.layouts.master')

@section('content')
<style>
	.formheadng1 {
		font-size: 20px;
	}

	.formheadng {
		font-size: 22px;
	}

	.formsss label {
		margin-top: 10px;
	}

	.lab {
		font-weight: 500;
	}

	.cont-width {
		width: 80%;
		border: 1px solid rgb(216, 212, 212);
		border-radius: 3px;
		background-color: white;
	}

	.form-control {
		height: 32px !important;
		padding: 2px !important;

	}

	.alig {
		margin-bottom: 5px;
	}
</style>

<div class="container cont-width mt-4 mb-4">
	<h3 class="mb-4 mt-4 text-center formheadng">News Reporter Application Form</h3>
	<form class="" action="{{ url('join/store') }}" id="" method="POST" enctype="multipart/form-data">
		@csrf
		<!-- A) Personal Information -->
		<h4 class="formheadng1">Personal Information</h4>
		<div class="row mb-3">

			<div class="col-md-6">
				<div class="form-group">
					<label for="roleId" class="form-label">Applied For <span style="color:red;">*</span></label>
					<select class="form-control" id="roleId" name="role_id" required>
						<option value="">Select Applied For</option>
						<option value="1" @if(old('role_id')=='1' ) selected @endif>Reporter</option>
						<option value="4" @if(old('role_id')=='4' ) selected @endif>Input Desk</option>
						<option value="5" @if(old('role_id')=='5' ) selected @endif>Editor</option>
						<option value="6" @if(old('role_id')=='6' ) selected @endif>Chief Editor</option>
					</select>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="fullName" class="form-label">Full Name <span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="fullName" name="name" value="{{ old('name') }}" required>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label for="dob" class="form-label">Date of Birth <span style="color:red;">*</span></label>
					<input type="date" class="form-control" id="dob" name="date_of_birth" required value="{{ old('date_of_birth') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="gender" class="form-label">Gender <span style="color:red;">*</span></label>
					<select class="form-control" id="gender" name="gender" required>
						<option value="">Select Gender</option>
						<option value="male" @if(old('gender')=='male' ) selected @endif>Male</option>
						<option value="female" @if(old('gender')=='female' ) selected @endif>Female</option>
						<option value="other" @if(old('gender')=='other' ) selected @endif>Other</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="bloodGroup" class="form-label">Blood Group <span style="color:red;">*</span></label>
					<select class="form-control" id="bloodGroup" name="blood_group" required>
						<option value="">Select Blood Group</option>
						<option value="A+" @if(old('blood_group')=='A+' ) selected @endif>A+</option>
						<option value="A-" @if(old('blood_group')=='A-' ) selected @endif>A-</option>
						<option value="B+" @if(old('blood_group')=='B+' ) selected @endif>B+</option>
						<option value="B-" @if(old('blood_group')=='B-' ) selected @endif>B-</option>
						<option value="AB+" @if(old('blood_group')=='AB+' ) selected @endif>AB+</option>
						<option value="AB-" @if(old('blood_group')=='AB-' ) selected @endif>AB-</option>
						<option value="O+" @if(old('blood_group')=='O+' ) selected @endif>O+</option>
						<option value="O-" @if(old('blood_group')=='O-' ) selected @endif>O-</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="maritalStatus" class="form-label">Martial Status <span style="color:red;">*</span></label>
					<select class="form-control" id="maritalStatus" name="marital_status" required>
						<option value="">Select Martial Status</option>
						<option value="single" @if(old('marital_status')=='single' ) selected @endif>Single</option>
						<option value="married" @if(old('marital_status')=='married' ) selected @endif>Married</option>
						<option value="divorced" @if(old('marital_status')=='divorced' ) selected @endif>Divorced</option>
						<option value="widowed" @if(old('marital_status')=='widowed' ) selected @endif>Widowed</option>
					</select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="fatherName" class="form-label">Father’s Name <span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="fatherName" name="father_name" required value="{{ old('father_name') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="motherName" class="form-label">Mother’s Name <span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="motherName" name="mother_name" required value="{{ old('mother_name') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="contactNumber" class="form-label">Contact Number <span style="color:red;">*</span></label>
					<input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone" maxlength="10" name="phone" required value="{{ old('phone') }}">
					@error('phone')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="contactNumber" class="form-label">Whatsapp Number <span style="color:red;">*</span></label>
					<input type="number" class="form-control @error('whatsapp_phone') is-invalid @enderror" id="whatsapp_phone" maxlength="10" name="whatsapp_phone" required value="{{ old('whatsapp_phone') }}">
					@error('whatsapp_phone')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="alternateContactNumber" class="form-label">Alternate Contact Number </label>
					<input type="number" class="form-control @error('alternative_phone') is-invalid @enderror" id="alternative_phone" maxlength="10" name="alternative_phone" value="{{ old('alternative_phone') }}">
					@error('alternative_phone')
						<div class="invalid-feedback">{{ $message }}</div>
					@enderror
					<div id="password_error" style="color:red;"></div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="emailAddress" class="form-label">E-mail Address <span style="color:red;">*</span></label>
					<input type="email" class="form-control" id="emailAddress" name="email" required value="{{ old('email') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="aadharNumber" class="form-label">UID (Aadhar) Number <span style="color:red;">*</span></label>
					<input type="number" class="form-control" id="aadharNumber" name="aadhar_number" maxlength="12" required value="{{ old('aadhar_number') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="voterIdNumber" class="form-label">Voter ID Number</label>
					<input type="text" class="form-control" id="voterIdNumber" name="voter_id_number" value="{{ old('voter_id_number') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="panNumber" class="form-label">PAN Number <span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="panNumber" name="pan_number" maxlength="10" required value="{{ old('pan_number') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="passportNumber" class="form-label">Passport No</label>
					<input type="text" class="form-control" id="passportNumber" name="passport_number" value="{{ old('passport_number') }}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="communicationAddress" class="form-label">Communication Address <span style="color:red;">*</span></label>
					<textarea class="form-control" id="communicationAddress" name="communication_address" rows="3" required>{{ old('communication_address') }}</textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="permanentAddress" class="form-label">Permanent Address <span style="color:red;">*</span></label>
					<textarea class="form-control" id="permanentAddress" name="permanent_address" rows="3" required>{{ old('permanent_address') }}</textarea>
				</div>
			</div>
		</div>
		<h4 class="mt-4 formheadng1">Professional Information</h4>
		<div class="row mb-3">
			<div class="col-md-6">
				<div class="form-group">
					<div>
						<label for="prevWorkExperience" class="form-label lab">Previous Work Experience (if any) <span style="color:red;">*</span></label>
					</div>
					<label for="prevEmployer" class="form-label">Name of Previous Employer </label>
					<input type="text" class="form-control" id="prevEmployer" name="prev_employer" value="{{ old('prev_employer') }}">
					<label for="positionHeld" class="form-label mt-3">Position Held </label>
					<input type="text" class="form-control" id="positionHeld" name="position_held" value="{{ old('position_held') }}">
					<label for="durationOfEmployment" class="form-label mt-3">Duration of Employment </label>
					<input type="text" class="form-control" id="durationOfEmployment" name="duration_of_employment" value="{{ old('duration_of_employment') }}">
					<label for="keyResponsibilities" class="form-label mt-3">Key Responsibilities </label>
					<textarea class="form-control" id="keyResponsibilities" name="key_responsibilities" rows="3">{{ old('key_responsibilities') }}</textarea>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<div>
						<label for="eduQualifications" class="form-label lab">Educational Qualifications <span style="color:red;">*</span></label>
					</div>
					<label for="highestQualification" class="form-label">Highest Qualification Attained </label>
					<input type="text" class="form-control" id="highestQualification" name="highest_qualification" value="{{ old('highest_qualification') }}">
					<label for="institutionName" class="form-label mt-3">Name of Institution </label>
					<input type="text" class="form-control" id="institutionName" name="institution_name" value="{{ old('institution_name') }}">
					<label for="degreeCourse" class="form-label mt-3">Degree/Course </label>
					<input type="text" class="form-control" id="degreeCourse" name="degree_course" value="{{ old('degree_course') }}">
					<label for="yearOfGraduation" class="form-label mt-3">Year of Graduation</label>
					<input type="text" class="form-control" id="yearOfGraduation" name="year_of_graduation" value="{{ old('year_of_graduation') }}">
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="expertiseInterest" class="form-label">Areas of Expertise/Interest in News Reporting <span style="color:red;">*</span></label>
					<textarea class="form-control" id="expertiseInterest" name="expertise_interest" rows="3">{{ old('expertise_interest') }}</textarea>
				</div>
			</div>
		</div>
		<h4 class="mt-4 formheadng1">Documentation Upload</h4>
		<div class="row mb-3">
			<div class="col-md-4">
				<div class="form-group">
					<label for="resume" class="form-label">Upload Resume/CV </label>
					<input type="file" class="form-control" id="resume" name="resume_file" accept=".pdf, .doc, .docx">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="portfolio" class="form-label">Portfolio (if available)</label>
					<input type="file" class="form-control" id="portfolio" name="portfolio_file" accept=".pdf, .doc, .docx">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="passportPhoto" class="form-label">Passport Size Photo (White Background) <span style="color:red;">*</span></label>
					<input type="file" class="form-control" id="passportPhoto" name="passport_photo_file" accept="image/*" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="aadhar" class="form-label">UID (Aadhar) <span style="color:red;">*</span></label>
					<input type="file" class="form-control" id="aadhar" name="aadhar_file[]" accept="image/*" multiple required>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label for="pan" class="form-label">PAN <span style="color:red;">*</span></label>
					<input type="file" class="form-control" id="pan" name="pan_file[]" accept="image/*" multiple required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="voterId" class="form-label">Voter ID Card </label>
					<input type="file" class="form-control" id="voterId" name="voter_file[]" accept="image/*" multiple>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="passport" class="form-label">Passport </label>
					<input type="file" class="form-control" id="passport" name="passport_file[]" accept="image/*" multiple>
				</div>
			</div>
		</div>
		<h4 class="mt-4 formheadng1">Additional Information</h4>
		<div class="row mb-3">
			<div class="col-md-6">
				<div class="form-group">
					<label for="referenceName" class="form-label">References - Name </label>
					<input type="text" class="form-control" id="referenceName"  name="reference_name" value="{{old('reference_name')}}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="contactInformation" class="form-label">References - Contact Information </label>
					<input type="text" class="form-control" id="contactInformation" name="contact_information" value="{{old('contact_information')}}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="expectedSalary" class="form-label">Expected Salary/Compensation </label>
					<input type="text" class="form-control" id="expectedSalary" name="expected_salary" value="{{old('expected_salary')}}">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="availability" class="form-label">Availability to Start </label>
					<input type="date" class="form-control" id="availability" name="availability" value="{{old('availability')}}">
				</div>
			</div>
		</div>
		<div class="mb-3">
			<div class="form-group">
				<label for="additionalComments" class="form-label">Any Additional Comments/Information</label>
				<textarea class="form-control" id="additionalComments" name="additional_comments" rows="3">{{old('additional_comments')}}</textarea>
			</div>
		</div>
		<div class="form-group form-check d-flex  align-items-center">
			<input type="checkbox" class="form-check-input mt-2 alig" id="exampleCheck1 required" name="checkbox" required @if(old('checkbox')) checked @endif>
			<label class="form-check-label" for="exampleCheck1"><a class="text-dark" href="{{url('terms-conditions')}}">Terms and Conditions.</a></label>
		</div>
		<div class="form-group form-check d-flex">
			<input type="checkbox" class="form-check-input mt-2 alig declare" id="exampleCheck2 required" name="checkbox" required>
			<label class="form-check-label" for="exampleCheck2"><a class="text-dark" href="{{asset('/web-assets/pdf/newinfo.pdf')}}">I hereby declare that the information provided above is true and accurate to the best of my knowledge. I understand that any false information provided may lead to disqualification or termination of employment if appointed or immediate termination of your association with Bharat News 360 TV.</a></label>
		</div>
		<!-- Submit Button -->
		<div class="mt-4 mb-4">
			<button type="submit" id="submit_button" class="btn btn-primary submitBtn">Submit</button>
		</div>
	</form>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
	const declare = document.querySelector('.declare').addEventListener('change', function(){
		if(this.checked){
			 const pdfPath =  "/public/web-assets/pdf/newinfo.pdf";
			 window.open(pdfPath, '_blank');
		}
	})
</script>

<script>
	 let phone = document.getElementById("phone");
	 let alternative_phone = document.getElementById("alternative_phone");
	 var button = $('#submit_button');

	 console.log(phone); console.log(alternative_phone);

	 alternative_phone.addEventListener('input', function() {
        if (phone.value == alternative_phone.value) {
            password_error.textContent = "Enter Another Alternate Contact Number";
            button.prop('disabled', true);
        } else {
            password_error.textContent = "";
            button.prop('disabled', false);
        }
    });


	function validateAlphabeticalInput(input) {
            // Replace any non-alphabetical characters with an empty string
            input.value = input.value.replace(/[^A-Z a-z]/g, '');
        }

		function validateNumericInput(input) {		
		     input.value = input.value.replace(/[^0-9]/g, '');		
	    	 input.value = input.value.slice(0, 12);
		}

		function validatePanCard(input){
				
	    	input.value = input.value.slice(0, 10);
		}

		document.getElementById('resume').addEventListener('change', function() {
        var file = this.files[0];
        var allowedTypes = ['image/jpeg', 'image/jpg', 'application/pdf'];

        // Check if the selected file's type is allowed
        if (!allowedTypes.includes(file.type)) {
            alert('Please upload only JPEG/JPG or PDF files.');
            this.value = ''; // Clear the file input
        }
    });

       
</script>

@endsection