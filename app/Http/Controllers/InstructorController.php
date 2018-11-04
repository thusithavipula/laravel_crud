<?php

namespace App\Http\Controllers;

use Session;
use Redirect;
use Illuminate\Http\Request;
use App\Services\InstructorService;
use App\Services\SubjectService;
use App\Instructor;


class InstructorController extends Controller {

    protected $instructorService;
    protected $subjectService;

    public function __construct(InstructorService $instructorService, SubjectService $subjectService) {
        $this->instructorService = $instructorService;
        $this->subjectService = $subjectService;
    }

    public function index() {
//        echo json_encode($this->subjectService->getSubjectInCategories());die;
        return view('admin.instructor')
                ->with('titles', $this->instructorService->getAllTitles())
                ->with('subject_categories', $this->subjectService->getSubjectInCategories());
    }

    public function getAllInstructors() {
        $instructors = Instructor::with('instructor_subjects')->get();
        $data = array('data' => $instructors);
        echo json_encode($data);
    }

    public function storeInstructor(Request $request) {
        $this->instructorService->validate($request->all());
////        subject_instruct
//        echo json_encode($request->all());die;
        try {
            if (isset($request['instructor_id']) && $request['instructor_id'] != '') {
                $this->instructorService->editInstructor($request['instructor_id'], $request);
                Session::flash('message', '<strong>Success! </strong>Successfully updated the instructor.');
                Session::flash('type', 'success');
            } else {
                $this->instructorService->addInstructor($request);
                Session::flash('message', '<strong>Success! </strong>Successfully added the instructor.');
                Session::flash('type', 'success');
            }
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-instructors');
    }

    public function deleteInstructor($instructor_id) {
        try {
            $this->instructorService->deleteInstructor($instructor_id);
            Session::flash('message', '<strong>Success! </strong>Successfully deleted the instructor.');
            Session::flash('type', 'success');
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-instructors');
    }

}
