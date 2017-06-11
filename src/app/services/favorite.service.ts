import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Favorite} from "../classes/favorite";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class FavoriteService extends BaseService {

	constructor(protected http:Http ) {
		super(http);
	}

	//define the API endpoint
	private favoriteUrl = "/api/favorite/";

	//call to the favorite API and delete the favorite in question
	deleteFavorite(favorite :Favorite) : Observable<Status> {
		return(this.http.put(this.favoriteUrl + favorite.favoriteProfileId +favorite.favoriteParkId, favorite)
			.map(this.extractData)
			.catch(this.handleError));
	}

	//call the favorite API and create a new favorite
	createFavorite(favorite : Favorite) : Observable<Status> {
		return(this.http.post(this.favoriteUrl, favorite)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	//grabs a specific favorite based on its composite key
	getFavoriteByCompositeKey(favoriteProfileId : number, favoriteParkId : number) : Observable <Favorite> {
		return(this.http.get(this.favoriteUrl + favoriteProfileId + favoriteParkId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getFavoriteByProfileId (favoriteProfileId : number ) : Observable <Favorite[]> {
		return(this.http.get(this.favoriteUrl + favoriteProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getFavoriteByParkId (favoriteParkId : number ) : Observable <Favorite[]> {
		return(this.http.get(this.favoriteUrl + favoriteParkId)
			.map(this.extractData)
			.catch(this.handleError));
	}
}