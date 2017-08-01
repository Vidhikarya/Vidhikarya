(function (global, factory) {
	if (typeof define === 'function' && define.amd) {
		define(['exports', 'module'], factory);
	} else if (typeof exports !== 'undefined' && typeof module !== 'undefined') {
		factory(exports, module);
	} else {
		var mod = {
			exports: {}
		};
		factory(mod.exports, mod);
		global.autosize = mod.exports;
	}
	})(this, function (exports, module) {
	'use strict';

	var map = typeof Map === "function" ? new Map() : (function () {
		var keys = [];
		var values = [];

		return {
			has: function has(key) {
				return keys.indexOf(key) > -1;
			},
			get: function get(key) {
				return values[keys.indexOf(key)];
			},
			set: function set(key, value) {
				if (keys.indexOf(key) === -1) {
					keys.push(key);
					values.push(value);
				}
			},
			'delete': function _delete(key) {
				var index = keys.indexOf(key);
				if (index > -1) {
					keys.splice(index, 1);
					values.splice(index, 1);
				}
			}
		};
	})();

	var createEvent = function createEvent(name) {
		return new Event(name, { bubbles: true });
	};
	try {
		new Event('test');
	} catch (e) {
		// IE does not support `new Event()`
		createEvent = function (name) {
			var evt = document.createEvent('Event');
			evt.initEvent(name, true, false);
			return evt;
		};
	}

	function assign(ta) {
		if (!ta || !ta.nodeName || ta.nodeName !== 'TEXTAREA' || map.has(ta)) return;

		var heightOffset = null;
		var clientWidth = ta.clientWidth;
		var cachedHeight = null;

		function init() {
			var style = window.getComputedStyle(ta, null);

			if (style.resize === 'vertical') {
				ta.style.resize = 'none';
			} else if (style.resize === 'both') {
				ta.style.resize = 'horizontal';
			}

			if (style.boxSizing === 'content-box') {
				heightOffset = -(parseFloat(style.paddingTop) + parseFloat(style.paddingBottom));
			} else {
				heightOffset = parseFloat(style.borderTopWidth) + parseFloat(style.borderBottomWidth);
			}
			// Fix when a textarea is not on document body and heightOffset is Not a Number
			if (isNaN(heightOffset)) {
				heightOffset = 0;
			}

			update();
		}

		function changeOverflow(value) {
			{
				// Chrome/Safari-specific fix:
				// When the textarea y-overflow is hidden, Chrome/Safari do not reflow the text to account for the space
				// made available by removing the scrollbar. The following forces the necessary text reflow.
				var width = ta.style.width;
				ta.style.width = '0px';
				// Force reflow:
				/* jshint ignore:start */
				ta.offsetWidth;
				/* jshint ignore:end */
				ta.style.width = width;
			}

			ta.style.overflowY = value;
		}

		function getParentOverflows(el) {
			var arr = [];

			while (el && el.parentNode && el.parentNode instanceof Element) {
				if (el.parentNode.scrollTop) {
					arr.push({
						node: el.parentNode,
						scrollTop: el.parentNode.scrollTop
					});
				}
				el = el.parentNode;
			}

			return arr;
		}

		function resize() {
			var originalHeight = ta.style.height;
			var overflows = getParentOverflows(ta);
			var docTop = document.documentElement && document.documentElement.scrollTop; // Needed for Mobile IE (ticket #240)

			ta.style.height = 'auto';

			var endHeight = ta.scrollHeight + heightOffset;

			if (ta.scrollHeight === 0) {
				// If the scrollHeight is 0, then the element probably has display:none or is detached from the DOM.
				ta.style.height = originalHeight;
				return;
			}

			ta.style.height = endHeight + 'px';

			// used to check if an update is actually necessary on window.resize
			clientWidth = ta.clientWidth;

			// prevents scroll-position jumping
			overflows.forEach(function (el) {
				el.node.scrollTop = el.scrollTop;
			});

			if (docTop) {
				document.documentElement.scrollTop = docTop;
			}
		}

		function update() {
			resize();

			var styleHeight = Math.round(parseFloat(ta.style.height));
			var computed = window.getComputedStyle(ta, null);
			var actualHeight = Math.round(parseFloat(computed.height));

			// The actual height not matching the style height (set via the resize method) indicates that
			// the max-height has been exceeded, in which case the overflow should be set to visible.
			if (actualHeight !== styleHeight) {
				if (computed.overflowY !== 'visible') {
					changeOverflow('visible');
					resize();
					actualHeight = Math.round(parseFloat(window.getComputedStyle(ta, null).height));
				}
			} else {
				// Normally keep overflow set to hidden, to avoid flash of scrollbar as the textarea expands.
				if (computed.overflowY !== 'hidden') {
					changeOverflow('hidden');
					resize();
					actualHeight = Math.round(parseFloat(window.getComputedStyle(ta, null).height));
				}
			}

			if (cachedHeight !== actualHeight) {
				cachedHeight = actualHeight;
				var evt = createEvent('autosize:resized');
				try {
					ta.dispatchEvent(evt);
				} catch (err) {
					// Firefox will throw an error on dispatchEvent for a detached element
					// https://bugzilla.mozilla.org/show_bug.cgi?id=889376
				}
			}
		}

		var pageResize = function pageResize() {
			if (ta.clientWidth !== clientWidth) {
				update();
			}
		};

		var destroy = (function (style) {
			window.removeEventListener('resize', pageResize, false);
			ta.removeEventListener('input', update, false);
			ta.removeEventListener('keyup', update, false);
			ta.removeEventListener('autosize:destroy', destroy, false);
			ta.removeEventListener('autosize:update', update, false);

			Object.keys(style).forEach(function (key) {
				ta.style[key] = style[key];
			});

			map['delete'](ta);
		}).bind(ta, {
			height: ta.style.height,
			resize: ta.style.resize,
			overflowY: ta.style.overflowY,
			overflowX: ta.style.overflowX,
			wordWrap: ta.style.wordWrap
		});

		ta.addEventListener('autosize:destroy', destroy, false);

		// IE9 does not fire onpropertychange or oninput for deletions,
		// so binding to onkeyup to catch most of those events.
		// There is no way that I know of to detect something like 'cut' in IE9.
		if ('onpropertychange' in ta && 'oninput' in ta) {
			ta.addEventListener('keyup', update, false);
		}

		window.addEventListener('resize', pageResize, false);
		ta.addEventListener('input', update, false);
		ta.addEventListener('autosize:update', update, false);
		ta.style.overflowX = 'hidden';
		ta.style.wordWrap = 'break-word';

		map.set(ta, {
			destroy: destroy,
			update: update
		});

		init();
	}

	function destroy(ta) {
		var methods = map.get(ta);
		if (methods) {
			methods.destroy();
		}
	}

	function update(ta) {
		var methods = map.get(ta);
		if (methods) {
			methods.update();
		}
	}

	var autosize = null;

	// Do nothing in Node.js environment and IE8 (or lower)
	if (typeof window === 'undefined' || typeof window.getComputedStyle !== 'function') {
		autosize = function (el) {
			return el;
		};
		autosize.destroy = function (el) {
			return el;
		};
		autosize.update = function (el) {
			return el;
		};
	} else {
		autosize = function (el, options) {
			if (el) {
				Array.prototype.forEach.call(el.length ? el : [el], function (x) {
					return assign(x, options);
				});
			}
			return el;
		};
		autosize.destroy = function (el) {
			if (el) {
				Array.prototype.forEach.call(el.length ? el : [el], destroy);
			}
			return el;
		};
		autosize.update = function (el) {
			if (el) {
				Array.prototype.forEach.call(el.length ? el : [el], update);
			}
			return el;
		};
	}

	module.exports = autosize;
});
$(document).click(function(event) { 
    if(!$(event.target).closest('.neoMultiSelectDropDown').length) {
        if($('#neoMultiSelectMenuArea').is(":visible")) {
            $("#neoMultiSelectMenuArea").velocity(
							{
    							scale: 0,
    						},
    						{    	
    							display:"none",						
    							duration:500
    						}
    					);
        }
    }
    if(!$(event.target).closest('.neoSelectBox').length) {
        if($('.neoSelectDropMenuContainer').is(":visible")) {
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
    }     
});
Vue.component('neoMultiSelectBox',{
	props: ['label','items','selected','dataError','name','iconName'],
	template:`
	<div class="neoMultiSelectDropDown row" style="width:100%; margin-bottom:25px;">
		<select :id="name" :name=" name + '[]'" multiple="multiple" style="display:none;">
			<option v-for="item in items" :value="item">{{ item }}</option>
		</select>
		<div class="col-md-1" v-if="hasIcon" style="padding-top:10px;">
			<i class="material-icons" style="font-size:35px;">{{ iconName }}</i>
		</div>
		<div class="col-md-9">
		<div>
	  	<span class="neoMultiSelectLabel">{{ label }}</span>
	  </div>	
	  <div style="position:relative;">
	  	<div class="neoMultiSelectBoxArea" v-on:click="showMenu">
	  		<ul class="neoMultiSelectTags">
	  			<show-selected v-for="sitem in selected" :selecteditem="sitem"  v-on:doDelete="deletethevalue"></show-selected>
	  		</ul>
	  	</div>
	  	<div id="neoMultiSelectMenuArea" class="neoMultiSelectDropDownContent" style="clear:both;">
	    	<ul class="neoMultiSelectMenu">
	    		<multi-select-list-item v-on:clicked="doWithTheValue" v-for="item in items" :item="item" :items="selected"></multi-select-list-item>
	    	</ul>
	  	</div>
	  </div>
	  <div v-if="hasError"><span style="padding-left:0px; font-style:italic; color:tomato;">{{ dataError }}</span></div>
		</div>
	</div>
	`,
	methods:{	
		showMenu:function(){
			if ( $("#neoMultiSelectMenuArea").is(":visible") ){
						$("#neoMultiSelectMenuArea").velocity(
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
						$("#neoMultiSelectMenuArea").velocity(
							{
    							scale: [1,0]
							},
							{			
								display:"block",					
								duration:500
							}
						);
					}
		},
		doWithTheValue:function(value){
			if ($.inArray(value, this.selected) != -1){
				//Item exists - Removing it
				this.selected.splice(this.selected.indexOf(value), 1);
				$("#"+this.name).val(this.selected);	
			}
			else{
				//Item not exists - adding it
				this.selected.push(value);
				$("#"+this.name).val(this.selected);	
			}
		},
		deletethevalue(value){
			this.selected.splice(this.selected.indexOf(value), 1);
			$("#"+this.name).val(this.selected);
		}
	},
	computed:{
		hasError:function(value){
			if (this.dataError == "")
			{
				return false;
			}
			else{
				return true;
			}
		},
		hasIcon:function(){
			if (this.iconName == "" || this.iconName == null) {
				return false;
			}	
			else{
				return true;
			}
		}
	},
	mounted(){
		$("#"+this.name).val(this.selected);
	}
});
Vue.component('showSelected', {
	props:['selecteditem'],
	template:`
  <li><span href="#" class="neoMultiSelectTag"><i class="material-icons neoMultiSelectdeleteIcon" v-on:click="deleteItem($event)">delete</i>{{ selecteditem }}</span></li>
	`,
	methods:{
		deleteItem:function(e){
			e.stopPropagation();
			this.$emit("doDelete",this.selecteditem);
		}
	}
});
Vue.component('multiSelectListItem',{
	props:['item','items'],
	template:`
	<li class="SelectMenuListStyle">
		<label class="neoMultiSelectCheckboxLabel">
			<input type="checkbox" :checked="ifExists" v-on:click="ItemClicked" class="neoMultiSelectCheckBox">{{ item }}
		</label>
	</li>
	`,
	methods:{
		ItemClicked:function(){
			this.$emit("clicked",this.item);
		}
	},
	computed:{
		ifExists:function(){
			//Checking If an item exists
			if ($.inArray(this.item, this.items) != -1)
			{
				return true;
			}
			else
			{
				//Item not exists - adding it
				return false;
			}
		}
	},
});
Vue.component('neoSelectBox',{
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
		<ul class="neoSelectBoxMenu">
  			<li v-on:click="showDropMenu" class="neoSelectBoxMenuItem">{{ theSelectedValue }}
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
Vue.component("neoTextBox",{
	props:['value','placeholder','iconName','label','dataError','name','dataCounter','dataOverflow'],
	template:`
	<div class="row" style="width:100%; margin:0; margin-bottom:25px;">
		<div class="col-sm-1" v-if="hasIcon" style="padding-top:5px; margin-right:10px;">
			<i class="material-icons" style="font-size:35px;">{{ iconName }}</i>
		</div>
		<div class="col-sm" style="position:relative;">
			<div class="neoFormLabel" :class="{ 'InvalidCounter-Label' : CounterInvalid }">
				<span> {{ label }} </span>
			</div>
			<div>
				<input :value="CurrentData" v-on:keyup="CountChar($event.target.value)" type="text" :name="name" :id="name" :placeholder="placeholder" class="neoFormInput" :class="{ 'InvalidCounter-Control' : CounterInvalid }">
			</div>
			<div class="neoTextBoxDataCounter" v-if="hasCounter">
				<span class="neoTextBoxDataCounterLabel" :class="{ 'InvalidCounter-CounterLabel' : CounterInvalid }">
					<span> {{ CounterCurrent }}</span> / <span>{{ CounterMax }}</span>
				</span>
			</div>
			<div v-if="hasError">
				<span style="padding-left:0px; font-style:italic; color:tomato;">{{ dataError }}</span>
			</div>
		</div>		
	</div>
	`,
	data(){
		return {
			PreviousData : '',
			CurrentData : '',
			CounterCurrent : 0
		};
	},
	methods:{
		CountChar:function(val){
			this.CounterCurrent = val.length;
			if (!this.Overflow) {
				if (this.CounterInvalid) {
					this.CurrentData = this.PreviousData;
					this.CounterCurrent = this.value.length;
				}
				else{
					this.PreviousData = val;
					this.CurrentData = val;
					this.$emit('input',val);
				}				
			}
			else{
				this.CurrentData = val;
				this.$emit('input',val);
			}
		}
	},
	computed:{
		hasIcon:function(){
			if (this.iconName == "" || this.iconName == null) {
				return false;
			}
			else{
				return true;
			}
		},
		hasError:function(){
			if (this.dataError == "" || this.dataError == null) {
				return false;
			}
			else{
				return true;
			}
		},
		Overflow:function(){
			if (this.dataOverflow == null) {
				return false;
			}
			else{
				return this.dataOverflow;
			}
		},
		hasCounter:function(){
			if (this.dataCounter == "" || this.dataCounter == null) {
				return false;
			}
			else {
				if (isNaN(this.dataCounter)) {
					return false;
				}else{
					return true;
				}
			}
		},
		CounterMax:function(){
			return parseInt(this.dataCounter);
		},
		CounterInvalid:function(){
			if (this.CounterCurrent > this.CounterMax ) {
				return true;
			}
			else{
				return false;
			}
		}
	}
});
Vue.component("neoTextArea",{
	props:['placeholder','iconName','label','dataError','name','dataCounter','dataOverflow'],
	template:`
	<div class="row" style="width:100%; margin-bottom:25px;">
		<div class="col-md-1" v-if="hasIcon" style="padding-top:20px;">
			<i class="material-icons" style="font-size:35px;">{{ iconName }}</i>
		</div>
		<div class="col-md-9">
			<div class="neoTextBoxLabel" :class="{ 'InvalidCounter-Label' : CounterInvalid }">
				<span> {{ label }} </span>
			</div>
			<div>
				<textarea v-model="CurrentData" v-on:keyup="CountChar" :name="name" :id="name" :placeholder="placeholder" class="neoTextAreaStyle" :class="{ 'InvalidCounter-Control' : CounterInvalid }"></textarea>
			</div>
			<div class="neoTextAreaDataCounter" v-if="hasCounter">
				<span class="neoTextAreaDataCounterLabel" :class="{ 'InvalidCounter-CounterLabel' : CounterInvalid }">
					<span> {{ CounterCurrent }}</span> / <span>{{ CounterMax }}</span>
				</span>
			</div>
			<div v-if="hasError">
				<span style="padding-left:0px; font-style:italic; color:tomato;">{{ dataError }}</span>
			</div>
		</div>		
	</div>
	`,
	data(){
		return {
			PreviousData : '',
			CurrentData : '',
			CounterCurrent : 0,
		};
	},
	methods:{
		CountChar:function(){
			var val = $("#"+this.name).val();
			this.CounterCurrent = val.length;
			if (!this.Overflow) {
				if (this.CounterInvalid) {
					this.CurrentData = this.PreviousData;
					var val = $("#"+this.name).val();
					this.CounterCurrent = this.CurrentData.length;
				}
				else{
					this.PreviousData = this.CurrentData;
				}				
			}
			else{
			}
		}
	},
	computed:{
		Overflow:function(){
			if (this.dataOverflow == null) {
				return false;
			}
			else{
				return this.dataOverflow;
			}
		},
		hasIcon:function(){
			if (this.iconName == "" || this.iconName == null) {
				return false;
			}
			else{
				return true;
			}
		},
		hasError:function(){
			if (this.dataError == "" || this.dataError == null) {
				return false;
			}
			else{
				return true;
			}
		},
		hasCounter:function(){
			if (this.dataCounter == "" || this.dataCounter == null) {
				return false;
			}
			else {
				if (isNaN(this.dataCounter)) {
					return false;
				}else{
					return true;
				}
			}
		},
		CounterMax:function(){
			return parseInt(this.dataCounter);
		},
		CounterInvalid:function(){
			if (parseInt(this.CounterCurrent) > parseInt(this.CounterMax) ) {
				return true;
			}
			else{
				return false;
			}
		}
	},
	mounted(){
		$("#"+this.name).css('overflow','hidden');
		autosize(document.querySelectorAll('textarea'));
	}
});
Vue.component("neoCheckBox",{
	props:['data','name','iconName'],
	template:`
	  <div style="width:100%; margin-bottom:25px;">
			<select :name="name+'[]'" :id="name" style="display:none;" multiple="multiple">
	  			<option v-for="item in data">{{ item.Title }}</option>
	  		</select>
	    	<check-box-item v-on:RemoveItem="RemovingItem" v-on:AddItem="AddingItem" v-for="item in data" :item="item"></check-box-item>
	  </div>
	`,
	data(){
		return{
			selected : [],
		};
	},
	methods:{
		RemovingItem:function(value){
			this.selected.splice(this.selected.indexOf(value), 1);
			$("#"+this.name).val(this.selected);
		},
		AddingItem:function(value){
			this.selected.push(value);
			$("#"+this.name).val(this.selected);
		}
	}
});
Vue.component("checkBoxItem",{
	props:['item'],
	template:`
	<div class="check-awesome">
		<input type="checkbox" :id="TheID" :value="TheValue">
	    <label :for="TheID" v-on:click="ItemClicked" :id="LabelID">
	      <span :id="TheID+'Circle'" class="circle"></span>
	      <span class="check"></span>
	      <span class="box"></span>
	      <i class="neoCheckBoxTitle">{{ Title }}</i>
	    </label>
	    <p v-if="hasDescription" class="neoCheckBoxDescription" v-html="Description"></p>
	</div>
	`,
	data(){
		return{
			Title : '',
			Description : '',
			TheValue : '',
			TheID : '',
			Selected : false,
			LabelID : '',
		};
	},
	computed:{
		hasDescription:function(){
			if (this.item.Desc == "" || this.item.Desc == null) {
				return false;
			}
			else{
				return true;
			}
		}
	},
	mounted(){
		this.Title = this.item.Title;
		if (! ("Value" in this.item)) {
			this.TheValue = this.item.Title;
		}
		else{
			this.TheValue = this.item.Value;
		}
		if (!("Desc" in this.item)) {
			this.Description = "";
		}
		else{
			this.Description = this.item.Desc;
		}
		this.TheID = 'neoCheck' + this.TheValue;
		this.LabelID = this.TheID+'Label';
	},
	updated(){
		if ("Selected" in this.item) {
			if (this.item.Selected) {
				// this.Selected = true;
				// this.selected.push(value);
				// $("#"+this.name).val(this.selected);
				$("#"+this.LabelID).trigger('click');
			}
		}
	},
	methods:{
		ItemClicked:function(){
			this.showAnimation();
			if (this.Selected) {
				this.$emit("RemoveItem",this.TheValue);
				this.Selected = false;
			}
			else{
				this.$emit("AddItem",this.TheValue);
				this.Selected = true;
			}
		},
		showAnimation:function(){
			$("#"+this.TheID+'Circle').velocity(
					{
						scale : [2.5,1]
					},
					{ 
						duration : 200 
					}
				).velocity(
					{  
						scale : 0 
					},
					{
						duration : 200 
					}
				);
		}
	}
});
Vue.component('neoImageHoney',{
	props:['location','heading','description','effect','alt'],
	template:`
<div>
	<figure :class="effect">
		<img :src="location" :alt="alt"/>
		<figcaption>
			<div>
				<h2><span style="color:#fff;">{{ heading }}</span></h2>
				<p style="padding:5px; padding-bottom:15px;">{{description}}</p>
			</div>
		</figcaption>		
	</figure>
</div>
	`,
});
Vue.component("neoPasswordBox",{
	props:['value','placeholder','iconName','label','dataError','name'],
	template:`
	<div class="row" style="width:100%; margin:0; margin-bottom:25px;">
		<div class="col-sm-1" v-if="hasIcon" style="padding-top:5px; margin-right:10px;">
			<i class="material-icons" style="font-size:35px;">{{ iconName }}</i>
		</div>
		<div class="col-sm">
			<div class="neoFormLabel">
				<span> {{ label }} </span>
			</div>
			<div class="has-icons-right control">
				<input :value="value" v-on:input="$emit('input',$event.target.value)" type="password" :name="name" :id="name" :placeholder="placeholder" class="neoFormInput">
				<span class="icon is-small is-right" v-on:mouseup="hidePassword" v-on:mousedown="showPassword" style="pointer-events:painted; cursor:pointer; padding-bottom:15px;">
      				<i class="material-icons" style="color:#3273dc;">remove_red_eye</i>
    			</span>
			</div>
			<div v-if="hasError">
				<span style="padding-left:0px; font-style:italic; color:tomato;">{{ dataError }}</span>
			</div>
		</div>		
	</div>
	`,
	computed:{
		hasIcon:function(){
			if (this.iconName == "" || this.iconName == null) {
				return false;
			}
			else{
				return true;
			}
		},
		hasError:function(){
			if (this.dataError == "" || this.dataError == null) {
				return false;
			}
			else{
				return true;
			}
		}
	},
	methods:{
		showPassword:function(){
			$("#"+this.name).attr('type','text');	
		},
		hidePassword:function(){
			$("#"+this.name).attr('type','password');		
		}
	}
});