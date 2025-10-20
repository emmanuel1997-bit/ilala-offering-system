<?php

namespace App\Http\Controllers\Setting;

use App\Models\ContributionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ContributionTypeController extends Controller
{
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'contribution_name' => 'required|string|max:255',
            'church_percentage' => 'required|integer|min:0|max:100',
            'conference_percentage' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
        ]);

        ContributionType::create($validated);

        return redirect()->back()->with('success', 'Contribution type created successfully.');
    }

   

     public function update(Request $request, $id)
    {
        $type = ContributionType::findOrFail($id);

        $validated = $request->validate([
            'contribution_name' => 'required|string|max:255',
            'church_percentage' => 'required|integer|min:0|max:100',
            'conference_percentage' => 'required|integer|min:0|max:100',
            'description' => 'nullable|string',
        ]);

        $type->update($validated);

        return redirect()->back()->with('success', 'Contribution type updated successfully.');
    }
    public function destroy( $id)
    {
      
        $contribution=ContributionType::findOrFail($id);
        $contribution->delete();

        return redirect()->back()->with('success', 'Contribution type deleted successfully.');
    }
}
