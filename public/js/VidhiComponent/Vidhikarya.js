Vue.component('chatForm',{
template:`
<form onsubmit="return false">
  <div style="display: flex;">
    <div style="flex-basis: auto; flex-grow: 1;">
      <input v-model="Message" v-on:keyup.enter="SendMessage" placeholder="Type Your Message Here !" type="text" name="message">
    </div>
    <div style="flex-basis: auto;">
      <a class="button is-light" style="height:inherit;" v-on:click="SendMessage">Send</a>
    </div>
  </div>
</form>`,
});
Vue.component('chatList',{
  props:['people'],
  template:`
<div class="ui vertical menu pointing">
  <people-in-chat-list v-for='(person, index) in people' :person='person' :key='index' v-on:personchanged='personupdated'></people-in-chat-list>
  <!-- <div class="item">
    <div class="ui transparent icon input">
      <input type="text" placeholder="Search mail...">
      <i class="material-icons icon">search</i>
    </div>
  </div> -->
</div>
  `,
  methods:{
    personupdated:function(id,name){
      this.$emit('personchanged',id,name);
    }
  }
});
Vue.component('peopleInChatList',{
  props:['person'],
  template:`
  <a class="teal item active" style="background-color: rgba(0, 0, 0, 0.05) !important;" v-on:click="PersonClicked">
    {{ person.Name }}
    <div class="ui teal left pointing label" style="float:right !important;">1</div>
  </a>
  `,
  methods:{
    PersonClicked:function(){
        this.$emit('personchanged',this.person.ID,this.person.Name);
    }
  }
});
// Gender Select ----
Vue.component('semanticGender', {
  props:['value','isRequired'],
  template:`
<div class="ui form">
  <div class="field">
      <label>Gender</label>
      <div class="ui selection dropdown" id='genderSelect'>
          <input type="hidden" name="" v-bind:value='value'>
          <i class="dropdown icon"></i>
          <div class="default text">Gender</div>
          <div class="menu">
              <div class="item" data-value="Male" v-on:click="updateValue('Male')">Male</div>
              <div class="item" data-value="Female" v-on:click="updateValue('Female')">Female</div>
          </div>
      </div>
  </div>
</div>
  `,
  mounted(){
    $('#genderSelect').dropdown();
  },
  methods:{
    updateValue:function(value){
      this.$emit('input',value);
    }
  }
});
// Text Box ---------
Vue.component('bulmaTextbox',{
  props:['value','placeholder','firstIcon','secondIcon', 'hasError','label','isRequired','errorMessage','id'],
  template:`
<div class="field">
  <label class="label">{{ label }}</label>
  <p class="control has-icons-left has-icons-right">
    <input v-bind:value='value' v-on:input="updateValue($event.target.value)" class="input" :class="statusClass" type="text" :placeholder="placeholder" value="" :id='id'>
    <span class="icon icon-override is-small is-left">
      <i class="fa" :class='firstIcon'></i>
    </span>
    <span class="icon icon-override is-small is-right">
      <i class="fa" :class='computedSecondIcon'></i>
    </span>
  </p>
  <p class="help is-danger" style='font-size:13px;' v-if='computedHasError'>{{ computedErrorMessage }}</p>
</div>
  `,
  data:function(){
    return {
      computedHasError : '',
      computedErrorMessage : '',
    }
  },
  methods:{
    updateValue:function(value){
      if ( value == "" && this.required == true ) {
        this.computedHasError = true;
        this.computedErrorMessage = "This field is required !";
      }
      else if(value != "" && this.required == true){
        this.computedHasError = false;
      }
      if (this.required == false && value == "") {
        this.computedHasError = "";
      }
      else if(this.required == false && value != null){
        this.computedHasError = false;
      }
      this.$emit('input',value);
    }
  },
  mounted(){
      if (this.hasError === null || this.hasError === undefined) {
        this.computedHasError = "";
      }
      else if(this.hasError == ""){
        this.computedHasError = "";
      }
      else if(this.hasError === false){
        this.computedHasError = false;
      }
      else{
        this.computedHasError = true;
      }
      // Error Message ---
      this.computedErrorMessage = this.errorMessage;
  },
  watch:{
      hasError:function(){
          if (this.hasError == true) {
            this.computedHasError = true;
          }
          else{
            this.computedHasError = false;
          }
      },
      errorMessage:function(){
        this.computedErrorMessage = this.errorMessage;
      }
  },
  computed:{
    required:function(){
      if (this.isRequired == "Yes") {
        return true;
      }
      else{
        return false;
      }
    },
    computedSecondIcon:function(){
      if (this.computedHasError == true) {
        return "fa-warning";
      }
      else if (this.computedHasError === false) {
        return "fa-check";
      }
      else if (this.computedHasError == "" || this.computedHasError == undefined || this.computedHasError == null) {
        return "fa-question";
      }
    },
    statusClass:function(){
      if (this.computedHasError == true) {
        return 'is-danger';
      }
      else if (this.computedHasError === false) {
        return "is-success";
      }
      else if(this.computedHasError == "" || this.computedHasError == null || this.computedHasError == undefined){
        return "";
      }
    }
  }
});


// Header - Navbar
Vue.component('headerIcon',{
	props:['iconName','counter'],
	template:`
<div style="position: relative; cursor: pointer; display: inline-block; margin-right: 20px;">
  <div v-on:click="Clicked" style="height: 50px; width: 60px; display: flex; justify-content: center; align-items: center;">
      <v-icon light>{{iconName}}</v-icon>
  </div>
  <div style="position: absolute; top: 3px; right: 3px; height: 20px; width: 20px; border-radius: 50%; display: flex; justify-content: center; align-items: center; background: rgba(255,255,255,.12);">
      <span style="color: #fff;">{{ counter }}</span>
  </div>
</div>
	`,
	methods:{
		Clicked:function(){
			this.$emit('iconclicked');
		},
	}
});
// Header - Navbar
Vue.component('messageNotify',{
	props:['message'],
	template:`
<div>
    <div style="width: 100%; text-align: left; margin-left: 10px;">
        <a :href="message.Location">
        	<span>{{ message.SenderName }}</span> has sent you a message. <br> 
        	<span style="color: #ddd; font-size: 12px;">{{ message.SentTime }}</span>
        </a>
        <v-divider style='margin-top: 10px; margin-bottom: 10px;'></v-divider>
    </div>
</div>
`,
});
Vue.component('flyWindow',{
	props:["heading"],
	template:`
<div style="width:300px; height: 300px; position: absolute; top: 50px; right: 100px; z-index: 5000; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); background-color: #fff;  overflow-y:auto;">
    <div style="height: 30px;">
        <span style="font-size: 20px; color:#795548;">{{ heading }}</span>
    </div>
    <v-divider style='margin-top:10px; margin-bottom: 10px;'></v-divider>
    <slot></slot>
</div>
	`,
});
// Lawyer Dashboard ----- Card
Vue.component('caseCard',{
  props:['caseData'],
  template:`
<div class="CaseCard">
  <div class="CaseCardHeading">
    <span class="Category">{{ Case.caseCategory }}</span>
    <span class="CreatedOn">{{ Case.caseCreatedOn}}</span>
  </div>
  <div class="CaseCardContent">
    <span v-html="Case.caseTitle"></span><br>
    <span class="OptionTitle">Case Due Date :</span><span class="OptionValue">{{ Case.caseDueDate }}</span><br>
    <span class="OptionTitle">Case Status :</span><span class="OptionValue" style="color:#23d160; font-weight:bold;">{{ Case.caseStatus }}</span><br>
  </div>
</div>
`,
computed:{
  Case:function(){
    return this.caseData;
  }
}
});

// Tabs --
Vue.component('neoTab',{
  props:['data','tabName'],
  template:`
  <span style="cursor:pointer;">
    <a style="background-color:transparent;" class="reponav-item" v-on:click="TabClicked" :class="{selected : data.isActive}">
      <span>{{ data.TabName }}</span><span v-if="hasCounter" class="Counter">{{ data.Counter}}</span>
    </a>
  </span>
  `,
  data:function(){
    return {

    };
  },
  computed:{
    hasCounter:function(){
      if ('Counter' in this.data) {
        return true;
      }
      else{
        return false;
      }
    }
  },
  methods:{
    TabClicked:function(){
      this.$emit('changed',this.tabName);
    },
  }
});