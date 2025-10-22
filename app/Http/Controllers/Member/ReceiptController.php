<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ContributionType;
use App\Models\Stewardship;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
  public function index(Request $request)
    {
        // Sample members
        $members = collect([
            (object)['id' => 1, 'full_name' => 'John Doe'],
            (object)['id' => 2, 'full_name' => 'Jane Smith'],
            (object)['id' => 3, 'full_name' => 'Michael Johnson'],
        ]);

        // Sample receipts
        $receipts = collect([
            (object)['id' => 101, 'member' => $members[0], 'amount' => 100, 'status' => 'unchecked', 'created_at' => now()->subDays(1)],
            (object)['id' => 102, 'member' => $members[1], 'amount' => 150, 'status' => 'verified', 'created_at' => now()],
            (object)['id' => 103, 'member' => $members[2], 'amount' => 200, 'status' => 'unchecked', 'created_at' => now()],
            (object)['id' => 104, 'member' => $members[0], 'amount' => 50, 'status' => 'verified', 'created_at' => now()],
        ]);

        // Separate collections for each tab
        $uncheckedReceipts = $receipts->where('status', 'unchecked');
        $todaysReceipts = $receipts->filter(function ($r) {
            return $r->created_at->isToday();
        });
        $allReceipts = $receipts;
        $stewardships = Stewardship::with('member', 'transactions.contributionType')->get();
        $contributionTypes=ContributionType::all();

        return view('stewardship.receipt', compact(
            'uncheckedReceipts',
            'todaysReceipts',
            'allReceipts',
            'stewardships',
            'contributionTypes'
        ));
    }

    // Sample action for verify/unverify
    public function verify($id)
    {
        // In real app, update status in DB
        return back()->with('success', "Receipt #$id verified.");
    }

    public function unverify($id)
    {
        // In real app, update status in DB
        return back()->with('success', "Receipt #$id unverified.");
    }

    // Sample action for sending messages
    public function sendMessage(Request $request)
    {
        $ids = $request->input('receipts', []);
        // In real app, send message logic here
        return back()->with('success', "Messages sent for receipts: " . implode(', ', $ids));
    }

    // Sample action for printing PDF
    public function printSelected(Request $request)
    {
        $ids = $request->input('receipts', []);
        // In real app, generate PDF here
        return back()->with('success', "PDF generated for receipts: " . implode(', ', $ids));
    }

    // Sample view single receipt
    public function view($id)
    {
        $member = (object)['id' => 1, 'full_name' => 'John Doe'];
        $receipt = (object)['id' => $id, 'member' => $member, 'amount' => 100, 'status' => 'verified', 'created_at' => now(), 'notes' => 'Sample notes'];
        return view('receipts.view', compact('receipt'));
    }


}
