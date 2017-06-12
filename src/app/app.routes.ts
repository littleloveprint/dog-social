import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {SignUpComponent} from "./components/sign-up.component";
import {SignInComponent} from "./components/sign-in.component";
import {NavbarComponent} from "./components/navbar.component";
import {FooterComponent} from "./components/footer.component";
import {ProfileComponent} from "./components/profile.component";
import {PostService} from "./services/post.service";
import {ParkComponent} from "./components/park.component";
import {ImageComponent} from "./components/image.component";
import {FileSelectDirective} from "ng2-file-upload";

export const allAppComponents = [HomeComponent, SignUpComponent, SignInComponent, NavbarComponent, FooterComponent, ProfileComponent, ParkComponent, ImageComponent, FileSelectDirective];

export const routes: Routes = [
	{path: "welcome/:id", component: ProfileComponent},
	{path: "image", component: ImageComponent},
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [PostService];

export const routing = RouterModule.forRoot(routes);