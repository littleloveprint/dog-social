import {Component, OnInit, ViewChild} from "@angular/core";
import{NgForm} from "@angular/forms";
import {Status} from "../classes/status";
import {CheckIn} from "../classes/checkin";
import {CheckInService} from "../services/checkIn.service";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {Router} from "@angular/router";
declare var $: any;

@Component({
	templateUrl: "./template/park.php",
	styles: [`agm-map{
		height: 300px;
		width: 400px;
	}`]
})

export class ParkComponent {
	lat: number = 35.0853;
	lng: number = -106.6056;
	@ViewChild("checkInForm") checkInForm: any;
	checkIn: CheckIn = new CheckIn(null, null, null, "", "",);
	status: Status = null;

	constructor(private checkInService: CheckInService, private router: Router) {
	}

	createCheckIn(form: NgForm): void {
		console.log(form.value);
		this.checkInService.createCheckIn(this.checkIn)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					alert("Dog successfully checked in! Thanks!");
					this.checkInForm.reset();
					setTimeout(function() {$("#checkIn-modal").modal('hide');}, 1000);
					this.router.navigate([""]);
				}
			});
	}
}