<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Stewardship;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public  function all(Request $request)
    {

     $stewardship=   Stewardship::where('id', $request->id)-> with(['member', 'transactions.contributionType'])->get();

        return response()->json([
            'success' => true,
            'message' => 'All receipts fetched successfully.',
            'receipts' => $stewardship
        ]);
    }
}
