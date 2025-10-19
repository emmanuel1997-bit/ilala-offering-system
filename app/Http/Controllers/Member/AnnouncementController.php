<?php


namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use App\Http\Controllers\Controller;

class AnnouncementController extends Controller
{
    public function index()
    {
          $announcements = Announcement::orderBy('publish_date', 'desc')->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
             'category' => 'nullable|string',
            'publish_date' => 'required|date',
            'is_published' => 'nullable|boolean',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('announcements', 'public');
            $validated['image'] = $path;
        }

        Announcement::create($validated);

        return redirect()->back()->with('success', 'Announcement created successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        $announcement->delete();
        return redirect()->back()->with('success', 'Announcement deleted successfully.');
    }
}
