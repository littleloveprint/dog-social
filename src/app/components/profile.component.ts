import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../services/profile.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import "rxjs/add/operator/switchMap";
import {Observable} from "rxjs";

@Component({
	templateUrl: "./template/profile.php"
})

export class ProfileComponent implements OnInit{

	status: Status = null;
	profile: Profile = new Profile(null, null, null, null, null, null, null, null, null);

	constructor(private profileService :Profile, private route :ActivatedRoute) {
	}

	ngOnInit(): void {
		this.getCurrentProfile();
	}

	getCurrentProfile(): void {
		this.route.params
			.switchMap
	}
}