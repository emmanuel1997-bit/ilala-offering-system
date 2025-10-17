<?php

namespace App\Http\Controllers\Member;
namespace App\Http\Controllers;

use App\Models\SabbathSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SabbathSchoolController extends Controller
{
    /**
     * Display all Sabbath Schools.
     */
    public function index()
    {
        $sabbathSchools = SabbathSchool::orderBy('name')->get();
        return view('sabbath_school.index', compact('sabbathSchools'));
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
}
