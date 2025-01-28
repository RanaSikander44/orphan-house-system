<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
class child extends Model
{
    public function academicyear()
    {
        return $this->belongsTo(AcademicYear::class, 'campaign_id');
    }

    public function enquiryType()
    {
        return $this->belongsTo(enquiry_types::class, 'enquiry_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function school()
    {
        return $this->belongsTo(Schools::class, 'school_id');
    }

    public function grade()
    {
        return $this->belongsTo(school_grades::class, 'grade_id');
    }

    public function room()
    {
        return $this->belongsTo(Dormitory::class, 'room_id');
    }

    public function donorReq()
    {
        return $this->belongsTo(donorChildReq::class, 'id', 'child_id');
    }




    // Model Events
    protected static function booted(): void
    {

        static::deleted(function ($child) {

            // after deleting the child , child documents ,
            // child activities , child activity images ,
            //  child form data , donor child req , enquiry form options , parent model , nanny childs
            // will be deleted

            if (Schema::hasColumn('child_documents', 'child_id')) {
                child_documents::where('child_id', $child->id)->delete();
            }


            if (Schema::hasColumn('parents', 'child_id')) {
                ParentModel::where('child_id', $child->id)->delete();
            }


            if (Schema::hasColumn('child_activities', 'child_id')) {
                $activities = ChildActivity::where('child_id', $child->id)->get();

                foreach ($activities as $activity) {
                    ChildActivityImages::where('activity_id', $activity->id)->delete();
                    $activity->delete();
                }
            }


            if (Schema::hasColumn('child_form_data', 'child_id')) {
                $form = ChildFormData::where('child_id', $child->id)->get();

                foreach ($form as $data) {
                    // Delete related enquiry form options
                    $options = enquiryFormOptions::where('field_id', $data->id)->get();
                    foreach ($options as $option) {
                        $option->delete();
                    }

                    // Delete the form data
                    $data->delete();
                }
            }



        });

    }




}
