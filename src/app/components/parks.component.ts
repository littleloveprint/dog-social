import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {ParkService} from "../services/park.service";
import {Park} from "../classes/park";

@Component({
	templateUrl: "./template/parks.php",
	styles: [`agm-map{
		height: 300px;
		width: 400px;
	}`]
})

export class ParksComponent implements OnInit {
	lat: number = 35.0853;
	lng: number = -106.6056;
	park: Park = new Park(null, null, null, null);

	parks: Park[] = [];

	constructor (private parkService: ParkService, private route: ActivatedRoute) {}

	ngOnInit(): void {
		this.getAllParks();

	}

	getAllParks () : void {
		this.parkService.getAllParks()
			.subscribe(parks =>{ this.parks = parks });
	}
}