<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Models\Stewardship;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{

public function generateReceipt(Request $request)
{
    $ids = $request->input('ids'); // IDs of checked stewardships


    if (empty($ids)) {
        return "No receipts selected.";
    }


    $stewardships = Stewardship::with(['member', 'transactions.contributionType'])
                        ->whereIn('id', [$ids])
                        ->get();


    // Prepare payload for PDF view
    $contributionTypes = \App\Models\ContributionType::all();
    $payload = ['stewardship' => $stewardships->toArray(),
            'contributionTypes' => $contributionTypes->toArray()];

    // $stewardships->map(function($stewardship) use ($contributionTypes) {
    //     return [
    //         'stewardship' => $stewardship->toArray(),
    //         'contributionTypes' => $contributionTypes->toArray()
    //     ];
    // })->toArray();


    //  echo json_encode($payload);
    $pdf = Pdf::loadView('pdf.receipt', compact('payload'));
    return $pdf->stream("receipt.pdf");
}

}



