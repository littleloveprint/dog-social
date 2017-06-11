import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";
import {CheckIn} from "../classes/checkin";

@Injectable ()
export class CheckInService extends BaseService {
	constructor(protected http:Http){
		super(http);
	}
	//define the API endpoint
	private checkInUrl ="api/CheckIn/";
	//call to the CheckIn API and create the CheckIn in question
	createCheckIn(checkIn: CheckIn) : Observable<Status> {
		return(this.http.post(this.checkInUrl, CheckIn)
			.map(this.extractMessage)
			.catch(this.handleError));
	}
	//call to the CheckIn API and get a CheckIn object based on its Id
	getCheckInByCheckInId(checkInId : number) : Observable<CheckIn> {
		return(this.http.get(this.checkInUrl + checkInId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	//call to the CheckIn API and get an array of CheckIns based off the CheckIn Dog Ids
	getCheckInByCheckInDogId(checkInDogId : number) : Observable<CheckIn[]> {
		return(this.http.get(this.checkInUrl + checkInDogId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getCheckInByCheckInParkId(checkInParkId : number) : Observable<CheckIn[]> {
		return(this.http.get(this.checkInUrl + checkInParkId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getCheckInByCheckInDateTime(sunriseCheckInDateTime : Date ,sunsetCheckOutDateTime : Date) : Observable<CheckIn[]> {
		return(this.http.get(this.checkInUrl + sunriseCheckInDateTime ,sunsetCheckOutDateTime)
			.map(this.extractData)
			.catch(this.handleError))	;
}
}