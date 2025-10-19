<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\SabbathSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SabbathSchoolController extends Controller
{
    /**
     * Display all Sabbath Schools.
     */
    public function show($id)
    {
        $school = SabbathSchool::findOrFail($id);


    $allMembers = Member::get();
     $members = $school->members()->orderBy('full_name')->get();
        return view('member.int-sabbathschool', compact('school', 'allMembers','members'));
    }

    /**
     * Store a new Sabbath School.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255|unique:sabbath_schools,name',
            'code'             => 'nullable|string|max:50|unique:sabbath_schools,code',
            'division'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'meeting_location' => 'nullable|string|max:255',
            'meeting_time'     => 'nullable|string|max:100',
            'is_active'        => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sabbathSchool = SabbathSchool::create($request->all());

        return response()->json([
            'message' => 'Sabbath School created successfully!',
            'sabbathSchool' => $sabbathSchool
        ], 201);
    }

    /**
     * Update a Sabbath School.
     */
    public function update(Request $request, $id)
    {
        $sabbathSchool = SabbathSchool::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'             => 'sometimes|required|string|max:255|unique:sabbath_schools,name,' . $sabbathSchool->id,
            'code'             => 'nullable|string|max:50|unique:sabbath_schools,code,' . $sabbathSchool->id,
            'division'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'meeting_location' => 'nullable|string|max:255',
            'meeting_time'     => 'nullable|string|max:100',
            'is_active'        => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $sabbathSchool->update($request->all());

        return response()->json([
            'message' => 'Sabbath School updated successfully!',
            'sabbathSchool' => $sabbathSchool
        ], 200);
    }

    /**
     * Delete a Sabbath School.
     */
    public function destroy($id)
    {
        $sabbathSchool = SabbathSchool::findOrFail($id);
        $sabbathSchool->delete();

        return response()->json(['message' => 'Sabbath School deleted successfully!'], 200);
    }




public function addMember(Request $request, $id)
{
    $request->validate([
        'member_id' => 'required|exists:members,id',
        'role' => 'required|string|in:Chairman,Secretary,Spiritual Leader,Treasurer,Member',
    ]);

    $school = SabbathSchool::findOrFail($id);

    $school->members()->syncWithoutDetaching([
        $request->member_id => ['role' => $request->role]
    ]);

    return redirect()->back()->with('success', 'Member added successfully!');
}

public function removeMember($school_id, $member_id)
{
    $school = SabbathSchool::findOrFail($school_id);
    $school->members()->detach($member_id);

    return redirect()->back()->with('success', 'Member removed successfully!');
}


}
