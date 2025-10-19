<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\SabbathSchool;
use Illuminate\Support\Facades\Validator;

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
        $members = Member::get();
        $schools = SabbathSchool::get();
        return view('member.index', compact('members', 'ministries', 'schools'));
    }



     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:members,phone_number',
            'email' => 'nullable|email|unique:members,email',
            'membership_number' => 'nullable|string|unique:members,membership_number',
            'dob' => 'nullable|date',
            'gender' => 'required|in:Male,Female',
            'membership_status' => 'nullable|in:Active,Guest,Inactive',
            'baptism_status' => 'nullable|in:Active,Inactive',
            'pin' => 'nullable|string|max:10',
            'pin_status' => 'nullable|in:Active,Pending,Inactive',
            'baptism_date' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('photo');

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member = Member::create($data);

        return response()->json(['message' => 'Member created successfully'], 201);
    }

    /**
     * Update an existing member.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20|unique:members,phone_number,' . $member->id,
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'membership_number' => 'nullable|string|unique:members,membership_number,' . $member->id,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'membership_status' => 'nullable|in:Active,Guest,Inactive',
            'baptism_status' => 'nullable|in:Active,Inactive',
            'pin' => 'nullable|string|max:10',
            'pin_status' => 'nullable|in:Active,Pending,Inactive',
            'baptism_date' => 'nullable|date',
            'marital_status' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            // delete old photo if exists
            if ($member->photo && file_exists(storage_path('app/public/members/' . $member->photo))) {
                unlink(storage_path('app/public/members/' . $member->photo));
            }
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);

        return response()->json(['message' => 'Member updated successfully', 'member' => $member], 200);
    }

    /**
     * Delete a member.
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        if ($member->photo && file_exists(storage_path('app/public/' . $member->photo))) {
            unlink(storage_path('app/public/' . $member->photo));
        }

        $member->delete();

        return response()->json(['message' => 'Member deleted successfully'], 200);
    }
}

