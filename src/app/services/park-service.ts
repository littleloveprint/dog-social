import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./BaseService";
import {Status} from "../classes/status";
import {Park} from "../classes/park";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class parkService extends BaseService {

	constructor(protected http:Http ) {
		super(http);
	}

	// Define the API endpoint.
	private parkUrl = "/api/park/";

	// Call to the park API, and delete the park in question.
	deletePark(park :Park) : Observable<Status> {
		return(this.http.put(this.parkUrl +park.parkId +park.parkLocationX +park.parkLocationY +park.parkName)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// Call the friend API, and create a new park.
	createPark(park : Park) : Observable<Status> {
		return(this.http.post(this.parkUrl, park)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}

	// Grabs a specific park based on its composite key.
	getParkByCompositeKey(parkLocationX : decimal parkLocationY : decimal parkName : number) : Observable <Park> {
		return(this.http.get(this.parkUrl + parkLocationX + parkLocationY + parkName)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	getParkByParkId (parkId : number ) : Observable <Park[]> {
		return(this.http.get(this.parkUrl + park.parkId)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	getParkByParkLocation (parkLocationX : decimal : parkLocationY : decimal) : Observable <Park[]> {
		return(this.http.get(this.parkUrl + park.parkLocationX + park.parkLocationY)
			.map(BaseService.extraData)
			.catch(BaseService.handleError));
}

	getParkByParkName (parkName : string ) : Observable <Park[]> {
		return(this.http.get(this.parkUrl + park.parkName)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}
