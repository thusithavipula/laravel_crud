<?php

namespace App\Http\Controllers;

use Session;
use Redirect;
use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\SubjectService;
use App\Student;


class StudentController extends Controller {

    protected $studentService;
    protected $subjectService;

    public function __construct(StudentService $studentService, SubjectService $subjectService) {
        $this->studentService = $studentService;
        $this->subjectService = $subjectService;
    }

    public function index() {
//        echo json_encode($this->subjectService->getSubjectInCategories());die;
        return view('admin.student')
                ->with('titles', $this->studentService->getAllTitles())
                ->with('subject_categories', $this->subjectService->getSubjectInCategories());
    }

    public function getAllStudents() {
        $students = Student::with('student_subjects')->get();
        $data = array('data' => $students);
        echo json_encode($data);
    }

    public function storeStudent(Request $request) {
        $this->studentService->validate($request->all());
////        subject_instruct
//        echo json_encode($request->all());die;
        try {
            if (isset($request['student_id']) && $request['student_id'] != '') {
                $this->studentService->editStudent($request['student_id'], $request);
                Session::flash('message', '<strong>Success! </strong>Successfully updated the student.');
                Session::flash('type', 'success');
            } else {
                $this->studentService->addStudent($request);
                Session::flash('message', '<strong>Success! </strong>Successfully added the student.');
                Session::flash('type', 'success');
            }
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-students');
    }

    public function deleteStudent($student_id) {
        try {
            $this->studentService->deleteStudent($student_id);
            Session::flash('message', '<strong>Success! </strong>Successfully deleted the student.');
            Session::flash('type', 'success');
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-students');
    }

}
