<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;

use function Ramsey\Uuid\v1;

class MemberController extends Controller
{
     public function index()
    {

        $ministries = collect([
            (object) ['id' => 1, 'name' => 'Youth Ministry', 'leader' => 'John Doe'],
            (object) ['id' => 2, 'name' => 'Music Ministry', 'leader' => 'Jane Smith'],
            (object) ['id' => 3, 'name' => 'Outreach Ministry', 'leader' => 'Alice Johnson'],
        ]);

        $members = collect([
            (object) [
                'id' => 1,
                'full_name' => 'John Doe',
                'phone_number' => '0712345678',
                'gender' => 'Male',
                'address' => 'Dar es Salaam',
                'photo' => null,
                'ministry' => $ministries[0],
            ],
            (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],
             (object) [
                'id' => 2,
                'full_name' => 'Jane Smith',
                'phone_number' => '0723456789',
                'gender' => 'Female',
                'address' => 'Dodoma',
                'photo' => null,
                'ministry' => $ministries[1],
            ],

            (object) [
                'id' => 3,
                'full_name' => 'Alice Johnson jumanee',
                'phone_number' => '0734567890',
                'gender' => 'Female',
                'address' => 'Arusha',
                'photo' => null,
                'ministry' => $ministries[2],
            ],
        ]);
        $sabbathSchools = collect([
    (object) ['id' => 1, 'name' => 'Children SS'],
    (object) ['id' => 2, 'name' => 'Youth SS'],
    (object) ['id' => 3, 'name' => 'Adult SS'],
]);

        return view('member.index', compact('members', 'ministries', 'sabbathSchools'));
    }
}

