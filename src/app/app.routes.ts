import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home.component";
import {SignUpComponent} from "./components/sign-up.component";
import {SignInComponent} from "./components/sign-in.component";


export const allAppComponents = [HomeComponent, SignUpComponent, SignInComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);