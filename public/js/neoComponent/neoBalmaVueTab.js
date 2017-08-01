Vue.component('neoTabs',{
  props : ['items'],
  template: `
<div>
  <div style="margin:0px;" class="row">
    <div class="TheTabs" style="padding-right:15px; padding-bottom:15px;">
        <div class="tabs is-toggle">
          <ul style="padding:0;">
            <li v-for="tab in tabs" :class="{ 'is-active' : tab.isActive }">
              <a v-on:click="selectTab(tab)">
                <span class="icon is-small"><i class="fa fa-image"></i></span>
                <span>{{ tab.name }}</span>
              </a>
            </li>
          </ul>
        </div>
    </div>
    <div class="field has-addons" id="dashboardSearchBox" style="padding-right:15px; padding-bottom:15px;">
        <p class="control has-icons-left" style="padding-left:0px;">
          <input class="input" type="text" placeholder="Find a repository">
          <span class="icon is-left is-small">
              <i class="fa fa-search"></i>
          </span>
        </p>
        <p class="control" style="padding-left:0px;">
          <a class="button" style="background-color:#00d1b2; border:0; color:#fff;">
            Search
          </a>
        </p>
    </div>

    <div class="field has-addons">
      <p class="control is-expanded" style="padding-left:0px;">
        <span class="select is-fullwidth">
          <select name="country">
            <option value="Argentina">Argentina</option>
            <option value="Bolivia">Bolivia</option>
            <option value="Brazil">Brazil</option>
            <option value="Chile">Chile</option>
            <option value="Colombia">Colombia</option>
            <option value="Ecuador">Ecuador</option>
            <option value="Guyana">Guyana</option>
            <option value="Paraguay">Paraguay</option>
            <option value="Peru">Peru</option>
            <option value="Suriname">Suriname</option>
            <option value="Uruguay">Uruguay</option>
            <option value="Venezuela">Venezuela</option>
          </select>
        </span>
      </p>
      <p class="control" style="padding-left:0px;">
        <button type="submit" class="button is-primary">Choose</button>
      </p>
    </div>

  </div>

  <div class="tabs-details">
    <slot></slot>
  </div>

</div>
  `,
  data(){
    return {
      tabs : [],
    }
  }, 
  created(){
    this.tabs = this.$children; 
  },
  methods:{
    selectTab:function(currentTab){
      this.tabs.forEach(tab => {
        tab.isActive = false;
        currentTab.isActive = true;
      });
    }
  }
});
Vue.component('tab',{
  props:{
    name : { required : true },
    selected : { default : false },
    icon : { default : 'none' }
  },
  template : `
<div>
  <slot v-if="isActive"></slot>
</div>
  `,
  data(){
    return {
      isActive : false
    };
  },
  mounted(){
    this.isActive = this.selected
  }
})