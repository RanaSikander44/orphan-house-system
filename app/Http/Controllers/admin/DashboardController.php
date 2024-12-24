<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChildActivity;
use App\Models\ChildActivityImages;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $users_count = user::count();
        $students = student::count();

        $latestActivity = ChildActivity::whereDate('activity_date', Carbon::today())
            ->orderByDesc('created_at')
            ->first();
        if (!empty($latestActivity)) {
            $imagesOfCActivity = ChildActivityImages::where('activity_id', $latestActivity->id)->get();
        } else {
            $imagesOfCActivity = 'empty';
        }



        return view('admin.dashboard', compact('users_count', 'students', 'latestActivity', 'imagesOfCActivity'));
    }
}
