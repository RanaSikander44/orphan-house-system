<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\child;
use App\Models\ChildActivity;
use App\Models\ChildActivityImages;
use App\Models\nannyChilds;
use App\Models\readnotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\notifications;
use League\CommonMark\Extension\InlinesOnly\ChildRenderer;
use Notification;
use App\Models\Role;
use App\Models\User;
use App\Models\Schools;
use App\Models\Staff;


class ChildActiviesController extends Controller
{
    public function index()
    {
        $activity = ChildActivity::orderBy('id', 'desc')->get();
        return view('admin/childActivity/index', compact('activity'));
    }


    public function add()
    {
        $children = child::all();
        $roles = Role::where('name', 'Nanny')->pluck('id');
        $nannies = User::whereIn('role_id', $roles)->get();
        $schools = Schools::all();
        return view('admin/childActivity/add', compact('children', 'nannies', 'schools'));
    }


    public function store(Request $req)
    {

        $validate = validator::make($req->all(), [
            'child_id' => 'required',
            'name' => 'required',
            'activity_date' => 'required',
            'desc' => 'required',
            'images' => 'required',
        ]);

        $notify = new notifications();
        $notify->message = 'A child new activity has occurred.';
        $notify->save();


        if ($validate->fails()) {
            return redirect()->route('activity.add')->withErrors($validate->errors())->withInput();
        }


        $data = new ChildActivity();
        $data->child_id = $req->child_id;
        $data->name = $req->name;
        $data->activity_date = $req->activity_date;
        $data->desc = $req->desc;
        $data->created_by = Auth::user()->id;

        $data->save();


        foreach ($req->images as $list) {
            // Create a new instance of the ChildActivityImages model
            $images = new ChildActivityImages();
            $images->activity_id = $data->id; // Assuming $data->id is valid

            $uniqueName = uniqid() . '.' . $list->getClientOriginalExtension();
            $list->move(public_path('backend/images/activities/'), $uniqueName);
            $images->image = 'backend/images/activities/' . $uniqueName;
            $images->save();
        }


        // Create Notifications
        return redirect()->route('activity.index')->with('success', 'Activity created !');

    }


    public function edit($id)
    {
        $children = child::all();
        $activity = ChildActivity::findOrFail($id);
        $images = ChildActivityImages::where('activity_id', $activity->id)->get();

        return view('admin/childActivity/edit', compact('children', 'activity', 'images'));
    }



    public function deleteImage($imageId)
    {
        // Find the image by ID
        $image = ChildActivityImages::find($imageId);

        if ($image) {
            // Delete the image file from the server
            $imagePath = public_path('backend/images/activities' . $image->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // Delete the image record from the database
            $image->delete();

            // Return a success response
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found']);
    }


    public function update(Request $req, $id)
    {
        $validate = validator::make($req->all(), [
            'child_id' => 'required',
            'name' => 'required',
            'activity_date' => 'required',
            'desc' => 'required',
            'images' => 'nullable|array', // Make images optional (nullable) and accept an array of images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validate image type and size
        ]);

        if ($validate->fails()) {
            return redirect()->route('activity.index')->withErrors($validate->errors())->withInput();
        }

        // Find the activity by ID
        $data = ChildActivity::findOrFail($id);
        $data->child_id = $req->child_id;
        $data->name = $req->name;
        $data->activity_date = $req->activity_date;
        $data->desc = $req->desc;
        $data->created_by = Auth::user()->id;

        // Update activity
        $data->update();

        // If new images are uploaded, add them
        if ($req->hasFile('images')) {
            foreach ($req->images as $list) {
                $images = new ChildActivityImages();
                $images->activity_id = $data->id;

                $uniqueName = uniqid() . '.' . $list->getClientOriginalExtension();
                $list->move(public_path('backend/images/activities/'), $uniqueName);
                $images->image = 'backend/images/activities/' . $uniqueName;
                $images->save();
            }
        }

        return redirect()->route('activity.index')->with('success', 'Activity updated successfully!');
    }



    public function delete($id)
    {
        $activity = ChildActivity::findOrFail($id);
        ChildActivityImages::where('activity_id', $activity->id)->delete();
        $activity->delete();
        return redirect()->route('activity.index')->with('success', 'Activity Deleted !');
    }


    public function view($id)
    {
        $latestActivity = ChildActivity::where('id', $id)->first();
        if (!empty($latestActivity)) {
            $imagesOfCActivity = ChildActivityImages::where('activity_id', $latestActivity->id)->get();
        } else {
            $imagesOfCActivity = 'empty';
        }
        return view('admin/childActivity/view', compact('latestActivity', 'imagesOfCActivity'));

    }


    public function markasread(Request $req)
    {
        foreach ($req->ids as $list) {
            $data = new readnotifications();
            $data->notification_id = $list;
            $data->user_id = Auth::id();
            $data->read = '1';
            $data->save();
        }

        return response()->json([
            'success' => 'success',
        ]);

    }


    public function filter(Request $req)
    {
        if ($req->nanny_id !== 'null' && $req->school_id !== 'null') {
            $nanny = Staff::where('user_id', $req->nanny_id)->first();

            if (!$nanny) {
                return response()->json(['error' => 'Nanny not found'], 404);
            }

            $childrenQuery = NannyChilds::with(['child.school'])
                ->where('nanny_id', $nanny->id)
                ->whereHas('child', function ($query) use ($req) {
                    if ($req->school_id && $req->school_id !== 'null') {
                        $query->where('school_id', $req->school_id);
                    }
                });

            $children = $childrenQuery->get();

            $result = $children->map(function ($nannyChild) {
                return [
                    'id' => $nannyChild->child->id,
                    'first_name' => $nannyChild->child->first_name,
                    'last_name' => $nannyChild->child->last_name,
                    'age' => $nannyChild->child->age,
                    'school_name' => $nannyChild->child->school->name ?? 'No School',
                ];
            });
        } else if ($req->nanny_id !== 'null' && $req->school_id === 'null') {
            $nannyID = Staff::where('user_id', $req->nanny_id)->first();

            if (!$nannyID) {
                return response()->json(['error' => 'Nanny not found'], 404);
            }

            $nannyChildren = NannyChilds::with('child.school')
                ->where('nanny_id', $nannyID->id)
                ->get();

            $result = $nannyChildren->map(function ($nannyChild) {
                return [
                    'id' => $nannyChild->child->id,
                    'first_name' => $nannyChild->child->first_name,
                    'last_name' => $nannyChild->child->last_name,
                    'age' => $nannyChild->child->age,
                    'school_name' => $nannyChild->child->school->name ?? 'No School',
                ];
            });
        } else if ($req->school_id !== 'null' && $req->nanny_id === 'null') {
            $children = NannyChilds::with(['child.school'])
                ->whereHas('child', function ($query) use ($req) {
                    $query->where('school_id', $req->school_id);
                })
                ->get();

            $result = $children->map(function ($nannyChild) {
                return [
                    'id' => $nannyChild->child->id,
                    'first_name' => $nannyChild->child->first_name,
                    'last_name' => $nannyChild->child->last_name,
                    'age' => $nannyChild->child->age,
                    'school_name' => $nannyChild->child->school->name ?? 'No School',
                ];
            });
        } else {
            $result = child::all();
        }

        return response()->json($result ?? []);
    }
}
