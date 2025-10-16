<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
       public function index(Request $request)
    {
        // --- SAMPLE DATA ---
        $sampleData = collect([
           (object) ['id' => 1, 'source' => 'Tithes', 'amount' => 250000, 'date' => '2025-10-14', 'description' => 'Monthly church tithes'],
          (object)  ['id' => 2, 'source' => 'Offerings', 'amount' => 100000, 'date' => '2025-10-15', 'description' => 'Sunday offerings'],
           (object) ['id' => 3, 'source' => 'Donation - John Doe', 'amount' => 500000, 'date' => '2025-10-15', 'description' => 'Community support donation'],
           (object) ['id' => 4, 'source' => 'Youth Ministry Fund', 'amount' => 75000, 'date' => '2025-10-16', 'description' => 'Youth event contribution'],
            (object)['id' => 5, 'source' => 'Sabbath School', 'amount' => 120000, 'date' => '2025-10-16', 'description' => 'Weekly Sabbath School offering'],
           (object) ['id' => 6, 'source' => 'Building Fund', 'amount' => 900000, 'date' => '2025-10-12', 'description' => 'Church renovation project'],
        ]);

        // --- SEARCH & FILTER LOGIC ---
        $filtered = $sampleData;

        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $filtered = $filtered->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['source']), $search)
                    || str_contains(strtolower($item['description']), $search);
            });
        }

        if ($request->filled('date')) {
            $filtered = $filtered->where('date', $request->date);
        }

        // --- PAGINATION SIMULATION ---
        $perPage = 5;
        $page = $request->get('page', 1);
        $paged = $filtered->forPage($page, $perPage);

        $incomes = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $filtered->count(),
            $perPage,
            $page,
            ['path' => url()->current()]
        );

        // --- RETURN TO VIEW ---
        return view('income.index', compact('incomes'));
    }
}