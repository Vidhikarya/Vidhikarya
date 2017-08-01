Vue.component('caseCardForLawyer',{
	template:`
<div class="card" style="width:300px; border:0px; float:left; margin-right:10px; margin-bottom:10px;">
  <header class="card-header" style="padding:0;">
    <p class="card-header-title">
      <i class="fa fa-tags" aria-hidden="true" style="padding-right:5px;"></i>
      Component
    </p>
    <a class="card-header-icon">
      <span class="icon">
        <i class="fa fa-angle-down"></i>
      </span>
    </a>
  </header>
  <div class="card-content">
    <div class="content">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec iaculis mauris.
      <a>@bulmaio</a>. <a>#css</a> <a>#responsive</a>
      <br>
      <small>11:09 PM - 1 Jan 2016</small>
    </div>
  </div>
  <footer class="card-footer caseCardForLawyer-CardFooter">
    <a class="card-footer-item caseCardForLawyer-card-footer-item"><i class="fa fa-bars" aria-hidden="true" style="padding-right:10px;"></i>
Details</a>
    <a class="card-footer-item caseCardForLawyer-card-footer-item"><i class="fa fa-paper-plane" aria-hidden="true" style="padding-right:10px;"></i>
Apply</a>
  </footer>
</div>
	`,
});