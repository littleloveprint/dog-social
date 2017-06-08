import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";

@Injectable()
export class ImageService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}
	private imageUrl = "api/image/";

	createImage(image: Image): Observable<Status> {
		return (this.http.post(this.imageUrl, image)
		.map(BaseService.extractData)
		.catch(BaseService.handleError));
	}
}