<?php

namespace App\Http\Controllers;
use Auth;
use Response;
use Session;
use Illuminate\Http\Request;
use Redirect;
use App\RequestDetailsModel;
use App\LawyerDetails;
use App\AssignmentLog;
use App\CallSchedule;
use App\DiscussionPoints;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function Home(){
    	if (Auth::check()) {
    		$userId = Auth::id();
            $userEmail = session('userEmail');
    		$OpenData = RequestDetailsModel::where('userId',$userId)->whereIn('Status',['Open','Draft'])->get();
            $UnassignedData = RequestDetailsModel::where('userId',$userId)->where('Status','Unassigned')->get();
            $AssignedData = RequestDetailsModel::where('userId',$userId)->where('Status','Assigned')->get();
            $ActiveData = RequestDetailsModel::where('userId',$userId)->where('Status','Active')->get();
            $ClosedData = RequestDetailsModel::where('userId',$userId)->where('Status','Closed')->get();
    		$AllData = RequestDetailsModel::where('userId',$userId)->get();
            $UserRole = LawyerDetails::groupBy('UserRole')->pluck('UserRole');
            // $AssignmentLogData = AssignmentLog::where('AssignTo', $userEmail)->where('');
    		return view("Pages.Home",compact('OpenData','UnassignedData','AssignedData','ActiveData','ClosedData','AllData','UserRole'));
    	}
    	else{
    		return Redirect::to('/login');
    	}
    }
    public function CancelSchedule(Request $request){
        $inputData = $request->all();
        $requestId = $inputData['requestId'];
        $ScheduleId = $inputData['ScheduleId'];
        $Schedule = CallSchedule::find($ScheduleId);
        $Schedule->Status = "Canceled";
        $Schedule->save();
        // Changing The Request Status ------
        RequestDetailsModel::where('request_id',$requestId)->update([
                'Status' => 'Active'
            ]);
        return Response::json(array(
            'Status' => "Canceled"
        ));
    }
    public function GetRoleData(Request $request){
        $inputData = $request->all(); //Getting All Form Input Data
        $Role = $inputData['Role'];
        if ($Role == "All")
        {
            $Data = LawyerDetails::All(['Email']);
            return Response::json(array(
                'success' => true,
                'Data' => $Data
            ));
        }
        else
        {
            $Data = LawyerDetails::where('UserRole',$Role)->get(['Email']);
            return Response::json(array(
                'success' => true,
                'Data' => $Data
            ));
        }
    }
    public function GetAssignmentLog(Request $request){
        $inputData = $request->all(); //Getting All Form Input Data
        $RequestID = (int)$inputData['requestId'];

        $data = AssignmentLog::where('request_id',$RequestID)->latest()->get();
        return Response::json(array(
            'success' => true,
            'Data' => $data
        ));
    }
    public function AssignTo(Request $request){
        // Saving The Assignment Log
        $inputData = $request->all();
        $requestId = $inputData['requestId'];
        $assignTo = $inputData['assignTo'];
        $al = new AssignmentLog;
        $userName = session('userName');
        $al->AssignBy = $userName;
        $al->AssignTo = $assignTo;
        $al->request_id = $requestId;
        $al->Req_sequence = 1;
        $al->save();
        $now = Carbon::now();

        // Changing The Status
        RequestDetailsModel::where('request_id',$requestId)->update([
                'Status' => 'Assigned'
            ]);

        // Returning Response Data
        return Response::json(array(
            'Status' => "Assigned",
            'AssignBy' => $userName,
            'AssignOn' => $now,
        ));
    }
    public function PickUpAssignment(Request $request){
        $inputData = $request->all();
        $requestId = $inputData['requestId'];
        // Changing The Status
        RequestDetailsModel::where('request_id',$requestId)->update([
                'Status' => 'Active'
            ]);

        // Returning Response Data
        return Response::json(array(
            'Status' => "PickedUp"
        ));
    }
    public function ScheduleRequest(Request $request){
        $inputData = $request->all();
        $requestId = $inputData['requestId'];
        $ScheduleOn = $inputData['ScheduleOn'];
        $ScheduleBy = session('userEmail');
        $ScheduleMessage = $inputData['ScheduleMessage'];
        $Status = $inputData['Status'];
        $cs = new CallSchedule;
        $cs->request_id = $requestId;
        $cs->Req_Sequence = 1;
        $cs->ScheduleBy = $ScheduleBy;
        $cs->ScheduleOn = $ScheduleOn;
        $cs->ScheduleMessage = $ScheduleMessage;
        $cs->Status = $Status;
        $cs->save();

        // Get The Id ---
        $id = $cs->id;

        $now = Carbon::now();

        // Returning Response Data
        return Response::json(array(
            'Status' => "Scheduled",
            'ScheduleBy' => $ScheduleBy,
            'ScheduleId' => $id,
            'Now' => $now
        ));
    }
    public function GetScheduleLog(Request $request){
        $data = CallSchedule::where('request_id',(int)$request->all()['requestId'])->orderBy('id','desc')->get();
        $lastSchedule = CallSchedule::where('request_id',(int)$request->all()['requestId'])->where('Req_Sequence',1)->orderBy('id','desc')->first();
        $isScheduled = false;
        // If there's atleast one schedule - either canceled or scheduled
        if (isset($lastSchedule->id)) {
            $lastScheduleId = $lastSchedule->id;
            $date = date("d/m/Y", strtotime($lastSchedule->created_at))." ".date('H:i:s', strtotime($lastSchedule->created_at));
            if ($lastSchedule->Status == "Scheduled") {
                $isScheduled = true;
            }
            return Response::json(array(
                'success' => true,
                'Data' => $data,
                'isScheduled' => $isScheduled,
                'lastScheduleId' => $lastScheduleId,
                'lastScheduleMessage' => $lastSchedule->ScheduleMessage,
                'lastScheduleBy' => $lastSchedule->ScheduleBy,
                'lastScheduleCreated' => $date,
                'lastScheduleOn' => $lastSchedule->ScheduleOn,
                'ScheduleDate' => date("d/m/Y", strtotime($lastSchedule->ScheduleOn)),
                'ScheduleTime' => date('H:i:s', strtotime($lastSchedule->ScheduleOn))
            ));
        }
        // When there's no schedule in the database.
        else{
            return Response::json(array(
                'success' => true,
                'Data' => $data,
                'isScheduled' => false,
                'lastScheduleId' => "",
                'lastScheduleMessage' => "",
                'lastScheduleBy' => "",
                'lastScheduleCreated' => "",
                'lastScheduleOn' => "",
                'ScheduleDate' => "",
                'ScheduleTime' => ""
            ));
        }
    }
    public function DiscussionPointAddNote(Request $request){
        $inputData = $request->all(); //Getting All Form Input Data
        $RequestID = (int)$inputData['requestId'];
        $note = $inputData['Note'];
        $sequence = $inputData['Req_Sequence'];
        $email = session('userEmail');
        $actualDatetime = $inputData['ActualDateTime'];
        $dp = new DiscussionPoints;
        $dp->Notes = $note;
        $dp->Req_Sequence = $sequence;
        $dp->AddedBy = $email;
        $dp->request_id = $RequestID;
        $dp->save();
        return Response::json(array(
            'Status' => "Added",
            'AddedBy' => $email
        ));
    }
    public function GetDiscussionPointNotes(Request $request){
        $inputData = $request->all(); //Getting All Form Input Data
        $RequestID = (int)$inputData['requestId'];

        $notes = DiscussionPoints::where('request_id',$RequestID)->latest()->get();
        return Response::json(array(
            'success' => true,
            'Notes' => $notes
        ));
    }
    public function AddFinalNote(Request $request){
        $inputData = $request->all(); //Getting All Form Input Data
        $RequestID = (int)$inputData['requestId'];
        $note = $inputData['Note'];
        $sequence = (int)$inputData['Req_Sequence'];
        $email = session('userEmail');
        $dp = new DiscussionPoints;
        $dp->Notes = $note;
        $dp->Req_Sequence = $sequence;
        $dp->AddedBy = $email;
        $dp->request_id = $RequestID;
        $dp->save();

        // Changing The status ---------
        RequestDetailsModel::where('request_id',$requestId)->where('Req_Sequence',$sequence)->update([
            'Status' => 'Close'
        ]);

        return Response::json(array(
            'Status' => "Done",
            'AddedBy' => $email
        ));
    }
}







































