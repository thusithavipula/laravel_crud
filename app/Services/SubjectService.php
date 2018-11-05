<?php

namespace App\Services;

use DB;
use Validator;
use App\Subject;
use App\SubjectCategory;

class SubjectService {

    protected $rules = [ //validation rules
        'name' => 'required',
        'duration' => 'required|integer|between:1,6',
        'category' => 'required',
        'description' => 'required',
    ];

    public function validate($subject) {
        $validator = Validator::make($subject, $this->rules);
        $validator->validate();
    }

    public function getAllCategories() {
        return SubjectCategory::all();
    }

    public function addSubject($request) {
        $subject = new Subject();
        $subject->name = $request['name'];
        $subject->short_code = $request['name'];
        $subject->duration = $request['duration'];
        $subject->category = $request['category'];
        $subject->description = $request['description'];
        $subject->is_active = isset($request['is_active']) ? true : false;
        try {
            DB::transaction(function () use ($subject) {
                $subject->save();
                $subject->short_code = $this->getShortCode($subject->name) . '_' . str_pad($subject->id, 5, '0', STR_PAD_LEFT);
                $subject->save();
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $subject);
    }

    public function editSubject($id, $request) {
        $subject = Subject::find($id);
        $subject->name = $request['name'];
        $subject->duration = $request['duration'];
        $subject->category = $request['category'];
        $subject->description = $request['description'];
        $subject->is_active = isset($request['is_active']) ? true : false;
        try {
            DB::transaction(function () use ($subject) {
                $subject->short_code = $this->getShortCode($subject->name) . '_' . str_pad($subject->id, 5, '0', STR_PAD_LEFT);
                $subject->save();
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $subject);
    }

    public function deleteSubject($id) {
        $subject = Subject::find($id);
        try {
            DB::transaction(function () use ($subject) {
                $subject->delete();
            });
        } catch (Exception $e) {
            return array('message' => $e->getMessage(), 'type' => 'danger');
        }
        return array('message' => 'Success', 'type' => 'success', 'data' => $subject);
    }

    public static function getShortCode($text, $length = 3) { //simple short code creater 
        $text = str_replace(['\'', '(', ')', '[', ']', '- ', '-'], "", trim($text));
        $words = explode(' ', $text);
        $code = '';
        $chars = ['c', 'o', 'g', 'b', 'd', 'j', 'h', 'p', 'r', 't', 'k', 'l', 's', 'w', 'x'];
        if (count($words) >= $length) {
            for ($i = 0; $i < $length; $i++) {
                $code .= $words[$i][0];
            }
        } else {
            $code .= isset($text[0]) ? $text[0] : '';
            $code .= isset($text[1]) ? $text[1] : '';
            if (count($words) == 2) {
                $code .= $words[1][0];
            } else {
                $formatedText = str_replace(["a", "e", "i", "o", "u", "y", " "], "", $text);
                for ($i = 2; $i < strlen($formatedText); $i++) {
                    if (in_array($formatedText[$i], $chars)) {
                        $code .= $formatedText[$i];
                    }
                }
            }
        }

        if (strlen($code) >= $length) {
            $code = substr($code, 0, $length);
        } else {
            for ($i = strlen($code); $i < $length; $i++) {
                $code .= $chars[$i];
            }
        }
        return (strlen(str_replace(' ', '', $text)) == $length ? strtoupper($text) : strtoupper($code));
    }

    public function getSubjectInCategories() {
        return SubjectCategory::with('subjects')->get();
    }

    public function getSummary() { //Get Summary of active and inactive subjects
        $collection = DB::table('subjects')
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
