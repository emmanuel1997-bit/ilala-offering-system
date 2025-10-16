<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MinistryController extends Controller
{
    public function index(Request $request)
    {
        $ministries = collect([
            (object)[
                'id' => 1,
                'name' => 'Youth Ministry',
                'chairman' => 'John Doe',
                'secretary' => 'Jane Smith',
                'treasurer' => 'Peter Pan',
                'budget' => 5000,
                'description' => 'Youth activities and events'
            ],
            (object)[
                'id' => 2,
                'name' => 'Women Ministry',
                'chairman' => 'Mary Jane',
                'secretary' => 'Ann Brown',
                'treasurer' => 'Lucy White',
                'budget' => 7000,
                'description' => 'Women empowerment and community programs'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            (object)[
                'id' => 3,
                'name' => 'Music Ministry',
                'chairman' => 'Michael Clark',
                'secretary' => 'Sara Lee',
                'treasurer' => 'David King',
                'budget' => 3000,
                'description' => 'Choir and music events'
            ],
            
        ]);

        $year = $request->input('year', date('Y'));

      
        $ministries = $ministries->forPage($request->input('page', 1), 10);

        return view('ministry.index', compact('ministries', 'year'));
    }
}