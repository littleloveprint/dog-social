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

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [appRoutingProviders, SignInService, SignOutService, SignUpService, ProfileService, ParkService, ImageService, FriendService, FavoriteService, DogService, CheckInService]
})
export class AppModule {}