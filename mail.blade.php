
*************************** Create Email Template In Resouce Folder*************************
<table
	style="
	width: 600px;
	margin: 20px auto;
	border: 1px solid #ccc;
	padding: 20px 20px 35px;
	"
	>
	<tbody>
		<tr>
			<td>
				<table style="width: 100%">
					<tbody>
						<tr>
							<td>
								<div style="text-align: center">
									<h2 style="text-transform: uppercase;
										font-weight: 800;
										color: coral;">Indradhanush</h2>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<h4
					style="
					border: 1px solid black;
					width: max-content;
					padding: 8px;
					font-size: 16px;
					font-weight: 600;
					padding-right: 25px;
					margin-bottom: 14px;
					"
					>
					Customer Query
				</h4>
			</td>
		</tr>
		<tr>
			<td>
				<table border="" style="border-collapse: collapse; width: 100%">
					<tbody>
						<tr>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Name
							</td>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								{{ $formData['name'] }}
							</td>
						</tr>
						<tr>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Identity
							</td>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								{{ $formData['identity'] }}
							</td>
						</tr>
						<tr>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Email
							</td>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								{{ $formData['email'] }}
							</td>
						</tr>
						<tr>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								News
							</td>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								{{ $formData['news'] }}
							</td>
						</tr>
						<tr>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Message
							</td>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								{{ $formData['message'] }}
							</td>
						</tr>
						{{-- 
						<tr>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Discount Price (-)
							</td>
							<td style="padding: 0.75rem 2rem">0</td>
						</tr>
						--}}
						{{-- 
						<tr>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Sub Total
							</td>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								1296
							</td>
						</tr>
						--}}
						{{-- 
						<tr>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Breakfast Amount (+)
							</td>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								200
							</td>
						</tr>
						--}}
						{{-- 
						<tr>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Total Price
							</td>
							<td
								style="
								background-color: #d0def2;
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								1496
							</td>
						</tr>
						--}}
						{{-- 
						<tr>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								Passcode
							</td>
							<td
								style="
								padding: 0.75rem 2rem;
								text-transform: uppercase;
								letter-spacing: 0.1rem;
								font-size: 0.7rem;
								"
								>
								584780
							</td>
						</tr>
						--}}
					</tbody>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table style="width: 100%; margin-top: 12px">
					<tbody>
						<tr>
							<td style="width: 50%">
								{{-- <img
									src="https://ci5.googleusercontent.com/proxy/Wt2VwjyBySWZtZj6pfzZO_dWc6wjDn3BEUq0zNjHpsv5bDRCK46cic9sWzy37E9wxFQcup567XKkvZ7RfFYY7Z694ctcvCKFhITWkn9O4ZPbNQkdnhXMCfT-fyiHeYKON5YkHL1CmhFMa4gHKRhBvFyaM4ASeh2IxWKg3ecMBRXJJPypmMr1lh3w5We3tL8JbWudl7tmEE3VsQDkKou-FP8x_zIx=s0-d-e1-ft#https://media.istockphoto.com/id/627892060/photo/hotel-room-suite-with-view.jpg?s=612x612&amp;w=0&amp;k=20&amp;c=YBwxnGH3MkOLLpBKCvWAD8F__T-ypznRUJ_N13Zb1cU="
									alt=""
									style="
									object-fit: cover;
									height: 200px;
									width: 100%;
									border-radius: 8px;
									"
									class="CToWUd a6T"
									data-bit="iit"
									tabindex="0"
									/> --}}
								<div
									class="a6S"
									dir="ltr"
									style="opacity: 0.01; left: 391px; top: 1222.94px"
									>
									<div
										id=":1hh"
										class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q"
										title="Download"
										role="button"
										tabindex="0"
										aria-label="Download attachment "
										jslog="91252; u014N:cOuCgd,Kr2w4b,xr6bB; 4:WyIjbXNnLWY6MTc3Mzc3MTc2NDg4MjgyNTA3MyIsbnVsbCxbXV0."
										data-tooltip-class="a1V"
										>
										<div class="akn">
											<div class="aSK J-J5-Ji aYr"></div>
										</div>
									</div>
								</div>
							</td>
							<td style="width: 50%">
								{{-- <img
									src="https://ci5.googleusercontent.com/proxy/ba1N-2zVbbiDSagEYKGu_u_upyxfpANW1ydBvrea_ZaBTP1CVNswMLf6PbAVoSutGvQt42yN3qWF_b2gYioOUB9hslUru7FNz6Y4cY2qSFO2n-cG-sqd42FtiFstGZfRSxAQ4iYebptvh0Zw2Sij1PDcokVLVVtFV4yvGpHb8fV6iAwgeEWNTVhffX8xol9WW-Le3SB6=s0-d-e1-ft#https://media.cnn.com/api/v1/images/stellar/prod/140127103345-peninsula-shanghai-deluxe-mock-up.jpg?q=w_2226,h_1449,x_0,y_0,c_fill"
									alt=""
									style="
									height: 200px;
									width: 100%;
									object-fit: cover;
									border-radius: 8px;
									"
									class="CToWUd a6T"
									data-bit="iit"
									tabindex="0"
									/> --}}
								<div
									class="a6S"
									dir="ltr"
									style="opacity: 0.01; left: 666px; top: 1222.94px"
									>
									<div
										id=":1hi"
										class="T-I J-J5-Ji aQv T-I-ax7 L3 a5q"
										title="Download"
										role="button"
										tabindex="0"
										aria-label="Download attachment "
										jslog="91252; u014N:cOuCgd,Kr2w4b,xr6bB; 4:WyIjbXNnLWY6MTc3Mzc3MTc2NDg4MjgyNTA3MyIsbnVsbCxbXV0."
										data-tooltip-class="a1V"
										>
										<div class="akn">
											<div class="aSK J-J5-Ji aYr"></div>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td
				align="center"
				valign="top"
				style="padding: 20px 0px 18px; font-size: 16px"
				>
				<span
					style="
					font-weight: 600;
					color: black;
					display: block;
					font-family: Calibri;
					"
					>
				Follow us and write us by</span
					>
			</td>
		</tr>


		<tr>
			<td align="center" valign="top">
				<ul
					style="
					margin: 0px;
					list-style-type: none;
					padding: 0;
					display: inline-flex;
					"
					>
					{{-- 
					<li style="margin: 0 7px">
						<a
							><img
							src="https://ci4.googleusercontent.com/proxy/-I-ELg1g9fL7W1Fr8DWvVXcq5me_pBgv-9IsswITUpHc9j498yj-f3N3W7-f0XgBcwqkn8YHOYRxvEqPd8--BWKHxraCm6YgGqVuHY4i0uYuiQ=s0-d-e1-ft#https://devs.pearl-developer.com/welrm/images/icons/Youtube.ico"
							width="28"
							alt="icon"
							class="CToWUd"
							data-bit="iit"
							/></a>
					</li>
					--}}
					<li style="margin: 0 7px">
						<a href="https://www.instagram.com/studioindradhanush/"
							><img
							src="https://ci6.googleusercontent.com/proxy/bxH9ExCuAcnTz3j6bGczxVwHZDAl4SoD1wW_RqzjLmW8zY71N8IOE-Ztg24xE234VEM80Tw7t_gjko-0gaBNbwtW2nNmlnJlhWPMNf_NgdNBrIm3=s0-d-e1-ft#https://devs.pearl-developer.com/welrm/images/icons/instagram.ico"
							width="28"
							alt="icon"
							class="CToWUd"
							data-bit="iit"
							/></a>
					</li>
					<li style="margin: 0 7px">
						<a href="https://www.facebook.com/studioindradhanush"
							><img
							src="https://ci5.googleusercontent.com/proxy/SGhAX0SIMB4R4POZeTNwF1L_lln0G0FYOqkJXMbTtCEag8Cyw20XFShwKlnVew9p3c2B5uirnlN-OJh_xIvPVyY5ROAUmQ5iwDTHCqj4YeWBugo=s0-d-e1-ft#https://devs.pearl-developer.com/welrm/images/icons/facebook.ico"
							width="28"
							alt="icon"
							class="CToWUd"
							data-bit="iit"
							/></a>
					</li>
					<li style="margin: 0 7px">
						<a href="https://twitter.com/sindradhanush"
							><img
							src="https://ci3.googleusercontent.com/proxy/Oxcc_IN7hT6joowslPL7tRlO80ibLzkxneQuRvMMIZDVihGNGYvB-EgwqW2rez7XRqAXKImpXx6Wj03xnTIUNSVNc4xk4VktzCv2m3Fjsv9cPA=s0-d-e1-ft#https://devs.pearl-developer.com/welrm/images/icons/twitter.ico"
							width="28"
							alt="icon"
							class="CToWUd"
							data-bit="iit"
							/></a>
					</li>
					{{-- 
					<li style="margin: 0 7px">
						<a
							><img
							src="https://ci4.googleusercontent.com/proxy/ia5ogl5eeXtxtVkgcgx_wwgFUE_Djl77jDdiD94LEvegldQgzHTitzsue4KLOM0vMOjfYPv5141vFWR7t_gkt9zMqfm9AXBZHuSPcB5rrWLHDuw=s0-d-e1-ft#https://devs.pearl-developer.com/welrm/images/icons/linkedin.ico"
							width="28"
							alt="icon"
							class="CToWUd"
							data-bit="iit"
							/></a>
					</li>
					--}}
				</ul>
			</td>
		</tr>


		<tr>
			<td
				align="center"
				valign="top"
				style="padding: 0px 0px 10px; font-size: 16px"
				>
				<p style="color: black; margin: 0px; font-family: calibri">
					Copyright © 2021 by Indradhanush. All rights reserved.
				</p>
			</td>
		</tr>


		<tr>
			<td align="center" valign="top" style="font-size: 15px">
				<div style="text-align: center; color: #c80000 !important">
					<a
						style="
						text-decoration: none;
						display: inline-block;
						color: #c80000 !important;
						font-size: 12px;
						font-weight: 700;
						"
						>
					Contact Us
					</a>
					<span style="color: black; padding: 0px 1px">|</span>
					<a
						style="
						text-decoration: none;
						display: inline-block;
						color: #c80000;
						font-size: 12px;
						font-weight: 700;
						"
						>
					Privacy policies
					</a>
					<span style="color: black; padding: 0px 1px">|</span>
					<a
						style="
						text-decoration: none;
						display: inline-block;
						color: #c80000;
						font-size: 12px;
						font-weight: 700;
						"
						>
					Terms and Conditions
					</a>
				</div>
			</td>
		</tr>
    
	</tbody>
</table>




********************* Changes In .env File ************************
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465
MAIL_USERNAME=info@test.pearl-developer.com
MAIL_PASSWORD="SMTP@Hostinger#123"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@test.pearl-developer.com"
MAIL_FROM_NAME="${APP_NAME}"













******************* Without Terminal Mail Send Functionality **************

// Controller Side Code

public function subscriberStore(Request $request){

	try{
		$checkIfUserExist = DB::table('subscribers')->where('subscribers_email', $request->email)->first();
		// dd($checkIfUserExist);
		if(empty($checkIfUserExist)){
			$values = [
				'subscribers_email' => $request->email,
				'subscribers_status' => 0,
				'subscribers_users' => '1',
				'subscribers_created_on' => date('Y-m-d H:i:s'),
			];
			DB::table('subscribers')->insert($values);

			$data = [
				'email' => $request->email, 
			];

			$subject = 'Subscribe Mail';
			$email = $request->email;


			// Send email to the owner
			Mail::send('mail.subscribe_mail', $data, function($message) use ($subject, $email) {
				$message->to($email);
				$message->subject($subject);
			});

			Session::flash('success', 'Subscriber created successfully'); 
			return redirect()->back();
		}else{
			Session::flash('error', 'Subscriber already exist'); 
			return redirect()->back();
		}

	}catch(\Exception $e){
		return back()->with('error',' Warning : ' .$e->getMessage());
	}
		

}




