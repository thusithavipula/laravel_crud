<?php

namespace App\Services;

use DB;
use Validator;
use App\Student;
use App\StudentSubject;

class StudentService {

    protected $rules = [ //validation rules
        'title' => 'required',
        'first_name' => 'required',
        'last_name' => 'required',
        'address' => 'required',
    ];
    protected $titles = [
        '' => 'Select title',
        'MR' => 'Mr.',
        'MRS' => 'Mrs.',
        'MISS' => 'Miss.',
        'REV' => 'Rev.',
    ];

    public function validate($student) {
        $validator = Validator::make($student, $this->rules);
        $validator->validate();
    }

    public function getAllTitles() {
        return $this->titles;
    }

    public function addStudent($request) {
        $student = new Student();
        $student->title = $request['title'];
        $student->first_name = $request['first_name'];
        $student->last_name = $request['last_name'];
        $student->address = $request['address'];
        $student->is_active = isset($request['is_active']) ? true : false;
        $subject_studies = isset($request['subject_studies']) ? $request['subject_studies'] : [];
        try {
            DB::transaction(function () use ($student, $subject_studies) {
                $student->save();
                $this->syncSubjects($student->id, $subject_studies);
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $student);
    }

    public function editStudent($id, $request) {
        $student = Student::find($id);
        $student->title = $request['title'];
        $student->first_name = $request['first_name'];
        $student->last_name = $request['last_name'];
        $student->address = $request['address'];
        $student->is_active = isset($request['is_active']) ? true : false;
        $subject_studies = isset($request['subject_studies']) ? $request['subject_studies'] : [];
        try {
            DB::transaction(function () use ($student, $subject_studies) {
                $student->save();
                $this->syncSubjects($student->id, $subject_studies);
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $student);
    }

    public function deleteStudent($id) {
        $student = Student::find($id);
        try {
            DB::transaction(function () use ($student) {
                $student->delete();
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $student);
    }

    public function syncSubjects($student_id, $subject_studies) { //sync the selected subject with the db
        StudentSubject::where('student_id', $student_id)->delete(); //delete old records
        foreach ($subject_studies as $value) {
            $student_subject = new StudentSubject;
            $student_subject->student_id = $student_id;
            $student_subject->subject_id = $value;
            $student_subject->save();
        }
    }

    public function getSummary() { //Get Summary of active and inactive students
        $collection = DB::table('students')
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
