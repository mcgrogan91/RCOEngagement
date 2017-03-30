import { ModuleWithProviders } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { HomePage } from './pages/home';
import { FaqPage } from './pages/faq';
import { AboutPage } from './pages/about';
import { DetailPage } from './pages/detail';
import { UpdatePage } from './pages/update';

const appRoutes: Routes = [
	{
		path:'',
		component: HomePage
	},
	{
		path:'faq',
		component: FaqPage
	},
	{
		path:'about',
		component: AboutPage
	},
	{
		path:'detail',
		component: DetailPage
	},
	{
		path:'update',
		component: UpdatePage
	}
];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);

