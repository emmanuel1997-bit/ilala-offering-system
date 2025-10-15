<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{

public function generateReceipt()
{
    $receipt = [
        'number' => '21337',
        'name' => 'Emmanuel Juma',
        'church' => 'Ilala',
        'amount_words' => 'Laki mbili na elfu arobaini',
        'date' => '07/05/2025',
        'zaka' => 120000,
        'sadaka_pamoja_iof' => 69600,
        'sadaka_kambi' => 0,
        'sadaka_pamoja_kanisani' => 50400,
        'sadaka_majengo' => 0,
    ];

    $pdf = Pdf::loadView('pdf.receipt', compact('receipt'));
    return $pdf->stream("receipt-{$receipt['number']}.pdf");
}
}



