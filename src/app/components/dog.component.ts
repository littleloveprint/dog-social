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
	dog: Dog = new Dog(null, 1, null, null, null, null, null);
	constructor(private dogService :DogService, private route :ActivatedRoute){
	}
	ngOnInit(): void {
	//	this.getCurrentDog();
	}
	getCurrentDog(): void{
		this.route.params
			.switchMap((params: Params) => this.dogService.getDog(+ params["id"]))
			.subscribe(reply => this.dog = reply);
	}
	createDog(): void{
		this.dogService.fuckDogs(this.dog)
			.subscribe(status => this.status = status);
	}
}