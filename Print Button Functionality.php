

********************** Add Print Button In Table *********************
<td>                                          

    <a href="{{ route('admin.printDoc',$data->id) }}" id="printButton" class="btn btn-primary">Print</a>
    
</td> 




*********************** Controller Side Code *************************
use NumberFormatter;

public function printDoc($id)
{
    //  dd($id);
    $transaction = Transaction::findorfail($id);
    if (!$id) {
        return back()->with('error', 'Something Wrong!');
    } else {
        // Convert the amount to words
        $formatter = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        $amountInWords = ucfirst($formatter->format($transaction->amount));

        return view('admin-dashboard.pdf.transaction', compact('transaction', 'amountInWords'));
    }
}




*********************** transaction.blade.php File Code ******************************

create table
<table style="margin-top: 50px" id="dataTable">
</table>

Add Script 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var printContents = document.getElementById('dataTable').outerHTML;
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;

			$(document).ready(function(){
				setTimeout(() => {
					console.log(1);
					window.location.href = '{{ route("both_voucher") }}';  // where you want to transfer this page
				}, 2000);
			});
				});
	</script>