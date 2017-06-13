import {Router} from "@angular/router";
import{Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import {Observable} from "rxjs/Observable"
import {Status} from "../classes/status";
import {CheckIn} from "../classes/checkin";
import {CheckInService} from "../services/checkIn.service";
declare var $: any;
@Component ({
	templateUrl: "./template/checkIn.php",
	selector: "checkIn"
})
export class CheckInComponent implements OnInit{
	@ViewChild("checkInForm") checkInForm: any;
	checkIn: CheckIn = new CheckIn(null, null, null, "", "",);
	status: Status = null;

	constructor(private checkInService: CheckInService, private router: Router) {
	}

	isCheckedIn = false;

	ngOnInit (): void {
	}

	createCheckIn(): void {
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