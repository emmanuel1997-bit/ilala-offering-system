<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {

        $announcements = Announcement::orderBy('created_at', 'desc')
        ->take(5)
        ->get();


        return response()->json(['announcements' => $announcements]);
    }
}
