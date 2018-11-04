<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StudentService;
use App\Services\InstructorService;
use App\Services\SubjectService;

class AdminController extends Controller {
    
    protected $studentService;
    protected $instructorService;
    protected $subjectService;

    public function __construct(StudentService $studentService, InstructorService $instructorService, SubjectService $subjectService) {
        $this->studentService = $studentService;
        $this->instructorService = $instructorService;
        $this->subjectService = $subjectService;
    }

    public function index() {
        $student_summary = $this->studentService->getSummary();
        $instructor_summary = $this->instructorService->getSummary();
        $subject_summary = $this->subjectService->getSummary();
        
        return view('admin.index')
                ->with('student_summary', $student_summary)
                ->with('instructor_summary', $instructor_summary)
                ->with('subject_summary', $subject_summary);
    }
    
    public function settings() {
        return view('admin.settings');
    }

}
