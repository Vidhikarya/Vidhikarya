@extends('Layouts.Master')
@section('title','Log In')
@section('content')
<div id="PageContent" style='width: 70%; margin: auto; margin-top: 50px; display: flex; justify-content: center; height:100%;'>
	<div class="box" style='width: 300px; margin-bottom: 10px;'>
		<div v-if="hasError" class="notification is-danger" style="padding: 10px;">
	        <button class="delete" @click="closeAlert"></button>
	        <strong>Log In Failed ! </strong> Wrong email or password
	    </div>

	    <!-- Email -->
	    <div>
	    	<div class="field">
			  <label class="label">Email</label>
			  <div class="control">
			    <input v-model="email" name="email" id="email" class="input" type="text" placeholder="Email">
			  </div>
			</div>
	    </div>

	    <!-- Password -->
	    <div>
	    	<div class="field">
			  <label class="label">Password</label>
			  <div class="control">
			    <input v-model="password" name="password" id="password" class="input" type="password" placeholder="Password">
			  </div>
			</div>
	    </div>

	    <div style="display: flex; justify-content: flex-end; margin-top: 30px;">
	          <a class="button is-success" v-on:click="LogIn">Log In</a>
	    </div>

	    <div id="Status"></div>
	</div>
</div>
<script type="text/javascript">
	let data={
	    email : '',
	    password : '',
	    hasError : false,
	};
	LoginApp = new Vue({
	    el : '#PageContent',
	    data : data,
	    methods:{
	        LogIn:function(){
	            let formData={
	                'email' : this.email,
	                'password' : this.password,
	                '_token': '{!! csrf_token() !!}'
	            };
	            $.ajax({
	                    type: "post",
	                    url: "/login",
	                    data: formData,
	                    dataType: 'json',
	                    success: function (data) {
	                    	this.hasError = false;
	                    	var ReturnedData = JSON.parse(JSON.stringify(data));
	                    	if (ReturnedData.success == false) {
	                        	this.hasError = true;
	                    	}
		                    if (ReturnedData.success == true) {
		                        window.location = "{{ url('/') }}";
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