@extends('Layouts.Master')
@section('title','Home')
@section('content')
<div id="PageContent" style="display: flex; justify-content: center; align-items: center;">
	<div class="box" style="width: 300px; margin:10px;">

		<!-- Name -->
		<div class="field">
		  <label class="label">Name</label>
		  <div class="control">
		    <input v-model='name' class="input" type="text" placeholder="Name">
		  </div>
		</div>

		<!-- Email -->
		<div class="field">
		  <label class="label">Email</label>
		  <div class="control">
		    <input v-model='email' class="input" type="text" placeholder="Email">
		  </div>
		</div>

		<!-- Phone Number -->
		<div class="field">
		  <label class="label">Phone Number</label>
		  <div class="control">
		    <input v-model='phoneNumber' class="input" type="text" placeholder="Phone Number">
		  </div>
		</div>

		<!-- Password -->
		<div class="field">
		  <label class="label">Password</label>
		  <div class="control">
		    <input v-model='password' class="input" type="password" placeholder="Password">
		  </div>
		</div>

		<!-- Retype Password -->
		<div class="field">
		  <label class="label">Retype Password</label>
		  <div class="control">
		    <input v-model='password_confirmation' class="input" type="password" placeholder="Retype Password">
		  </div>
		</div>

		<div style="display: flex; justify-content: flex-end;">
			  <a class="button is-success" style="margin:10px; margin-right: 0;" v-on:click="Register">Submit</a>
		</div>

		<div id="Status"></div>
	</div>
</div>
<script type="text/javascript">
new Vue({
	el:'#PageContent',
	data:{
		name : "",
		email : "",
		phoneNumber : "",
		password : "",
		password_confirmation : "",
		'_token': "{{csrf_token()}}"
	},
	methods:{
		Register:function(){
			let formData={
                'name' : this.name,
                'email' : this.email,
                'phoneNumber' : this.phoneNumber,
                'password_confirmation' : this.password_confirmation,
                'password' : this.password,
                '_token': "{{csrf_token()}}"
            };
			$.ajax({
                type: "post",
                url: "/Register",
                data: formData,
                dataType: 'json',
                success: function (data) {
                    var ReturnedData=JSON.parse(JSON.stringify(data));
                    if ('Status' in ReturnedData) {
                      if (ReturnedData.Status == "Registered") {
                      		alert("Registration Successful !");
                      		window.location = "/";
                      }
                      else if(ReturnedData.Status == "PasswordMismatch"){
                      		alert("Password Do Not Match !");
                      }
                      else{

                      }
                    }
                }.bind(this),
                error: function (data) {
                    $("#Status").append(JSON.stringify(data));
                }.bind(this)
            });
		}
	}
});
</script>
@stop