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
          $announcements = collect([
        (object)[
            'id' => 1,
            'title' => 'Sunday Service Reminder',
            'description' => 'Join us this Sunday at 9 AM for the main service.',
            'publish_date' => '2025-10-20',
            'image' => null, 
        ],
        (object)[
            'id' => 2,
            'title' => 'Bible Study Meeting',
            'description' => 'Wednesday evening Bible study at 6 PM.',
            'publish_date' => '2025-10-18',
            'image' => null,
        ],
        (object)[
            'id' => 3,
            'title' => 'Charity Event',
            'description' => 'Community charity event on Saturday. Bring donations!',
            'publish_date' => '2025-10-25',
            'image' => null,
        ],
        (object)[
            'id' => 4,
            'title' => 'Youth Camp',
            'description' => 'Annual youth camp from Nov 1–5. Sign up at the office.',
            'publish_date' => '2025-11-01',
            'image' => null,
        ],
    ]);
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publish_date' => 'required|date',
            'image' => 'nullable|image|max:2048', // max 2MB
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
