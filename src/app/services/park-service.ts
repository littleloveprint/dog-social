import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./BaseService";
import {Status} from "../classes/status";
import {Park} from "../classes/park";
import {Observable} from "rxjs/Observable";

@Injectable()
export class parkService extends BaseService {

	constructor(protected http: Http) {
		super(http);
	}

	// Define the API endpoint.
	private parkUrl = "/api/park/";

	getParkByParkId(parkId: number): Observable<Park[]> {
		return (this.http.get(this.parkUrl + park.parkId)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	getParkByParkName(parkName: string): Observable<Park[]> {
		return (this.http.get(this.parkUrl + park.parkName)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	getAllParks(): Observable<Park[]> {
		return (this.http.get(this.parkUrl)
			.map(BaseService.extractData)
			.catch(BaseService.extractData));
	}
}


