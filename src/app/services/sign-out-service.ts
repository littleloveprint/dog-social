import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./BaseService";
import {Status} from "../classes/status";

@Injectable()
export class SignOutService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private signOutUrl = "api/sign-out/";

	getSignOut() : Observable<Status> {
		return(this.http.get(this.signOutUrl)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}
}