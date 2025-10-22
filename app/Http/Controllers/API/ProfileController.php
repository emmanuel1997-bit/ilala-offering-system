<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function show(Request $request)
{

    $request->validate([
        'id' => 'required|integer',
    ]);


    $member = Member::find($request->id);

    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'Member not found.',
            'profile' => null
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Profile fetched successfully.',
        'profile' => $member
    ]);
}
public function update(Request $request, $id)
{

    $member = Member::find($id);
    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'Member not found.',
        ], 404);
    }

    $data = $request->except('photo');

    if ($request->hasFile('photo')) {

        if ($member->photo && file_exists(storage_path('app/public/' . $member->photo))) {
            unlink(storage_path('app/public/' . $member->photo));
        }


        $data['photo'] = $request->file('photo')->store('members', 'public');
    }

    $member->update($data);
    return response()->json([
        'success' => true,
        'message' => 'Member updated successfully.',
        'member' => $member
    ]);
}



}
