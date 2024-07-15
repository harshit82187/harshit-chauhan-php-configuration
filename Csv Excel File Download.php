******************* Add Library In Controller ***********************
use Rap2hpoutre\FastExcel\FastExcel;


************************ Controller Side Code ****************************



public function downloadData($id)
{
    $excel = Excel::find($id);

    if ($excel) {
        $transactions = Transaction::where('excel_id', $excel->id)->get();

        $data = [];

        foreach ($transactions as $transaction) {
            $data[] = [
                'V-Run ID'      => $transaction->vin_no,
                'Name'          => $transaction->name,
                'Number'        => $transaction->mobile,
                'Payment Date'  => date('Y-m-d', strtotime($transaction->payment_date)),
                'Amount Paid'   => $transaction->amount,
                'Status'        => $transaction->status,
                'Remark'        => $transaction->remark,
            ];
        }

        return (new FastExcel($data))->download('Transactions.xlsx');
    } else {
        return back()->with('error', 'The uploaded Excel file does not exist');
    }
}











********************* Blade File Code *************************

<a href="{{ route('admin.downloadData', $excel->id) }}" class="mx-2"><i
    class="fa fa-download" style="color:black"></i></a>