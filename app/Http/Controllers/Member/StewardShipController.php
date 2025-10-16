<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StewardShipController extends Controller
{
    public function index()
    {
        $members = collect([
            (object) ['id' => 1, 'full_name' => 'John Doe'],
            (object) ['id' => 2, 'full_name' => 'Jane Smith'],
            (object) ['id' => 3, 'full_name' => 'Alice Johnson'],
        ]);

        $offerings = collect([
            (object) ['id' => 1, 'member' => $members[0], 'type' => 'Offering', 'amount' => 100, 'date' => '2025-10-15', 'notes' => 'Sunday offering'],
            (object) ['id' => 2, 'member' => $members[1], 'type' => 'Offering', 'amount' => 200, 'date' => '2025-10-15', 'notes' => 'Morning offering'],
        ]);

        $tithes = collect([
            (object) ['id' => 1, 'member' => $members[0], 'type' => 'Tithe', 'amount' => 150, 'date' => '2025-10-15', 'notes' => 'Monthly tithe'],
        ]);

        $thanksGiving = collect([
            (object) ['id' => 1, 'member' => $members[2], 'type' => 'Thanks Giving', 'amount' => 300, 'date' => '2025-10-14', 'notes' => 'Special thanks giving'],
        ]);

        $otherOfferings = collect([
            (object) ['id' => 1, 'member' => $members[1], 'type' => 'Other', 'amount' => 50, 'date' => '2025-10-13', 'notes' => 'Camp meeting donation'],
        ]);
        return view('stewardship.index', compact('members', 'offerings', 'tithes', 'thanksGiving', 'otherOfferings'));
    }
}
