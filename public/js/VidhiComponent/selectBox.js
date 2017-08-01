Vue.component('vidhiSelectBox',{
	props:['items','selected','label','name','dataError','iconName'],
	template:`
	<div class="neoSelectBox row" style="width:100%; margin-bottom:25px;">
	<div class="col-md-1" v-if="hasIcon" style="padding-top:10px;">
		<i class="material-icons" style="font-size:35px;">{{ iconName }}</i>
	</div>
	<div class="col-md-9">
	<select :id="name" :name="name" style="display:none;">
		<option v-for="item in items" :value="item">{{ item }}</option>
	</select>
	<div>
		<span class="neoSelectBoxLabel">{{ label }}</span>
	</div>
	<div>
		<ul class="vidhiSelectBoxMenu">
  			<li v-on:click="showDropMenu" class="vidhiSelectBoxMenuItem">{{ theSelectedValue }}
  			<div class="neoSelectDropMenuContainer">
    			<ul>
					<neo-select-box-item v-on:itemHasClicked="updateValue" v-for="item in items" :the-item="item" :selected-value="theSelectedValue">{{ item }}</neo-select-box-item>
    			</ul>
    		</div>
  			</li>
		</ul>
	</div>
	<div v-if="hasError"><span style="padding-left:0px; font-style:italic; color:tomato;">{{ dataError }}</span></div>
	</div>
	</div>
	`,
	data(){
		return {
			calSelected : this.selected
		}
	},
	computed:{
		hasError:function(){
			if (this.dataError != "") {
				return true;
			}
			else{
				return false;
			}
		},
		hasIcon:function(){
			if (this.iconName == "" || this.iconName == null) {
				return false;
			}
			else
			{
				return true;
			}
		},
		theSelectedValue:function(){
			return this.calSelected;
		}
	},
	methods:{
		updateValue:function(value){
			$("#"+this.name).val(value);
			this.calSelected = value;
			this.$emit('change',value);
		},
		showDropMenu:function(){
			if ( $(".neoSelectDropMenuContainer").is(":visible") ){
						$(".neoSelectDropMenuContainer").velocity(
							{
    							scale: 0,
    						},
    						{    	
    							display:"none",						
    							duration:500
    						}
    					);
					}
					else{
						$(".neoSelectDropMenuContainer").velocity(
							{
    							scale: [1,0]
							},
							{			
								display:"block",					
								duration:500
							}
						);
					}
		}
	},
	mounted(){
		if (this.calSelected == '' || this.calSelected == null) {
			this.calSelected = " -- Select -- ";
			$("#"+this.name).val(null);
		}
		else{
			$("#"+this.name).val(this.selected);
		}
	}
});
Vue.component("neoSelectBoxItem",{
	props:['theItem','selectedValue'],
	template:`
	<div>
		<li :class="ifSelected" v-on:click="itemClicked">{{ theItem }}</li>
	</div>
	`,
	computed:{
		ifSelected:function(){
			if (this.theItem == this.selectedValue) {
				return "SelectedItem";
			}
			else{
				return "";
			}
		}
	},
	methods:{
		itemClicked:function(){
			this.$emit("itemHasClicked",this.theItem);
		}
	}
});
