<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\BaseController;
use App\SystemIssue;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HelperController extends BaseController
{
    /**
     * 오류ны 정보 илгээх хэсгийн нүүр хуудас
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createIssue(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        $userPkId = session()->get("auth")->id;
        $user_position = session()->get("auth")->userpositionid;
        $issue_id = $request->route("id");
        $issue_env = $request->get("env");
        $issues = SystemIssue::where("OPEN_USER_ID", $userPkId)->orderBy("OPEN_DATE", "DESC")->get();
        if($user_position == 1){
            $issues = SystemIssue::orderBy("OPEN_DATE", "DESC")->get();
        }
        if($request->isMethod("POST")){
            $phone = $request->get("phone");
            $description = $request->get("description");
            $path_for_db = "";
            if ($request->hasFile('importfile')) {
                $path = $request->file("importfile");
                if ($path->getClientOriginalExtension() != "" || $path->getClientOriginalExtension() != "N/A") {
                    $fileName = time() . '.' . $path->getClientOriginalExtension();
                    //$path->move(public_path('/issue'), $fileName);
                    $path->move(public_path('../VRS/issue'), $fileName);
                    $path_for_db = "/issue/" . $fileName;
                }
            }
            if($issue_env != null && $issue_env != ""){
                SystemIssue::where("Id", $this->dec($issue_env))->update([
                    'CLOSE_USER_ID' => $userPkId,
                    'ANSWER' => $description,
                    'ANSWER_IMAGE' => $path_for_db,
                    'STATUS' => 1,
                    'CLOSE_DATE' => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                $message = $this->message("success", "오류ны мессеж 성공적으로 수정되었습니다.");
            } else {
                SystemIssue::create([
                    'OPEN_USER_ID' => $userPkId,
                    'QUESTION' => $description,
                    'QUESTION_IMAGE' => $path_for_db,
                    'PHONE_NO' => $phone,
                    'STATUS' => 0,
                    'OPEN_DATE' => Carbon::now()->format("Y-m-d H:i:s"),
                ]);
                $message = $this->message("success", "오류ны мессеж 성공적으로 илгээгдлээ.");
            }
            return redirect(route("issue"))->with("message", $message);
        } else {
            if($issue_id != null && $issue_id != ""){
                $selected_issue = SystemIssue::where("ID", $this->dec($issue_id))->get()->first();
                return view('System.createissue', compact('issues', 'selected_issue'));
            } else {
                return view('System.createissue', compact('issues'));
            }
        }
    }
    /**
     * 오류ны 정보 илгээх хэсгийн нүүр хуудас
     * @param Request $request - дамжуулна
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function issueList(Request $request)
    {
        if(!session()->has("auth")){
            return redirect(route($this->redirectURL));
        }
        return view('System.issuelist');
    }
}
