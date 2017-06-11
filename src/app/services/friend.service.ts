import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Friend} from "../classes/friend";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class FriendService extends BaseService {

	constructor(protected http:Http ) {
		super(http);
	}

	// Define the API endpoint.
	private friendUrl = "/api/friend/";

	// Call to the friend API, and delete the friend in question.
	deleteFriend(friend :Friend) : Observable<Status> {
		return(this.http.put(this.friendUrl + friend.friendFirstProfileId +friend.friendSecondProfileId, friend)
			.map(this.extractData)
			.catch(this.handleError));
	}

	// Call the friend API, and create a new friend.
	createFriend(friend : Friend) : Observable<Status> {
		return(this.http.post(this.friendUrl, friend)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	// Grabs a specific friend based on its composite key.
	getFriendByCompositeKey(friendFirstProfileId : number, friendSecondProfileId : number) : Observable <Friend> {
		return(this.http.get(this.friendUrl + friendFirstProfileId + friendSecondProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getFriendByFriendFirstProfileId (friendFirstProfileId : number ) : Observable <Friend[]> {
		return(this.http.get(this.friendUrl + friendFirstProfileId)
			.map(this.extractData)
			.catch(this.handleError));
	}

}