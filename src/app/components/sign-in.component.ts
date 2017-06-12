//this is the modal that pops up when "sign-in" is clicked

import{Component, ViewChild, EventEmitter, Output} from "@angular/core";

import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable"
import {Status} from "../classes/status";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";
declare var $: any;
@Component({
	templateUrl: "./template/sign-in.php",
	selector: "sign-in"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm : any;

	signin: SignIn = new SignIn("", "");
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router){}
	isSignedIn = false;

	ngOnChanges (): void{
		this.isSignedIn = this.signInService.isSignedIn;
	}

	signIn() : void {
		this.signInService.postSignIn(this.signin)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.router.navigate(["welcome/id"]);
					location.reload(true);
					this.signInForm.reset();
					setTimeout(function(){$("#signin-modal").modal('hide');},1000);
				}
			});
	}
}