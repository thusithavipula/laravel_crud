<?php

namespace App\Http\Controllers;

use Session;
use Redirect;
use Illuminate\Http\Request;
use App\Services\SubjectService;
use App\Subject;


class SubjectController extends Controller {

    protected $subjectService;

    public function __construct(SubjectService $service) {
        $this->subjectService = $service;
    }

    public function index() {
        return view('admin.subject')->with('categories', $this->subjectService->getAllCategories());
    }

    public function getAllSubjects() {
        $subjects = Subject::with('category')->get();
        $data = array('data' => $subjects);
        echo json_encode($data);
    }

    public function storeSubject(Request $request) {
        $this->subjectService->validate($request->all());
        try {
            if (isset($request['subject_id']) && $request['subject_id'] != '') {
                $this->subjectService->editSubject($request['subject_id'], $request);
                Session::flash('message', '<strong>Success! </strong>Successfully updated the subject.');
                Session::flash('type', 'success');
            } else {
                $this->subjectService->addSubject($request);
                Session::flash('message', '<strong>Success! </strong>Successfully added the subject.');
                Session::flash('type', 'success');
            }
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-subjects');
    }

    public function deleteSubject($subject_id) {
        try {
            $this->subjectService->deleteSubject($subject_id);
            Session::flash('message', '<strong>Success! </strong>Successfully deleted the subject.');
            Session::flash('type', 'success');
        } catch (Exception $exc) {
            return response()->json(['message' => $exc->getMessage()], 500);
        }
        return Redirect::route('admin-subjects');
    }

}
