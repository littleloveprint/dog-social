import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {CheckInService} from "./services/checkIn.service";
import {DogService} from "./services/dog.service";
import {FavoriteService} from "./services/favorite.service";
import {FriendService} from "./services/friend.service";
import {ImageService} from "./services/image.service";
import {ParkService} from "./services/park.service";
import {ProfileService} from "./services/profile.service";
import {SignInService} from "./services/sign-in.service";
import {SignUpService} from "./services/sign-up.service";
import {SignOutService} from "./services/sign-out.service";

// ANGULAR FOR GOOGLE MAPS
import {CommonModule} from "@angular/common";
import {AgmCoreModule} from "@agm/core";

const moduleDeclarations = [AppComponent];

const apiKey = "AIzaSyBLthzUq1SMAb5GKh6x60l2Oe3ltFyfHRs";

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing, AgmCoreModule.forRoot(apiKey)],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, SignInService, SignOutService, SignUpService, ProfileService, ParkService, ImageService, FriendService, FavoriteService, DogService, CheckInService]
})
export class AppModule {}