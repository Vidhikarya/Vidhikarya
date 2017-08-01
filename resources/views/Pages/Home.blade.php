@extends('Layouts.Master')
@section('title','Home')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ url('css/Vidhikarya/Lawyer/Dashboard.css') }}">
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<style type="text/css">
	.timepicker .title{
		display: none;
	}
	.modal-card-body{
		padding-top: 0px;
	}
	.dataTables_length{
		margin-bottom: 10px;
		margin-left: 10px;
	}
	.dataTables_filter{
		margin-right: 10px;
	}
	.no-footer{
		width:100%;
	}
	#OpenDataTable_wrapper{
		width:100% !important;
	}
	#UnAssignedDataTable{
		width:100% !important;
	}
	#AssignedDataTable_wrapper, #AssignedDataTable{
		width:100% !important;
	}
	#ClosedDataTable_wrapper, #ClosedDataTable{
		width:100% !important;
	}
	#ActiveDataTable_wrapper, #ActiveDataTable{
		width:100% !important;
	}
	#AllDataTable_wrapper, #AllDataTable{
		width:100% !important;
	}
	.modal-card{
		width:90%;
		min-width: 90%;
		min-height: 500px;
	}
	.modal-card-title{
		margin-bottom: 0;
	}
	.modal-card-head{
		padding:10px;
	}
</style>
<div id="PageContent">
	<!-- Tabs -->
	<div class="DashboardNav">
		<nav class="DashboardNavBar">
			<div class="Tabs">
				<neo-tab v-for="(tab, index) in Tabs" :key="index" :data="tab" :tab-name="tab.TabName" @changed="ChangeTab"></neo-tab>
			</div>
			<div class="SearchBox">
				<a class="button is-info" style='margin-right:20px;' v-on:click="OpenModal">Log Request</a>
	  			<input type="text" class="DashboardSearchBox" placeholder="Search">
	  		</div>
	    </nav>
	</div>

	<!-- Open Tab -->
	<div v-show="OpenTab" id="Open" style="display: flex; flex-wrap: wrap; padding-top: 10px; padding-bottom: 10px;">

		<table id="OpenDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>

	</div>

	<!-- Unassigned Tab -->	
	<div v-show="UnassignedTab" style="padding-top: 10px; padding-bottom: 10px;">

		<table id="UnAssignedDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>

	</div>

	<!-- Assigned Tab -->
	<div v-show="AssignedTab" style="display: flex; flex-wrap: wrap; padding-top: 10px; padding-bottom: 10px;">

		<table id="AssignedDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>
		
	</div>

	<!-- Active Tab -->
	<div v-show="ActiveTab" style="display: flex; flex-wrap: wrap; padding-top: 10px; padding-bottom: 10px;">
		
		<table id="ActiveDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>

	</div>

	<!-- Closed Tab -->
	<div v-show="ClosedTab" style="display: flex; flex-wrap: wrap; padding-top: 10px; padding-bottom: 10px;">
		
		<table id="ClosedDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>

	</div>

	<!-- All Tab -->
	<div v-show="AllTab" style="display: flex; flex-wrap: wrap; padding-top: 10px; padding-bottom: 10px;">

		<table id="AllDataTable" class="table">
		    <thead>
		        <tr>
		            <th>Row</th>
		            <th>#ID</th>
		            <th>Category</th>
		            <th>Type</th>
		            <th>Name</th>
		            <th>Phone Number</th>
		            <th>Executive</th>
		            <th>Status</th>
		            <th>Lawyer</th>
		        </tr>
		    </thead>
		    <tbody>
		        <tr>
		            <th>Row 1 Data 1</th>
		            <td>Row 1 Data 2</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		        <tr>
		            <th>Row 2 Data 1</th>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 2 Data 1</td>
		            <td>Row 2 Data 2</td>
		            <td>Row 2 Data 3</td>
		            <td>Row 1 Data 3</td>
		            <td>Row 1 Data 3</td>
		        </tr>
		    </tbody>
		</table>

	</div>

<div class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Log Request</p>
      <button class="delete" v-on:click="CloseModal"></button>
    </header>
    <section class="modal-card-body">
	    <!-- Modal Tabs -->
		<div class="DashboardNav">
			<nav class="DashboardNavBar">
				<div class="Tabs">
					<neo-tab v-for="(tab,index) in ModalTabs" :key="index" :data="tab" :tab-name="tab.TabName" @changed="ChangeModalTab"></neo-tab>
				</div>
		    </nav>
		</div>

		<!-- Details Tab -->
		<div v-show="DetailsTab" style="padding-top: 10px;">
			<form method="post" action="AddRequest" id="RequestForm">
		    	{!! csrf_field() !!}
		    	<input type='hidden' value="" name="request_id" v-model='request_id'>
		    	<div style="display: flex;">
		    		<div style="flex: 1; padding-right: 30px;">

		    			<!-- Email -->
				      	<div class="field">
						  <label class="label">Email</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Email" name="email" v-model='email'>
						  </div>
						</div>

						<!-- Phone Number -->
						<div class="field">
						  <label class="label">Phone Number</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Phone Number" name="phoneNumber" v-model='phoneNumber'>
						  </div>
						</div>

						<!-- First Name -->
						<div class="field">
						  <label class="label">First Name</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="First Name" name='firstName' v-model='firstName'>
						  </div>
						</div>

						<!-- Last Name -->
						<div class="field">
						  <label class="label">Last Name</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Last Name" name='lastName' v-model='lastName'>
						  </div>
						</div>

						<!-- Place -->
						<div class="field">
						  <label class="label">Place</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Place" name='place' v-model='place'>
						  </div>
						</div>				

						<!-- Amount  Rs.-->
						<div class="field">
						  <label class="label">Amount Rs.</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Amount Rs." name='amount' v-model='amount'>
						  </div>
						</div>

						<div style="display: flex;">
							<!-- SMS Configuration -->
							<div class="field" style="margin-right: 30px;">
							  <div class="control">
							    <label class="checkbox">
							      <input type="checkbox" name='sms' v-model='sms'>
							      SMS
							    </label>
							  </div>
							</div>

							<!-- Mail Configuration -->
							<div class="field" style="margin-right: 30px;">
							  <div class="control">
							    <label class="checkbox">
							      <input type="checkbox" name="mail" v-model='mail'>
							      Mail
							    </label>
							  </div>
							</div>

							<!-- Link Configuration -->
							<div class="field">
							  <div class="control">
							    <label class="checkbox">
							      <input type="checkbox" name="link" v-model='generateLink'>
							      Generate Payment Link
							    </label>
							  </div>
							</div>
						</div>
		    		</div>
		    		<div style="flex: 1;">
		    			<!-- City -->
						<div class="field">
						  <label class="label">City</label>
						  <div class="control">
						    <div class="select">
						      <select name='city' v-model='city'>
						        <option>Kolkata</option>
						        <option>Mumbai</option>
						      </select>
						    </div>
						  </div>
						</div>

						<!-- State -->
						<div class="field">
						  <label class="label">State</label>
						  <div class="control">
						    <div class="select">
						      <select name='state' v-model='state'>
						        <option>West Bengal</option>
						        <option>Tamilnadu</option>
						      </select>
						    </div>
						  </div>
						</div>

						<!-- Country -->
						<div class="field">
						  <label class="label">Country</label>
						  <div class="control">
						    <div class="select">
						      <select name='country' v-model='country'>
						        <option>India</option>
						        <option>Sri Lanka</option>
						      </select>
						    </div>
						  </div>
						</div>

		    			<!-- Type Of Work -->
						<div class="field">
						  <label class="label">Type Of Work</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Type Of Work" name="typeOfWork" v-model='typeOfWork'>
						  </div>
						</div>

						<!-- Category -->
						<div class="field">
						  <label class="label">Category</label>
						  <div class="control">
						    <div class="select">
						      <select name="category" v-model='category'>
						        <option>Category - 1</option>
						        <option>Category - 2</option>
						      </select>
						    </div>
						  </div>
						</div>

						<!-- Description -->
						<div class="field">
						  <label class="label">Description</label>
						  <div class="control">
						    <textarea class="textarea" placeholder="Description" name="description" v-model='description'>
						    </textarea>
						  </div>
						</div>

						<!-- Preferred Time -->
						<div class="field">
						  <label class="label">Preferred Time</label>
						  <div class="control">
						    <input class="input" type="text" placeholder="Preferred Time" name="preferredTime" v-model='preferredTime'>
						  </div>
						</div>

		    		</div>
		    	</div>
			</form>
		</div>

		<!-- Assignment Tab -->
		<div v-show="AssignmentTab">
			<div style="padding-top: 20px; display: flex;">
      			<form method="post" action="" style="flex: 1;">

      				<!-- User Role -->
      				<div class="field">
					  <label class="label">Select Role</label>
					  <div class="control">
					      <div id="UserRole" style="">
							<div class="ui radio checkbox" v-for="(role, index) in UserRole" :key="index" style="padding-right: 30px;">
							  <input type="radio" name="role" v-on:change="RoleChanged(role)" :value="role">
							  <label>@{{ role }}</label>
							</div>
							<div class="ui radio checkbox" style="padding-right: 30px;">
							  <input type="radio" name="role" v-on:change="RoleChanged('All')" value="All">
							  <label>All</label>
							</div>
	      				  </div>
					  </div>
					</div>
      				
      				<!-- Assigned To Email -->
					<div class="field">
					  <label class="label">Assigned To </label>
					  <div class="control">
					    <div class="select">
					      <select name="assignedToEmail" v-model='assignedToEmail'>
					        <option v-for="Role in RoleList">@{{ Role }}</option>
					      </select>
					    </div>
					  </div>
					</div>

      			</form>
      			<div id="AssignLog" style="flex: 1;">
      				<table class="table is-bordered is-striped is-narrow">
      					<thead>
	      					<tr>
	      						<th>Assigned By</th>
	      						<th>Assigned To</th>
	      						<th>Assigned On</th>
	      					</tr>
      					</thead>
      					<tbody>
	      					<tr v-for="(row, index) in AssignmentLog" :key="index">
	      						<td>
	      							@{{ row.AssignBy }}
	      						</td>
	      						<td>
	      							@{{ row.AssignTo }}
	      						</td>
	      						<td>
	      							@{{ row.AssignOn }}
	      						</td>
	      					</tr>
      					</tbody>
      				</table>
      			</div>
      		</div>
		</div>

		<!-- Schedule Tab -->
		<div v-show="ScheduleTab">
			<div style="display: flex; padding-top: 20px;">
				<div v-if="isAssigned">
					<a class="button is-success" v-on:click="PickUpAssignment">Pick Up</a>
				</div>
				<div style="flex: 1; padding-right: 20px;" v-show="!isScheduled">
					<form>
						<div style="display: flex;">
							<!-- Date -->
							<div class="field" style="flex: 1; margin-right: 30px;">
							  <label class="label">Date</label>
							  <div class="control">
							    <input placeholder="Select Date" type="text" id="DatePicker" class="datepicker-here input" data-date-format="yyyy-mm-dd" v-model="ScheduleDate" v-on:blur="PutDate">
							  </div>
							</div>

							<!-- Time -->
							<div class="field" style="flex: 1;">
							  <label class="label">Time</label>
							  <div class="control">
							    <input placeholder="Select Time" type="text" id="TimePicker" class="input" v-model="ScheduleTime" v-on:blur="PutTime">
							  </div>
							</div>
						</div>

						<!-- Message Box -->
						<div class="field">
						  <label class="label">Message</label>
						  <div class="control">
						    <textarea class="textarea" placeholder="Textarea" v-model="ScheduleMessage"></textarea>
						    <label style="float: right; color: tomato;">Maximum 100 Character</label>
						  </div>
						</div>

						<a class="button is-info" v-on:click="Schedule">Schedule</a>

					</form>
				</div>
				<!-- When Scheduled -->
				<div style="flex:1; padding-right: 20px;" v-if="isScheduled">
					<div>
						<h1>The Request is Scheduled</h1>
						<p><strong>Scheduled ID : </strong><span>@{{ lastScheduleId }}</span></p>
						<p><strong>Scheduled By : </strong><span>@{{ lastScheduleBy }}</span></p>
						<p><strong>Scheduled On : </strong><span>@{{ lastScheduleOn }}</span></p>
						<p><strong>Scheduled Created : </strong><span>@{{ lastScheduleCreatedOn }}</span></p>
						<p><strong>Details : </strong><span>@{{ lastScheduleMessage }}</span></p>
					</div>
					<div style="margin-top: 30px;">
						<a class="button is-primary" v-on:click="CancelSchedule">Cancel</a>
					</div>
				</div>
				<div style="flex: 2;">
					<table class="table is-bordered is-striped is-narrow">
      					<thead>
	      					<tr>
	      						<th>Scheduled By</th>
	      						<th>Scheduled On</th>
	      						<th>Scheduled Created</th>
	      						<th>Reason</th>
	      						<th>Status</th>
	      					</tr>
      					</thead>
      					<tbody>
	      					<tr v-for="(row, index) in ScheduleLog" :key="index">
	      						<td>
	      							@{{ row.ScheduleBy }}
	      						</td>
	      						<td>
	      							@{{ row.ScheduleOn }}
	      						</td>
	      						<td>
	      							@{{ row.CreatedAt }}
	      						</td>
	      						<td>
	      							@{{ row.Reason }}
	      						</td>
	      						<td>
	      							@{{ row.Status }}
	      						</td>
	      					</tr>
      					</tbody>
      				</table>
				</div>
			</div>
		</div>

		<!-- Call Details Tab -->
		<div v-show="CallDetailsTab">
			<div style="display: flex; padding-top: 20px;">
				<div style="flex: 1;" class="box">
					<h1 class="title" style="font-size: 18px; margin-bottom: 0;">Schedule</h1>
					<hr style="margin-top: 10px; margin-bottom: 10px;">
					<div>
						<span><strong>Date : </strong><span> @{{ ScheduleDateLabel }} </span></span>
					</div>
					<div>
						<span><strong>Time : </strong><span> @{{ ScheduleTimeLabel }} </span></span>
					</div>
				</div>
				<div style="flex: 1;  margin-left: 30px; padding-bottom: 5px;" class="box">
					<h1 class="title" style="margin-bottom: 10px; font-size: 18px;">Actual</h1>
					<div style="display: flex;">
						<!-- Date -->
						<div class="field" style="margin-right: 20px;">
						  <label class="label">Date</label>
						  <div class="control">
						    <input class="input datepicker-here" type="text" placeholder="Select Date" id="ActualDatePicker" data-date-format="yyyy-mm-dd" v-model="ActualDate" v-on:blur="PutActualDate">
						  </div>
						</div>

						<!-- Time -->
						<div class="field" style="margin-right: 20px;">
						  <label class="label">Time</label>
						  <div class="control">
						    <input v-model="ActualTime" placeholder="Select Time" type="text" id="ActualTimePicker" class="input"  v-on:blur="PutActualTime">
						  </div>
						</div>

						<a class="button is-info is-focused" style="position: relative; top: 25px;" v-on:click="GetCurrentTime">
							Update Current Time
						</a>
					</div>
					<!-- Discussion Points -->
					<div class="field">
					  <label class="label">Discussion Points</label>
					  <div class="control">
					    <textarea class="textarea" placeholder="Type Notes" v-model="DiscussionPointNote"></textarea>
					  </div>
					</div>

					<button class="button is-primary" type="button" v-on:click="AddNotes">Add</button>
				</div>
			</div>
			<div style="display: flex;">
				<div style="flex: 1;">

					
					<div class="ui horizontal divider"> Mark Complete </div>
					<div>
						<!-- Mark Complete -->
						<div class="field">
						  <label class="label">Add Final Note</label>
						  <div class="control">
						    <textarea class="textarea" placeholder="Final Notes" v-model="FinalNote"></textarea>
						  </div>
						</div>
						<button class="button is-primary" type="button" v-on:click="AddFinalNote">Mark Complete</button>
						<div class="ui horizontal divider"> Reopen </div>
						<div>
							<div class="field">
							  <label class="label">Note</label>
							  <div class="control">
							    <textarea class="textarea" placeholder="Write Note" v-model="ReopenNote"></textarea>
							  </div>
							</div>
							<div style="display: flex; margin-bottom: 10px;">
								<div class="ui checkbox" style="margin-right: 30px;">
								  <input type="checkbox" name="ReopenSMS" v-model="ReopenSMS">
								  <label>SMS</label>
								</div>
								<div class="ui checkbox">
								  <input type="checkbox" name="ReopenMail" v-model="ReopenMail">
								  <label>Mail</label>
								</div>
							</div>
							<div class="field">
							  <label class="label">Assigned To</label>
							  <div class="control">
							    <input disabled="true" class="input" type="text" placeholder="Text input" v-model="ReopenAssignTo">
							    <label style="float: right;">To Update Go To ASSIGNMENT Tab</label>
							  </div>
							</div>
							<button class="button is-primary" type="button" v-on:click="ReopenRequest">Reopen</button>
						</div>

					</div>
				</div>
				<div style="flex: 1;  margin-left: 30px; margin-top: 15px;">
					<h1 class="title" style="margin-bottom: 15px; font-size: 18px;">Discussion Notes</h1>
					<div style="height: 700px; overflow-y: auto;">
						<div v-for="Notes in DiscussionNotes" class="box" style="margin: 20px; margin-left: 5px;">
							<p>@{{ Notes.Note }}</p>
							<p>@{{ Notes.AddedBy }}</p>
							<p>@{{ Notes.AddedOn }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>

    </section>
    <footer class="modal-card-foot">
    	<!-- Details Footer -->
      	<div v-show="DetailsFooter">
      		<a class="button is-success" v-on:click="AddRequest">Log Request</a>
      		<a class="button is-info" v-on:click="DraftRequest">Save As Draft</a>
      	</div>

      	<!-- Assignment Footer -->
      	<div v-show="AssignmentFooter">
      		<a class="button is-info" v-on:click="AssignTo">Assign</a>
      	</div>

      	<!-- Work Footer -->
      	<div v-show="WorkFooter">
      		
      	</div>

      	<!-- Call Details Footer -->
      	<div v-show='CallDetailsFooter'>
      		
      	</div>
    </footer>
  </div>
</div>

<div id="Status"></div>
</div>

<script type="text/javascript" src="{{ url('js/VidhiComponent/Vidhikarya.js') }}"></script>
<script type="text/javascript">
var OpenData = [];
var UnassignedData = [];
var AssignedData = [];
var ActiveData = [];
var ClosedData = [];
var AllData = [];
var temp = [];
var i = 1;
var numberOfOpenData = 0;
var numberOfUnAssignedData = 0;
var numberOfAssignedData = 0;
var numberOfActiveData = 0;
var numberOfClosedData = 0;
var numberOfAllData = 0;
var UserRole = [];
@foreach($OpenData as $row)
	  numberOfOpenData++;
	  temp.push(i);
	  temp.push('<a onclick="openID({!! $row->request_id !!},\'{!! $row->Status !!}\')">{!! $row->request_id !!}</a>');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  OpenData.push(temp);
	  temp = [];
	  i++;
@endforeach
i=1;
@foreach($UnassignedData as $row)
	  numberOfUnAssignedData++;
	  temp.push(i);
	  temp.push('<a onclick="openID({!! $row->request_id !!},\'{!! $row->Status !!}\', this)">{!! $row->request_id !!}</a>');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  UnassignedData.push(temp);
	  temp = [];
	  i++;
@endforeach
i=1;
@foreach($AssignedData as $row)
	  numberOfAssignedData++;
	  temp.push(i);
	  temp.push('<a onclick="openID({!! $row->request_id !!},\'{!! $row->Status !!}\', this)">{!! $row->request_id !!}</a>');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  AssignedData.push(temp);
	  temp = [];
	  i++;
@endforeach
i=1;
@foreach($ActiveData as $row)
	  numberOfActiveData++;
	  temp.push(i);
	  temp.push('{!! $row->request_id !!}');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  ActiveData.push(temp);
	  temp = [];
	  i++;
@endforeach
i=1;
@foreach($ClosedData as $row)
	  numberOfClosedData++;
	  temp.push(i);
	  temp.push('{!! $row->request_id !!}');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  ClosedData.push(temp);
	  temp = [];
	  i++;
@endforeach
i=1;
@foreach($AllData as $row)
	  numberOfAllData++;
	  temp.push(i);
	  temp.push('<a onclick="openID({!! $row->request_id !!},\'{!! $row->Status !!}\')">{!! $row->request_id !!}</a>');
	  temp.push('{!! $row->Category !!}');
	  temp.push('{!! $row->TypeOfWork !!}');
	  temp.push('{!! $row->LoggedBy !!}');
	  temp.push('{!! $row->PhoneNumber !!}');
	  temp.push('{!! $row->AssignedToEmail !!}');
	  temp.push('{!! $row->Status !!}');
	  temp.push('{!! $row->FirstName." ".$row->LastName !!}');
	  AllData.push(temp);
	  temp = [];
	  i++;
@endforeach

// Getting User Role --------------
@forEach($UserRole as $role)
	UserRole.push('{!! $role !!}');
@endforeach
$(document).ready(function(){
	$('#DatePicker').datepicker({
		language: 'en',
	    minDate: new Date()
	});
	$('#ActualDatePicker').datepicker({
		language: 'en',
	    minDate: new Date()
	});
	$('#TimePicker').timepicker();
	$('#ActualTimePicker').timepicker();

	$('#OpenDataTable').DataTable( {
	    data: OpenData,
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
	$('#UnAssignedDataTable').DataTable( {
	    data: UnassignedData, 
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
	$('#AssignedDataTable').DataTable( {
	    data: AssignedData, 
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
	$('#ActiveDataTable').DataTable( {
	    data: ActiveData, 
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
	$('#ClosedDataTable').DataTable( {
	    data: ClosedData, 
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
	$('#AllDataTable').DataTable( {
	    data: AllData,
	    "pageLength" : 5 //Specify the Number of Row in each page .
	});
});
function openID(requestId, status, row){
	GetAssignmentLog(requestId);
	GetScheduleLog(requestId);
	GetDiscussionPointNotes(requestId);
	GetRequestDetails(requestId);
	if (status == "Draft") {
		$("#AssignedToEmail").prop("disabled", true);
		$(".modal").addClass("is-active");
		Home.request_id = requestId;

		// Request Status ---
		Home.isDraft = true;
		Home.isOpen = false;
		Home.isUnassigned = false;
		Home.isAssigned = false;
		Home.isActive = false;
		Home.isClosed = false;
	}
	else if(status == "Unassigned"){
		$("#AssignedToEmail").prop("disabled", false);
		$(".modal").addClass("is-active");
		Home.assignRequestId = requestId;

		// Request Status ---
		Home.isDraft = false;
		Home.isOpen = false;
		Home.isUnassigned = true;
		Home.isAssigned = false;
		Home.isActive = false;
		Home.isClosed = false;
	}
	else if(status == "Assigned"){
		$(".modal").addClass("is-active");
		Home.assignRequestId = requestId;
		
		// Request Status ---
		Home.isDraft = false;
		Home.isOpen = false;
		Home.isUnassigned = false;
		Home.isAssigned = true;
		Home.isActive = false;
		Home.isClosed = false;
	}
}
function GetScheduleLog(requestId){
	let formData={
    	'requestId' : requestId,
        '_token': "{{csrf_token()}}"
    };
    $.ajax({
        type: "post",
        url: "/GetScheduleLog",
        data: formData,
        dataType: 'json',
        success: function (data) {
            var ReturnedData=JSON.parse(JSON.stringify(data));
            if ('success' in ReturnedData) {
                var data = ReturnedData['Data'];
                var length = data.length;
                var i = 0;
                Home.ScheduleLog = [];
                while(i<length){
                	var temp = {};
                	temp['ScheduleBy'] = data[i].ScheduleBy;
                	temp['ScheduleOn'] = data[i].ScheduleOn;
                	temp['CreatedAt'] = data[i].created_at;
                	temp['Reason'] = data[i].ScheduleMessage;
                	temp['Status'] = data[i].Status;
                	Home.ScheduleLog.push(temp);
                	i++;
                }
                Home.ScheduleDateLabel = ReturnedData.ScheduleDate;
                Home.ScheduleTimeLabel = ReturnedData.ScheduleTime;
                Home.lastScheduleId = ReturnedData.lastScheduleId;
                Home.lastScheduleMessage = ReturnedData.lastScheduleMessage;
                Home.lastScheduleBy = ReturnedData.lastScheduleBy;
                Home.lastScheduleCreatedOn = ReturnedData.lastScheduleCreated;
                Home.lastScheduleOn = ReturnedData.lastScheduleOn;
                if (ReturnedData.isScheduled) {
                	Home.isScheduled = true;
                }
                else{
                	Home.isScheduled = false;
                }
            }
        }.bind(this),
        error: function (data) {
            $("#Status").append(JSON.stringify(data));
        }.bind(this)
    });
}
function GetRequestDetails(requestId){
	let formData={
    	'requestId' : requestId,
        '_token': "{{csrf_token()}}"
    };
    $.ajax({
        type: "post",
        url: "/GetRequestDetailsByID",
        data: formData,
        dataType: 'json',
        success: function (data) {
            var ReturnedData=JSON.parse(JSON.stringify(data));
            if ('success' in ReturnedData) {
                var data = ReturnedData['data'];
                Home.request_id = requestId;
                Home.email = data.Email;
                Home.phoneNumber = data.PhoneNumber;
                Home.firstName = data.FirstName;
                Home.lastName = data.LastName;
                Home.place = data.Place;
                Home.city = data.City;
                Home.state = data.State;
                Home.country = data.Country;
                Home.amount = data.Amount;
                Home.assignedToEmail = data.AssignedToEmail;
                Home.sms = data.SMSTrigger;
                Home.mail = data.MailTrigger;
                Home.typeOfWork = data.TypeOfWork;
                Home.category = data.Category;
                Home.description = data.Details;
                Home.preferredTime = data.PreferredTime;

                // Details ---
                Home.ReopenAssignTo = data.AssignedToEmail;
            }
        }.bind(this),
        error: function (data) {
            $("#Status").append(JSON.stringify(data));
        }.bind(this)
    });
}
function GetAssignmentLog(requestId){
	let formData={
    	'requestId' : requestId,
        '_token': "{{csrf_token()}}"
    };
    $.ajax({
        type: "post",
        url: "/GetAssignmentLog",
        data: formData,
        dataType: 'json',
        success: function (data) {
            var ReturnedData=JSON.parse(JSON.stringify(data));
            if ('success' in ReturnedData) {
                var data = ReturnedData['Data'];
                var length = data.length;
                var i = 0;
                Home.AssignmentLog = [];
                while(i<length){
                	var temp={};
                	temp['AssignBy'] = data[i].AssignBy;
                	temp['AssignTo'] = data[i].AssignTo;
                	temp['AssignOn'] = data[i].created_at;
                	Home.AssignmentLog.push(temp);
                	i++;
                }
            }
        }.bind(this),
        error: function (data) {
            $("#Status").append(JSON.stringify(data));
        }.bind(this)
    });
}
function GetDiscussionPointNotes(requestId){
	let formData={
    	'requestId' : requestId,
        '_token': "{{csrf_token()}}"
    };
    $.ajax({
        type: "post",
        url: "/GetDiscussionPointNotes",
        data: formData,
        dataType: 'json',
        success: function (data) {
            var ReturnedData=JSON.parse(JSON.stringify(data));
            if ('success' in ReturnedData) {
                var data = ReturnedData['Notes'];
                var length = data.length;
                var i = 0;
                Home.DiscussionNotes = [];
                while(i<length){
                	var temp={};
                	temp['Note'] = data[i].Notes;
                	temp['AddedBy'] = data[i].AddedBy;
                	temp['AddedOn'] = data[i].created_at;
                	Home.DiscussionNotes.push(temp);
                	i++;
                }
            }
        }.bind(this),
        error: function (data) {
            $("#Status").append(JSON.stringify(data));
        }.bind(this)
    });
}
function GetCurrentDate(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth();
	var yyyy = today.getFullYear();

	var date = yyyy + "-" + mm + "-" + dd;
	return date;
}
function GetCurrentTime(){
	var today = new Date();
	var hours = today.getHours();
	var minutes = today.getMinutes();
	var seconds = today.getSeconds();

	var time = hours + ":" + minutes + ":" + seconds;
	return time;
}
var Home = new Vue({
	el:'#PageContent',
	data:{
		// Request Status ---------
		isDraft : false, 
		isOpen : false, 
		isUnassigned : false, 
		isAssigned : false, 
		isActive : false, 
		isClosed : false, 
		// Form Data -----------------
		email : '',
		phoneNumber : '',
		firstName : '',
		lastName : '',
		place : '',
		city : 'Kolkata',
		state : 'West Bengal',
		country : 'India',
		amount : '',
		sms : '',
		mail : '',
		typeOfWork : '',
		category : '',
		description : '',
		preferredTime : '',
		request_id : '',
		generateLink : true,

		modalActive : false,
		OpenTab : true,
		UnassignedTab : false,
		AssignedTab : false,
		ActiveTab : false,
		ClosedTab : false,
		AllTab : false,
		Tabs : [
			{ 'TabName' : 'Open', 'Counter' : numberOfOpenData, 'isActive' : true },
			{ 'TabName' : 'Unassigned', 'Counter' : numberOfUnAssignedData, 'isActive' : false },
			{ 'TabName' : 'Assigned', 'Counter' : numberOfAssignedData, 'isActive' : false },
			{ 'TabName' : 'Active', 'Counter' : numberOfActiveData, 'isActive' : false },
			{ 'TabName' : 'Closed', 'Counter' : numberOfClosedData, 'isActive' : false },
			{ 'TabName' : 'All', 'Counter' : numberOfAllData, 'isActive' : false }
		],

		// Modal Tabs
		DetailsTab : true,
		AssignmentTab : false,
		ScheduleTab : false,
		CallDetailsTab : false,
		ModalTabs : [
			{ 'TabName' : 'Details', 'isActive' : true },
			{ 'TabName' : 'Assignment', 'isActive' : false },
			{ 'TabName' : 'Schedule', 'isActive' : false },
			{ 'TabName' : 'Call Details', 'isActive' : false }
		],

		assignedToEmail : '',
		assignRequestId : 0,

		// Footer
		DetailsFooter : true,
		AssignmentFooter : false,
		WorkFooter : false,
		CallDetailsFooter : false,

		// Schedule Data -----
		ScheduleDate : '',
		ScheduleTime : '',
		ScheduleMessage : '',
		isScheduled : false,
		lastScheduleId : 0,
		lastScheduleBy : '',
		lastScheduleOn : '',
		lastScheduleCreatedOn : '',
		lastScheduleMessage : '',

		// Array Data ------
		UserRole : UserRole,
		RoleList : [],
		AssignmentLog : [],
		ScheduleLog : [],
		DiscussionNotes : [],

		// Call Details data ----
		ActualDate : '',
		ActualTime : '',
		DiscussionPointNote : '',
		FinalNote : '',
		ReopenNote : '',
		ReopenSMS : '',
		ReopenMail : '',
		ReopenAssignTo : '',
		ScheduleDateLabel : '',
		ScheduleTimeLabel : ''
	},
	methods:{
		CancelSchedule:function(){
			let formData={
	        	'requestId' : this.assignRequestId,
	        	'ScheduleId' : this.lastScheduleId,
	        	'Req_Sequence' : 1,
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/CancelSchedule",
	            data: formData,
	            dataType: 'json',
	            success: function(data){
	            	var ReturnedData=JSON.parse(JSON.stringify(data));
	                if ("Status" in ReturnedData) {
	                	this.isScheduled = false;
	                }
	                else{

	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });		
		},
		SubmitRequest:function(){
			$('#UpdateRequestForm').submit();
		},
		AddRequest:function(){
			// $('#RequestForm').submit();
			let formData={
	        	'requestId' : this.request_id,
	        	'email' : this.email,
				'phoneNumber' : this.phoneNumber,
				'firstName' : this.firstName,
				'lastName' : this.lastName,
				'place' : this.place,
				'city' : this.city,
				'state' : this.state,
				'country' : this.country,
				'amount' : this.amount,
				'assignedToEmail' : this.assignedToEmail,
				'sms' : this.sms,
				'mail' : this.mail,
				'generateLink' : this.generateLink,
				'typeOfWork' : this.typeOfWork,
				'category' : this.category,
				'description' : this.description,
				'preferredTime' : this.preferredTime,
				'request_id' : this.request_id,
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/AddRequest",
	            data: formData,
	            dataType: 'json',
	            success: function (data) {
	                var ReturnedData=JSON.parse(JSON.stringify(data));
	                if ('success' in ReturnedData) {
	                    var RequestID = ReturnedData['RequestID'];
	                    alert(RequestID);
	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });
		},
		DraftRequest:function(){
		    // $('#RequestForm').attr('action', "DraftRequest").submit();
		    let formData={
	        	'requestId' : this.request_id,
	        	'email' : this.email,
				'phoneNumber' : this.phoneNumber,
				'firstName' : this.firstName,
				'lastName' : this.lastName,
				'place' : this.place,
				'city' : this.city,
				'state' : this.state,
				'country' : this.country,
				'amount' : this.amount,
				'assignedToEmail' : this.assignedToEmail,
				'sms' : this.sms,
				'mail' : this.mail,
				'generateLink' : this.generateLink,
				'typeOfWork' : this.typeOfWork,
				'category' : this.category,
				'description' : this.description,
				'preferredTime' : this.preferredTime,
				'request_id' : this.request_id,
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/DraftRequest",
	            data: formData,
	            dataType: 'json',
	            success: function (data) {
	                var ReturnedData=JSON.parse(JSON.stringify(data));
	                if ('success' in ReturnedData) {
	                    var RequestID = ReturnedData['RequestID'];
	                    alert(RequestID);
	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });
		},
		CloseModal:function(){
			$(".modal").removeClass("is-active");
			this.modalActive = false;
		},
		OpenModal:function(){
			$(".modal").addClass("is-active");
			this.email = "";
			this.phoneNumber = "";
			this.firstName = "";
			this.lastName = "";
			this.place = "";
			this.city = "";
			this.state = "";
			this.country = "";
			this.amount = "";
			this.assignedToEmail = "";
			this.sms = false;
			this.mail = false;
			this.generateLink = true;
			this.typeOfWork = "";
			this.category = "";
			this.description = "";
			this.preferredTime = "";
			this.modalActive = true;
			this.request_id = "";
		},
		ChangeTab:function(SelectedTab){
			this.Tabs.forEach(tab => {
				if (tab.TabName == SelectedTab) { tab.isActive = true; } else{ tab.isActive = false; }
			});
			if (SelectedTab == "Open") {
				this.OpenTab = true;
				this.UnassignedTab = false;
				this.AssignedTab = false;
				this.ActiveTab = false;
				this.ClosedTab = false;
				this.AllTab = false;
			}
			else if(SelectedTab == "Unassigned"){
				this.UnassignedTab = true;
				this.OpenTab = false;
				this.AssignedTab = false;
				this.ActiveTab = false;
				this.ClosedTab = false;
				this.AllTab = false;
			}
			else if(SelectedTab == "Assigned"){
				this.AssignedTab = true;
				this.OpenTab = false;
				this.UnassignedTab = false;
				this.ActiveTab = false;
				this.ClosedTab = false;
				this.AllTab = false;
			}
			else if(SelectedTab == "Active"){
				this.ActiveTab = true;
				this.AssignedTab = false;
				this.OpenTab = false;
				this.UnassignedTab = false;
				this.ClosedTab = false;
				this.AllTab = false;
			}
			else if(SelectedTab == "Closed"){
				this.ClosedTab = true;
				this.ActiveTab = false;
				this.AssignedTab = false;
				this.OpenTab = false;
				this.UnassignedTab = false;
				this.AllTab = false;
			}
			else if(SelectedTab == "All"){
				this.AllTab = true;
				this.ClosedTab = false;
				this.ActiveTab = false;
				this.AssignedTab = false;
				this.OpenTab = false;
				this.UnassignedTab = false;
			}
		},
		ChangeModalTab:function(SelectedTab){
			this.ModalTabs.forEach(tab => {
				if (tab.TabName == SelectedTab) { tab.isActive = true; } else{ tab.isActive = false; }
			});
			if (SelectedTab == "Details") {
				this.DetailsTab = true;
				this.AssignmentTab = false;
				this.ScheduleTab = false;
				this.CallDetailsTab = false;

				this.DetailsFooter = true;
				this.AssignmentFooter = false;
				this.WorkFooter = false;
				this.CallDetailsFooter = false;
			}
			else if(SelectedTab == "Assignment"){
				this.AssignmentTab = true;
				this.DetailsTab = false;
				this.ScheduleTab = false;
				this.CallDetailsTab = false;

				this.AssignmentFooter = true;
				this.DetailsFooter = false;
				this.WorkFooter = false;
				this.CallDetailsFooter = false;
			}
			else if(SelectedTab == "Schedule"){
				this.ScheduleTab = true;
				this.DetailsTab = false;
				this.AssignmentTab = false;
				this.CallDetailsTab = false;

				this.WorkFooter = true;
				this.DetailsFooter = false;
				this.AssignmentFooter = false;
				this.CallDetailsFooter = false;
			}
			else if(SelectedTab == "Call Details"){
				this.CallDetailsTab = true;
				this.ScheduleTab = false;
				this.DetailsTab = false;
				this.AssignmentTab = false;

				this.CallDetailsFooter = true;
				this.WorkFooter = false;
				this.DetailsFooter = false;
				this.AssignmentFooter = false;
			}
		},
		RoleChanged:function(value){
			let formData={
        	'Role' : value,
            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/GetRoleData",
	            data: formData,
	            dataType: 'json',
	            success: function (data) {
	                var ReturnedData=JSON.parse(JSON.stringify(data));
	                if ('success' in ReturnedData) {
	                    var Data = ReturnedData['Data'];
	                    var length = Data.length;
	                    var i = 0;
	                    this.RoleList = [];
	                    while(i<length){
	                    	this.RoleList.push(Data[i].Email);
	                    	i++;
	                    }
	                    this.assignedToEmail = Data[0].Email;
	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });
		},
		AssignTo:function(){
			let formData={
        	'assignTo' : this.assignedToEmail,
        	'requestId' : this.assignRequestId,
            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/AssignTo",
	            data: formData,
	            dataType: 'json',
	            success: function (data){
	                var ReturnedData=JSON.parse(JSON.stringify(data));
	                if ('Status' in ReturnedData){
	                    var temp = {};
	                    temp['AssignBy'] = ReturnedData.AssignBy;
	                    temp['AssignTo'] = this.assignedToEmail;
	                    temp['AssignOn'] = ReturnedData.AssignOn.date;
	                    this.AssignmentLog.unshift(temp);
	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });
		},
		PickUpAssignment:function(){
			let formData={
        	'requestId' : this.assignRequestId,
            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/PickUpAssignment",
	            data: formData,
	            dataType: 'json',
	            success: function (data){
	                // var ReturnedData=JSON.parse(JSON.stringify(data));
	                // if ('Status' in ReturnedData){
	                //     var temp = {};
	                //     temp['AssignBy'] = ReturnedData.AssignBy;
	                //     temp['AssignTo'] = this.assignedToEmail;
	                //     temp['AssignOn'] = ReturnedData.AssignOn.date;
	                //     this.AssignmentLog.unshift(temp);
	                // }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });	
		},
		Schedule:function(){
			var date = this.ScheduleDate;
			var time = this.ScheduleTime + ":00";
			var datetime = date + " " + time;
			// alert(datetime);
			if (this.ScheduleTime == "" || this.ScheduleTime == "") {
				alert("Select Date and Time !");
				return;
			}
			let formData={
	        	'requestId' : this.assignRequestId,
	        	'ScheduleOn' : datetime,
	        	'ScheduleMessage' : this.ScheduleMessage,
	        	'Status' : 'Scheduled',
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/ScheduleRequest",
	            data: formData,
	            dataType: 'json',
	            success: function (data){
	                var ReturnedData=JSON.parse(JSON.stringify(data));
	                var Currentdatetime = GetCurrentDate() + " " + GetCurrentTime();
	                if ('Status' in ReturnedData){
	                    var temp = {};
	                    temp['ScheduleBy'] = ReturnedData.ScheduleBy;
	                    temp['ScheduleOn'] = Currentdatetime;
	                    temp['CreatedAt'] = datetime;
	                    temp['Reason'] = this.ScheduleMessage;
	                    temp['Status'] = 'Scheduled';
	                    this.ScheduleLog.unshift(temp);
	                    this.isScheduled = true;
	                    this.lastScheduleId = ReturnedData.ScheduleId;

	                    this.lastScheduleBy = ReturnedData.ScheduleBy;
						this.lastScheduleOn = datetime;
						this.lastScheduleCreatedOn = Currentdatetime;
						this.lastScheduleMessage = this.ScheduleMessage;
	                }
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });	
		},
		PutDate:function(){
			this.ScheduleDate = $("#DatePicker").val();
		},
		PutActualDate:function(){
			this.ActualDate = $("#ActualDatePicker").val();
		},
		PutTime:function(){
			this.ScheduleTime = $("#TimePicker").val();
		},
		PutActualTime:function(){
			this.ActualTime = $("#ActualTimePicker").val();
		},
		GetCurrentTime:function(){
			var date = GetCurrentDate();
			var today = new Date();
			var hours = today.getHours();
			var minutes = today.getMinutes();
			var time = hours + ":" + minutes;
			this.ActualDate = date;
			this.ActualTime = time;
		},
		AddNotes:function(){
			var date = this.ActualDate;
			var time = this.ActualTime;
			var datetime = date + " " + time;
			let formData={
	        	'requestId' : this.assignRequestId,
	        	'Note' : this.DiscussionPointNote,
	        	'ActualDateTime' : datetime,
	        	'Req_Sequence' : 1,
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/DiscussionPointAddNote",
	            data: formData,
	            dataType: 'json',
	            success: function(data){
	            	var ReturnedData=JSON.parse(JSON.stringify(data));
	                var date = GetCurrentDate();
	                var time = GetCurrentTime();
	                var datetime = date + " " + time;
	                if ("Status" in ReturnedData) {
		                var temp = {};
	                    temp['Note'] = this.DiscussionPointNote;
	                    temp['AddedBy'] = ReturnedData.AddedBy;
	                    temp['AddedOn'] = datetime;
	                    this.DiscussionNotes.unshift(temp);	
	                }                    
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });	
		},
		AddFinalNote:function(){
			let formData={
	        	'requestId' : this.assignRequestId,
	        	'Note' : this.FinalNote,
	        	'Req_Sequence' : 1,
	            '_token': "{{csrf_token()}}"
	        };
	        $.ajax({
	            type: "post",
	            url: "/AddFinalNote",
	            data: formData,
	            dataType: 'json',
	            success: function(data){
	            	var ReturnedData=JSON.parse(JSON.stringify(data));
	                var date = GetCurrentDate();
	                var time = GetCurrentTime();
	                var datetime = date + " " + time;
	                if ("Status" in ReturnedData) {
		                var temp = {};
	                    temp['Note'] = this.DiscussionPointNote;
	                    temp['AddedBy'] = ReturnedData.AddedBy;
	                    temp['AddedOn'] = datetime;
	                    this.DiscussionNotes.unshift(temp);	
	                }                    
	            }.bind(this),
	            error: function (data) {
	                $("#Status").append(JSON.stringify(data));
	            }.bind(this)
	        });		
		},
		ReopenRequest:function(){

		}
	}
});
</script>
@stop