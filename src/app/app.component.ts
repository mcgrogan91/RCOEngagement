import { Component } from '@angular/core';

@Component({
  selector: 'my-app',
  template: `
  	<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  	<a class="navbar-brand" href="#">ROC Engagement</a>
	  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Home</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		    </ul>
	  	</div>
	</nav>`,

})
export class AppComponent  { name = 'Angular'; }
