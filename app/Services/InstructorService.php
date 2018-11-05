<?php

namespace App\Services;

use DB;
use Validator;
use App\Instructor;
use App\InstructorSubject;

class InstructorService {

    protected $rules = [ //validation rules
        'title' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'education' => 'required',
    ];
    protected $titles = [
        '' => 'Select title',
        'MR' => 'Mr.',
        'MRS' => 'Mrs.',
        'MISS' => 'Miss.',
        'REV' => 'Rev.',
    ];

    public function validate($instructor) {
        $validator = Validator::make($instructor, $this->rules);
        $validator->validate();
    }

    public function getAllTitles() {
        return $this->titles;
    }

    public function addInstructor($request) {
        $instructor = new Instructor();
        $instructor->title = $request['title'];
        $instructor->first_name = $request['first_name'];
        $instructor->last_name = $request['last_name'];
        $instructor->education = $request['education'];
        $instructor->is_active = isset($request['is_active']) ? true : false;
        $subject_instruct = isset($request['subject_instruct']) ? $request['subject_instruct'] : [];
        try {
            DB::transaction(function () use ($instructor, $subject_instruct) {
                $instructor->save();
                $this->syncSubjects($instructor->id, $subject_instruct);
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $instructor);
    }

    public function editInstructor($id, $request) {
        $instructor = Instructor::find($id);
        $instructor->title = $request['title'];
        $instructor->first_name = $request['first_name'];
        $instructor->last_name = $request['last_name'];
        $instructor->education = $request['education'];
        $instructor->is_active = isset($request['is_active']) ? true : false;
        $subject_instruct = isset($request['subject_instruct']) ? $request['subject_instruct'] : [];
        try {
            DB::transaction(function () use ($instructor, $subject_instruct) {
                $instructor->save();
                $this->syncSubjects($instructor->id, $subject_instruct);
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $instructor);
    }

    public function deleteInstructor($id) {
        $instructor = Instructor::find($id);
        try {
            DB::transaction(function () use ($instructor) {
                $instructor->delete();
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $instructor);
    }

    public function syncSubjects($instructor_id, $subject_instruct) { //sync the selected subject with the db
        InstructorSubject::where('instructor_id', $instructor_id)->delete();
        foreach ($subject_instruct as $value) {
            $instructor_subject = new InstructorSubject;
            $instructor_subject->instructor_id = $instructor_id;
            $instructor_subject->subject_id = $value;
            $instructor_subject->save();
        }
    }

    public function getSummary() { //Get Summary of active and inactive instructors
        $collection = DB::table('instructors')
                ->whereNull('deleted_at')
                ->select('is_active', DB::raw('count(*) as total'))
                ->groupBy('is_active')
                ->get();

        $return_array = ['active' => 0, 'inactive' => 0];
        foreach ($collection as $key => $value) {
            if ($value->is_active == 1) {
                $return_array['active'] = $value->total;
            } elseif ($value->is_active == 0) {
                $return_array['inactive'] = $value->total;
            }
        }

        return $return_array;
    }

}
