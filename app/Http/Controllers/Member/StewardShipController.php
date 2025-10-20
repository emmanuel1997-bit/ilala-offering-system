<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ContributionType;
use App\Models\Member;
use Illuminate\Http\Request;

class StewardShipController extends Controller
{
    public function index()
    {
        $members = Member::get();

        // $offerings = collect([
        //     (object) ['id' => 1, 'member' => $members->get(1), 'type' => 'Offering', 'amount' => 100, 'date' => '2025-10-15', 'notes' => 'Sunday offering'],
        //     (object) ['id' => 2, 'member' => $members->get(1), 'type' => 'Offering', 'amount' => 200, 'date' => '2025-10-15', 'notes' => 'Morning offering'],
        // ]);

        // $tithes = collect([
        //     (object) ['id' => 1, 'member' => $members->get(0), 'type' => 'Tithe', 'amount' => 150, 'date' => '2025-10-15', 'notes' => 'Monthly tithe'],
        // ]);

        // $thanksGiving = collect([
        //     (object) ['id' => 1, 'member' => $members->get(2), 'type' => 'Thanks Giving', 'amount' => 300, 'date' => '2025-10-14', 'notes' => 'Special thanks giving'],
        // ]);

        // $otherOfferings = collect([
        //     (object) ['id' => 1, 'member' => $members->get(1), 'type' => 'Other', 'amount' => 50, 'date' => '2025-10-13', 'notes' => 'Camp meeting donation'],
        // ]);

        $contributionTypes  = ContributionType ::get();

        return view('stewardship.index', compact('members','contributionTypes'));
    }
}
