<?php

namespace App\Http\Controllers\Member;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Generate a random collection of 100 expenses
        $expenses = collect(range(1, 100))->map(function ($i) {
            $items = ['Stationery', 'Transport', 'Snacks', 'Office Supplies', 'Electricity Bill', 'Internet', 'Maintenance', 'Fuel'];
            
            return (object) [
                'id' => $i,
                'item' => $items[array_rand($items)],
                'amount' => rand(1000, 100000) / 100,
                'date' => now()->subDays(rand(0, 60))->format('Y-m-d'),
                'description' => 'Random generated expense record #' . $i,
            ];
        });

        // Optional: Filter by search
        if ($request->filled('search')) {
            $expenses = $expenses->filter(function ($expense) use ($request) {
                return str_contains(strtolower($expense->item), strtolower($request->search)) ||
                       str_contains(strtolower($expense->description), strtolower($request->search));
            });
        }

        // Optional: Filter by date
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $expenses = $expenses->filter(function ($expense) use ($request) {
                return $expense->date >= $request->from_date && $expense->date <= $request->to_date;
            });
        }

        // Simulate pagination manually
        $perPage = 10;
        $currentPage = $request->input('page', 1);
        $pagedData = $expenses->forPage($currentPage, $perPage);

        $paginatedExpenses = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $expenses->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('expenses.index', ['expenses' => $paginatedExpenses]);
    }
}
