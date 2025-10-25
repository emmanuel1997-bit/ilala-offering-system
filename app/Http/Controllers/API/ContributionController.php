<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContributionType;
use App\Models\Stewardship;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ContributionController extends Controller
{
 public function types()
 {
$type =ContributionType::get();
 return response()->json([
        'success' => true,
        'message' => 'Contribution types fetched successfully.',
        'contributionType' => $type
    ]);

 }

public function store(Request $request)
{
    $validated = $request->validate([
        'types' => 'array|required',
        'amounts' => 'array',
        'member_id' => 'nullable',
        'attachment_url' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        'payment_method' => 'nullable|string',
        'transaction_reference' => 'nullable|string',
        'description' => 'nullable|string',
    ]);

    $image_url = $request->hasFile('attachment_url')
        ? $request->file('attachment_url')->store('members', 'public')
        : null;


    $stewardship = Stewardship::create([
        'member_id' => $request->member_id,
        'payment_method' => $request->payment_method ?? 'Cash',
        'transaction_reference' => $request->transaction_reference ?? null,
        'total_amount' => is_array($request->amounts) ? array_sum($request->amounts) : 0,
        'description' => $request->description ?? $request->notes,
        'attachment_image_url' => $image_url,
    ]);


    foreach ($validated['types'] as $typeId) {
        $amount = $request->amounts[$typeId] ?? null;

        if (!is_null($amount) && $amount !== '') {
            Transaction::create([
                'stewardships_id' => $stewardship->id,
                'contribution_type_id' => $typeId,
                'amount' => $amount,
            ]);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Stewardship created successfully.',
        'stewardship' => $stewardship
    ]);
}



}
