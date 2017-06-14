import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";

@Component({
	templateUrl: "./template/park.php",
	styles: [`agm-map{
		height: 300px;
		width: 400px;
	}`]
})

export class ParkComponent {
	lat: number = 35.0853;
	lng: number = -106.6056;
}