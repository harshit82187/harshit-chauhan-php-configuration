************************************************ How To Send PDF File Via Email *****************************************************



////////////////////////////////////////////////////// Install PDF PAckage /////////////////////////////////////////////////////////

composer require barryvdh/laravel-dompdf

////////////////////////////////////////////////////// Chages In config/app.php File //////////////////////////////////////////////

'providers' => [
	....
	Barryvdh\DomPDF\ServiceProvider::class,
],
  
'aliases' => [
	....
	'PDF' => Barryvdh\DomPDF\Facade::class,
]


//////////////////////////////////////////////////// Controller Side Code //////////////////////////////////////////////////////////

use PDF;


public function transaction_add(Request $request){
        if($request->isMethod('get')){
            return view('admin.transaction.add');
        }else{
            // dd($request->all());
            try{
                $data = [
                    'client_name' => $request->client_name,
                    'client_id'   => $request->id,
                    'client_mobile' => $request->client_mobile,
                    'amount'  => $request->amount,
                    'mode' => $request->mode,
                    'remarks' => $request->remarks,
                    'transaction_id' => $request->transaction_id,
                    'type'    => 'add_funds',
                    'created_at' => now(),
                ];

                $subject = 'Funds Details';
                $email = $request->email;
                $pdf = PDF::loadView('mail.fund-mail', $data);
    
               // Move the $pdf variable inside the callback function
                Mail::send('mail.fund-mail', $data, function($message) use ($subject, $email, $pdf) {
                    $message->to($email);
                    $message->subject($subject)
                            ->attachData($pdf->output(), "funds_details.pdf");
                });
        
                $common = new Common();             
                $portfolio = $common->updateAppPortfolio($request->id, 'add_funds', $request->amount);
                DB::table('transactions')->insert($data);


                return redirect()->route('admin.transaction_list')->with('success', 'Transaction Add Successfully');

            }catch(\Exception $e){
                return back()->with('error','Waring : ' .$e->getMessage());
            }

            

        }
    }


    ////////////////////////////////////////////// View File Code////////////////////////////////////////////////////////////

    <!DOCTYPE html>
<html>
<!-- <head>
 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head> -->
<body>
  
<table style="margin-top: 50px ; border-collapse: collapse;
            width: 100%; " id="dataTable">
    <thead>
            <tr>
                <th colspan="4" style="text-align: center ; border-bottom: none;   border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
            "><img src="https://eskayinvestments.in/assets/img/logo/logo_eskayinvestments_crop.png" style="width: 100px; height: 100px;margin-left:-6.5rem" alt="logo">
            
            </th>
              
            </tr>
            <tr>
            <th colspan="4" style="text-align: center; border-top: none; border-bottom: none;   border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
           ">Business Enclave, 407, Pan Card Club Rd, Baner, Pune, Maharashtra 411045</th>
                
            </tr>
            <tr>
                <th colspan="4" style="text-align: center; border-top: none; border-bottom: none;   border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
          ">investmentseskay@gmail.com , swapnil@eskayinvestments.in</th>
            
                
            </tr>
            <tr>
                <th colspan="4" style="text-align: center; border-top: none;   border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
            ">Contact no. &nbsp; +91 98199 91851</th>
            </tr>
        </thead>
        <thead>
            <tr>
                <th colspan="4" style="text-align: center;   border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
            "><strong> Eskay Investment</strong></th>
            </tr>
        </thead>

        <tbody>
            
            <tr>
                <th style="  border: 1px solid black; background-color: #f2f2f2;
            padding: 8px;
            text-align: left;" colspan="2">Receipt Date</th>
                <td  colspan="2" style="text-align: left;   border: 1px solid black;
            padding: 8px;
            "> {{ $created_at ?? '--' }}
            </td>
            
            </tr>
            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2; padding: 8px;text-align: left;">Client Name</th>
                <td colspan="2" style="text-align: left;  border: 1px solid black; padding: 8px;">                  
                {{ $client_name ?? '--' }}
                </td>              
            </tr>

            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2; padding: 8px;text-align: left;">Mobile No</th>
                <td colspan="2" style="text-align: left;  border: 1px solid black; padding: 8px;">                  
                {{ $client_mobile ?? '--' }}
                </td>              
            </tr>

            
           
            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2;padding: 8px;text-align: left;">Amount</th>
                <td colspan="2" style="  border: 1px solid black; padding: 8px;text-align: left;">{{  $amount ?? '--' }}</td>               
            </tr>

            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2;padding: 8px;text-align: left;">Mode</th>
                <td colspan="2" style="  border: 1px solid black; padding: 8px;text-align: left;">{{ $mode ?? '--' }}</td>               
            </tr>

            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2;padding: 8px;text-align: left;">Transaction Id</th>
                <td colspan="2" style="  border: 1px solid black; padding: 8px;text-align: left;">{{ $transaction_id ?? '--'  }}</td>               
            </tr>

            <tr>
                <th colspan="2" style="  border: 1px solid black; background-color: #f2f2f2;padding: 8px;text-align: left;">Type</th>
                <td colspan="2" style="  border: 1px solid black; padding: 8px;text-align: left;">
                {{ $type ?? '--' }}
            </td>               
            </tr>

            
         
       
            <tr>
                <td colspan="4" style="  border-bottom: none; text-align: center; 
                  border: 1px solid black;
            padding: 8px;
            ">Employer Signature</td>
               
            </tr>
            <tr >
                <td colspan="4" style="  border-top: none; text-align: right; height:60px ;  border: 1px solid black;
            padding: 8px;
           ">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTv3Rpb9eC8Pd2TLe4DO9-E3Quz6uaFDtQO6A&usqp=CAU" style="width: 120px;" alt="">
                </td>
               
            </tr>
            <tr >
                <td colspan="4" style=" text-align: center;   border: 1px solid black;
            padding: 8px;
           "><a style="text-decoration: none; color: black;" href="#">Withdrawal Receipt</a></td>
               
            </tr>
           

        </tbody>
    </table>

  
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var printContents = document.getElementById('dataTable').outerHTML;
            var originalContents = document.body.innerHTML;    
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;


            $(document).ready(function(){
				setTimeout(() => {
					console.log(1);
					window.location.href = '{{ route("admin.transaction_list") }}';  // where you want to transfer this page
				}, 2000);
			});
        });


    </script> 


</body>
</html>