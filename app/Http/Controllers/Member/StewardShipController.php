<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ContributionType;
use App\Models\Member;
use App\Models\Stewardship;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StewardShipController extends Controller
{
  public function index(Request $request)
{
    $query = Stewardship::with(['member', 'transactions.contributionType']);

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
    }else{
        $query->whereDate('created_at', now());

    }

    $stewardships = $query->get();
    $contributionTypes = ContributionType::all();
     $members = Member::get();

    return view('stewardship.index', compact('members','stewardships', 'contributionTypes'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'types' => 'array|required',
        'amounts' => 'array',
        'member_id' => 'nullable',
    ]);


    if ($request->member_id === 'new') {
        $member = Member::create([
            'full_name'    => $request->new_full_name,
            'phone_number' => $request->new_phone_number,
            'email'        => $request->new_email,
            'date_of_birth'=> $request->new_dob,
        ]);
        $memberId = $member->id;
    } else {
        $memberId = $request->member_id;
    }


    $stewardship = StewardShip::create([
        'member_id' => $memberId,
        'payment_method' => $request->payment_method ?? 'Cash',
        'transaction_reference' => $request->transaction_reference ?? null,
        'total_amount' => array_sum($request->amounts),
        'description' => $request->description ?? $request->notes,
        'recorded_by' => Auth::id(),
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

    return back()->with('success', 'Contributions recorded successfully.');
}



}
