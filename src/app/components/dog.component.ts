import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {DogService} from "../services/dog.service"
import {Status} from "../classes/status";
import {Dog} from "../classes/dog";
import "rxjs/add/operator/switchMap";
import {Observable} from "rxjs";
import {create} from "domain";

@Component({
	templateUrl: "./template/dog.php",
	selector: "create-dog"
})

export class DogComponent implements OnInit{
	status: Status = null;
	dog: Dog = new Dog(null, null, null, null, null, null, null);
	dogs: Dog[] = [];
	constructor(private dogService :DogService, private route :ActivatedRoute){
	}
	ngOnInit(): void {
		this.getCurrentDogs();
	}
	getCurrentDogs(): void{
		this.dogService.getAllDogs()
			.subscribe(dogs => this.dogs = dogs);
	}
	createDog(): void{
		this.dogService.createDog(this.dog)
			.subscribe(status => this.status = status);
	}

	ngOnChanges (): void{
		location.reload(true);
	}

}