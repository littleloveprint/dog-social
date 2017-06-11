import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {SignUpComponent} from "./components/sign-up.component";
import {SignInComponent} from "./components/sign-in.component";
import {NavbarComponent} from "./components/navbar.component";
import {FooterComponent} from "./components/footer.component";
import {PostService} from "./services/post.service";

export const allAppComponents = [HomeComponent, SignUpComponent, SignInComponent, NavbarComponent, FooterComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [PostService];

export const routing = RouterModule.forRoot(routes);