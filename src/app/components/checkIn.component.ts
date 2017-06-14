import {Router} from "@angular/router";
import{Component, ViewChild, OnInit, EventEmitter, Output} from "@angular/core";
import{NgForm} from "@angular/forms";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {CheckIn} from "../classes/checkin";
import {CheckInService} from "../services/checkIn.service";
import {DogService} from "../services/dog.service";
declare var $: any;
@Component ({
	templateUrl: "./template/checkIn.php",
	selector: "checkInForm"
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


}