<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestDetailsModel;
use Session;
use DB;
use Auth;
use Response;
use Redirect;
use PaymentDetails;
use Softon\Indipay\Facades\Indipay;

class RequestDetails extends Controller
{
	// Test Payment --------
	public function TestPayment(){
		// Generating Transaction ID ---
		$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

		// Hash ----------------
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

		/* All Required Parameters by your Gateway */
		$parameters = [
        	
      	];
      	$order = Indipay::prepare($parameters);
      	return Indipay::process($order);
	}

	public function TestPaymentResponse(Request $request){
		// For default Gateway
        $response = Indipay::response($request);
        dd($response);
	}

	// When Click on the Id on the grid this method fetches the data ----
	public function GetRequestDetailsByID(Request $request){
		$inputData = $request->all(); //Getting All Form Input Data
		$requestId = $inputData['requestId'];
		$data = RequestDetailsModel::where('request_id',$requestId)->first();
		return Response::json(array(
      		'success' => true,
      		'data' => $data
    	));
	}

    public function AddRequest(Request $request){
    	$inputData = $request->all(); //Getting All Form Input Data
    	// ------------------------------------
    	
    	$State = "";
    	$City = "";
    	$Country = "";
    	$Category = "";
    	$AssignedToEmail = "";

    	// City
    	if (!isset($inputData['city'])) {
    		$City = "";
    	}
    	else{
    		$City = $inputData['city'];
     	}

     	// State
    	if (!isset($inputData['state'])) {
    		$State = "";
    	}
    	else{
    		$State = $inputData['state'];
    	}

    	// Country    	
    	if (!isset($inputData['country'])) {
    		$Country = "";
    	}
    	else{
    		$Country = $inputData['country'];
    	}

    	// Category
    	if (!isset($inputData['category'])) {
    		$Category = "";
    	}
    	else{
    		$Category = $inputData['category'];
    	}

    	// Assigned To Email
    	if (!isset($inputData['assignedToEmail'])) {
    		$AssignedToEmail = "";
    	}
    	else{
    		$AssignedToEmail = $inputData['assignedToEmail'];
    	}

    	// --------------------------------------
    	if ($inputData['request_id'] == "") {
    		$userName = session('userName');
			$rd = new RequestDetailsModel;
			$sms = 0;
			$mail = 0;
			$generateLink = 0;
			if (isset($inputData['generateLink'])) {
				$generateLink = 1;
			}
			if (isset($inputData['sms'])) {
				$sms = 1;
			}
			if (isset($inputData['mail'])) {
				$mail = 1;
			}
			$MaximumReqId = DB::table('RequestDetails')->max('request_id');
			if ($MaximumReqId == null) {
				$MaximumReqId = 1000;
			}
			else{
				$MaximumReqId = $MaximumReqId+1;
			}

			$rd->request_id = $MaximumReqId;
			$rd->Req_Sequence = 1;
			$rd->LoggedBy = $userName;
			$rd->Status = "Open";
			$rd->FirstName = $inputData['firstName'];
			$rd->LastName = $inputData['lastName'];
			$rd->Place = $inputData['place'];
			$rd->City = $City;
			$rd->State = $State;
			$rd->Country = $Country;
			$rd->Email = $inputData['email'];
			$rd->PhoneNumber = $inputData['phoneNumber'];
			$rd->TypeOfWork = $inputData['typeOfWork'];
			$rd->Category = $Category;
			$rd->Details = $inputData['description'];
			$rd->PreferredTime = $inputData['preferredTime'];
			$rd->Amount = $inputData['amount'];
			$rd->AssignedToEmail = $AssignedToEmail;
			$rd->SMSTrigger = $sms;
			$rd->MailTrigger = $mail;		
			$rd->PaymentFlag = 0;
			$rd->userId = Auth::id();
			$rd->save();

			// Generating Email Link ---------------
			if ($generateLink == 1) {
				$amount = (int)$inputData['amount'];
				$firstName = $inputData['firstName'];
				$phone = $inputData['phone'];
				$hash = "";
				$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$productinfo = "Product Information";
				$email = $inputData['email'];
				$userId = 0;
				$linkPart = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$paymentStatus = "Pending";
				$loggedBy = session("userName");
				$requestId = $MaximumReqId;
				$Req_Sequence = 1;

				$pd = new PaymentDetails;
				$pd->amount = $amount;
				$pd->firstName = $firstName;
				$pd->phone = $phone;
				$pd->hash = $hash;
				$pd->txnid = $txnid;
				$pd->productInfo = $productinfo;
				$pd->email = $email;
				$pd->userId = $userId;
				$pd->linkPart = $linkPart;
				$pd->paymentStatus = $paymentStatus;
				$pd->loggedBy = $loggedBy;
				$pd->request_id = $requestId;
				$pd->Req_Sequence = $Req_Sequence;
				$pd->save();

				// Send Email -----------

				// or

				// Send SMS -----------
			}
    		

			// Send Email --------------------------

			/*
			$from_email_id='alert@vidhikarya.com';
			$to =  $laws_email;
			$subject ='Vidhikarya';
			$message = 
			'<div style="float: left; width: 100%; margin: 35px 0 0;">
				<div style="width: 70%; margin:0 auto;text-align: center;">
					<div style="border: 1px solid #13629b;border-radius: 20px;float: left;padding: 5%;width: 90%;background: #ededed none repeat scroll 0 0;">
						<img style="" src="'.JURI::root().'images/logo_mail.png" />
						<p style="float: left;font-size: 20px;margin: 30px 0 40px;width: 100%;color: #000;">Alert message from Vidhikarya.</p>
						<p style="float: left;font-size: 14px;margin: 0 0 5px;width: 100%;color: #000;">A '.$case_category.' case has been posted. Please apply if you want to take this up.</p>
						<p style="float: left;font-size: 14px;width: 100%;margin: 0;color: #000;">Login to <a href="www.vidhikarya.com">www.vidhikarya.com</a></p>
						<p style="float: left;font-size: 14px;margin: 40px 0 0;text-align: left;width: 100%;color: #000;"><b>Enquiries:</b> info@vidhikarya.com</p>
					</div>
				</div>
			</div>';

			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			$headers .= 'From:'.$from_email_id . "\r\n";
			$sentmail = mail($to,$subject,$message,$headers);
			*/

			return Response::json(array(
	      		'success' => true,
	      		'RequestID' => $MaximumReqId
	    	));
    	}
    	else{
			$requestId = (int)$inputData['request_id'];
			$rd = RequestDetailsModel::where('request_id',$requestId)->first();

			$sms = 0;
			$mail = 0;
			if (isset($inputData['sms'])) {
				$sms = 1;
			}
			if (isset($inputData['mail'])) {
				$mail = 1;
			}

			RequestDetailsModel::where('request_id',$requestId)->update([
				'Status' => 'Open',
				'FirstName' => $inputData['firstName'],
				'LastName' => $inputData['lastName'],
				'Place' => $inputData['place'],
				'City' => $City,
				'State' => $State,
				'Country' => $Country,
				'Email' => $inputData['email'],
				'PhoneNumber' => $inputData['phoneNumber'],
				'TypeOfWork' => $inputData['typeOfWork'],
				'Category' => $Category,
				'Details' => $inputData['description'],
				'PreferredTime' => $inputData['preferredTime'],
				'Amount' => $inputData['amount'],
				'AssignedToEmail' => $AssignedToEmail,
				'SMSTrigger' => $sms,
				'MailTrigger' => $mail
			]);
			// Generating Link ----------------
			if (isset($inputData['generateLink'])) {
				$amount = (int)$inputData['amount'];
				$firstName = $inputData['firstName'];
				$phone = $inputData['phone'];
				$hash = "";
				$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$productinfo = "Product Information";
				$email = $inputData['email'];
				$userId = 0;
				$linkPart = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$paymentStatus = "Pending";
				$loggedBy = session("userName");
				$requestId = $MaximumReqId;
				$Req_Sequence = 1;

				$pd = new PaymentDetails;
				$pd->amount = $amount;
				$pd->firstName = $firstName;
				$pd->phone = $phone;
				$pd->hash = $hash;
				$pd->txnid = $txnid;
				$pd->productInfo = $productinfo;
				$pd->email = $email;
				$pd->userId = $userId;
				$pd->linkPart = $linkPart;
				$pd->paymentStatus = $paymentStatus;
				$pd->loggedBy = $loggedBy;
				$pd->request_id = $requestId;
				$pd->Req_Sequence = $Req_Sequence;
				$pd->save();
			}
			return Response::json(array(
	          		'success' => false,
	          		'RequestID' => $MaximumReqId
	        ));
    	}
    }

    public function DraftRequest(Request $request){
    	$inputData = $request->all(); //Getting All Form Input Data
    	// ------------------------------------
    	$State = "";
    	$City = "";
    	$Country = "";
    	$Category = "";
    	$AssignedToEmail = "";
    	// City
    	if (!isset($inputData['city'])) {
    		$City = "";
    	}
    	else{
    		$City = $inputData['city'];
     	}
     	// State
    	if (!isset($inputData['state'])) {
    		$State = "";
    	}
    	else{
    		$State = $inputData['state'];
    	}
    	// Country    	
    	if (!isset($inputData['country'])) {
    		$Country = "";
    	}
    	else{
    		$Country = $inputData['country'];
    	}
    	// Category
    	if (!isset($inputData['category'])) {
    		$Category = "";
    	}
    	else{
    		$Category = $inputData['category'];
    	}
    	// Assigned To Email
    	if (!isset($inputData['assignedToEmail'])) {
    		$AssignedToEmail = "";
    	}
    	else{
    		$AssignedToEmail = $inputData['assignedToEmail'];
    	}
    	// --------------------------------------
    	if ($inputData['request_id'] == "") {
    		$userName = session('userName');
			$rd = new RequestDetailsModel;
			$sms = 0;
			$mail = 0;
			if (isset($inputData['sms'])) {
				$sms = 1;
			}
			if (isset($inputData['mail'])) {
				$mail = 1;
			}
			$MaximumReqId = DB::table('RequestDetails')->max('request_id');
			if ($MaximumReqId == null) {
				$MaximumReqId = 1000;
			}
			else{
				$MaximumReqId = $MaximumReqId+1;
			}

			$rd->request_id = $MaximumReqId;
			$rd->Req_Sequence = 1;
			$rd->LoggedBy = $userName;
			$rd->Status = "Draft";
			$rd->FirstName = $inputData['firstName'];
			$rd->LastName = $inputData['lastName'];
			$rd->Place = $inputData['place'];
			$rd->City = $City;
			$rd->State = $State;
			$rd->Country = $Country;
			$rd->Email = $inputData['email'];
			$rd->PhoneNumber = $inputData['phoneNumber'];
			$rd->TypeOfWork = $inputData['typeOfWork'];
			$rd->Category = $Category;
			$rd->Details = $inputData['description'];
			$rd->PreferredTime = $inputData['preferredTime'];
			$rd->Amount = $inputData['amount'];
			$rd->AssignedToEmail = $AssignedToEmail;
			$rd->SMSTrigger = $sms;
			$rd->MailTrigger = $mail;		
			$rd->PaymentFlag = 0;
			$rd->userId = Auth::id();
			$rd->save();

			return Response::json(array(
	          		'success' => false,
	          		'RequestID' => $MaximumReqId
	        ));
    	}
    	else{
    		$inputData = $request->all(); //Getting All Form Input Data
			$requestId = (int)$inputData['request_id'];

			$sms = 0;
			$mail = 0;
			if (isset($inputData['sms'])) {
				$sms = 1;
			}
			if (isset($inputData['mail'])) {
				$mail = 1;
			}

			RequestDetailsModel::where('request_id',$requestId)->update([
				'Status' => 'Draft',
				'FirstName' => $inputData['firstName'],
				'LastName' => $inputData['lastName'],
				'Place' => $inputData['place'],
				'City' => $City,
				'State' => $State,
				'Country' => $Country,
				'Email' => $inputData['email'],
				'PhoneNumber' => $inputData['phoneNumber'],
				'TypeOfWork' => $inputData['typeOfWork'],
				'Category' => $Category,
				'Details' => $inputData['description'],
				'PreferredTime' => $inputData['preferredTime'],
				'Amount' => $inputData['amount'],
				'AssignedToEmail' => $AssignedToEmail,
				'SMSTrigger' => $sms,
				'MailTrigger' => $mail
			]);
			return Response::json(array(
	          		'success' => false,
	          		'RequestID' => $requestId
	        ));
    	}
    }
}
















