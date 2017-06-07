import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";
import {Dog} from "../classes/dog";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class DogService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	//define api endpoint
	private dogUrl ="api/dog/";

	// call to the dog api and edit the dog in question
	editDog(dogId: number) : Observable<Status> {
		return(this.http.put(this.dogUrl + dog.dogId, dog))
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError);

	}
	//call to dog api and create dog in question
	createDog(dog : Dog) : Observable<Status> {
		return(this.http.post(this.dogUrl, dog))
			.map(BaseService.handleError);
	}

	//call to the dog api and get a dog by it's ID
	getDog(dogId : number) : Observable<Dog> {
		return(this.http.get(this.dogUrl + dogId))
			.map(BaseService.extractData)
			.catch(BaseService.handleError);
	}

	//call to the api and get a dog by profileId
	getDogByProfileId(dogProfileId : number) : Observable>Dog[]> {
		return(this.http.get(this.dogUrl + dogProfileId))
		.map(BaseService.extractData)
		.catch(BaseService.handleError);
}

// call to dog api and get dogs by dog breed
getDogByBreed(dogBreed : string) : Observable<Dog[]> {
		return(this.http.get(this.dogUrl + dogBreed))
			.map(BaseService.extractData)
	.catch(BaseService.handleError);
}


