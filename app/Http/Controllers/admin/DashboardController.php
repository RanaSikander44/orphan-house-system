<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ChildActivity;
use App\Models\ChildActivityImages;
use App\Models\notifications;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use Carbon\Carbon;
use Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\readnotifications;
use DB;



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


        $userId = Auth::id();

        // Fetch notifications that the user has not read
        $notifications = DB::table('notifications')
            ->leftJoin('readnotifications', function ($join) use ($userId) {
                $join->on('notifications.id', '=', 'readnotifications.notification_id')
                    ->where('readnotifications.user_id', '=', $userId);
            })
            ->whereNull('readnotifications.notification_id') // Only include notifications not read
            ->select('notifications.*') // Select only the notifications columns
            ->get();



        return view('admin.dashboard', compact('users_count', 'students', 'latestActivity', 'imagesOfCActivity' , 'notifications'));
    }
}
