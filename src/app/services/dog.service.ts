import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Dog} from "../classes/dog";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class DogService extends BaseService {

	constructor(protected http: Http) {
		super(http);
	}

	//define api endpoint
	private dogUrl = "api/dog/";

	//call to dog api and create dog in question
	createDog(dog : Dog) : Observable<Status> {
		return (this.http.post(this.dogUrl, dog)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	//call to dog api and edit dog in question
	editDog(dog : Dog) : Observable<Status> {
		return (this.http.put(this.dogUrl, dog)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

		//call to the dog api and get a dog by it's ID
	getDog(dogId : number) : Observable <Dog> {
		return(this.http.get(this.dogUrl + dogId)
			.map(this.extractData)
			.catch(this.handleError));
	}

		//call to the api and get a dog by profileId
	getDogByProfileId(dogProfileId : number) :Observable <Dog[]> {
			return(this.http.get(this.dogUrl + dogProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

// call to dog api and get dogs by dog breed
		getDogByBreed(dogBreed : string) : Observable < Dog[] > {
			return(this.http.get(this.dogUrl + dogBreed)
			.map(this.extractData)
			.catch(this.handleError));
	}
	ngOnInit(): void {
		this.getAllDogs();

	}

	getAllDogs() : Observable <Dog[] > {
		return(this.http.get(this.dogUrl)
			.map(this.extractData)
			.catch(this.handleError));

	}


}
