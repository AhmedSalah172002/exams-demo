<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreExam;
use App\Models\Exam;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = Exam::all();

        return response()->json(["data"=>$exams,"message"=>"data send successfully"],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExam $request)
    {
        $validated = $request->validated();

        try {
            $exam = Exam::create($validated);
        }catch (\Exception $e){
            return response()->json(["message"=>$e->getMessage()],400);
        }

        return response()->json(["data"=>$exam,"message"=>"data send successfully"],201);
    }

    /**validated
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $exam = Exam::find($id);
            return response()->json(["data"=>$exam,"message"=>"data send successfully"],200);
        }catch (\Exception $e){
            return response()->json(["message"=>"data not found"],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreExam $request, Exam $exam)
    {
        try {
            $validated = $request->validated();
           if($exam){
               $exam->update($validated);
               return response()->json(["data"=>$exam,"message"=>"data updated successfully"],200);
           }
            return response()->json(["message"=>"exam not found"],404);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'An error occurred, please try again later'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        if(! $exam){
            return response()->json(["message"=>"Exam not found"],404);
        }

        $exam->delete();
        return response()->json(["message"=>"Exam deleted successfully"],200);
    }
    public function enroll(Request $request){

        try {
            $user = $request->user();

            $examId = $request['exam_id'];

            $exam = Exam::find($examId);

            if(! $exam){
                return response()->json(["message"=>"Exam not found"],404);
            }

            if(($user->exams->contains($exam))){
                return response()->json(["message"=>"You have already enrolled in this exam"],400);
            }

            $user->exams()->attach($examId);
            return response()->json(["message"=>"You have successfully enrolled in this exam"],201);
        }catch (\Exception $e){
            return response()->json([['message'=>$e->getMessage()]],500);
        }

    }


    public function userExams(Request $request){

        try {
            $user = $request->user();

            $query = $user->exams();

            if ($request->filled('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }

            $exams = $query->get()->except('pivot');

            return response()->json(["data"=>$exams],200);
        }catch (\Exception $e){
            return response()->json([['message'=>$e->getMessage()]],400);
        }

    }



    public function withdraw(Request $request){

        try {
            $user = $request->user();

            $examId = $request['exam_id'];

            $exam = Exam::find($examId);

            if(! $exam){
                return response()->json(["message"=>"Exam not found"],404);
            }

            if(($user->exams->contains($exam))){
                $user->exams()->detach($exam);
                return response()->json(["message"=>"You have successfully removed this exam from your list"],200);
            }
            return response()->json(["message"=>"You haven't this exam"],400);

        }catch (\Exception $e){
            return response()->json([['message'=>$e->getMessage()]],500);
        }

    }

}
