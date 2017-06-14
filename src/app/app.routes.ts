import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {SignUpComponent} from "./components/sign-up.component";
import {SignInComponent} from "./components/sign-in.component";
import {NavbarComponent} from "./components/navbar.component";
import {FooterComponent} from "./components/footer.component";
import {ProfileComponent} from "./components/profile.component";
import {PostService} from "./services/post.service";
import {ParkComponent} from "./components/park.component";
import {ParksComponent} from "./components/parks.component";
import {ImageComponent} from "./components/image.component";
import {FileSelectDirective} from "ng2-file-upload";
import {DogComponent} from "./components/dog.component";

export const allAppComponents = [
	DogComponent,
	FooterComponent,
	HomeComponent,
	ImageComponent,
	NavbarComponent,
	SignInComponent,
	SignUpComponent,
	ProfileComponent,
	ParkComponent,
	ParksComponent,
	FileSelectDirective
];

export const routes: Routes = [
	{path: "park", component: ParkComponent},
	{path: "welcome/:id", component: ProfileComponent},
	{path: "parks", component: ParksComponent},
	{path: "dog", component: DogComponent},
	{path: "image", component: ImageComponent},
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [PostService];

export const routing = RouterModule.forRoot(routes);