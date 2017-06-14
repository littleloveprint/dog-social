import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";

@Component({
	templateUrl: "./template/parks.php",
	styles: [`agm-map{
		height: 300px;
	}`]
})

export class ParksComponent {
	lat: number = 35.0853;
	lng: number = 106.6056;
}