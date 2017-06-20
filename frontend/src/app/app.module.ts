import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { Angulartics2Module, Angulartics2GoogleAnalytics } from 'angulartics2';

import 'rxjs/Rx';

import { AppComponent }  from './app.component';
import { HeaderComponent }  from './components/header/header.component';
import { SearchComponent } from './components/search/search.component';
import { FooterComponent } from './components/footer/footer.component';
import { HomeComponent } from './components/home/home.component';
import { FaqContentComponent } from './components/faq/faq.component';
import { AboutContentComponent } from './components/about/about.component';
import { MapComponent } from './components/map/map.component';
import { ResultsContentComponent } from './components/results/results.component';
import { DetailContentComponent } from './components/detail/detail.component';


import { HomePage} from './pages/home';
import { FaqPage } from './pages/faq';
import { AboutPage } from './pages/about';
import { MapPage } from './pages/map';
import { DetailPage } from './pages/detail';
import { UpdatePage } from './pages/update';
import { ResultsPage } from './pages/results';

import { routing } from './app.routing';


@NgModule({
  imports:      [
    BrowserModule,
    FormsModule,
    HttpModule,
    routing,
    Angulartics2Module.forRoot([Angulartics2GoogleAnalytics])
  ],
  declarations: [
    AppComponent,
    HeaderComponent,
    SearchComponent,
    HomeComponent,
    AboutContentComponent,
    ResultsContentComponent,
    FooterComponent,
    FaqContentComponent,
    DetailContentComponent,
    MapComponent,
    HomePage,
    FaqPage,
    AboutPage,
    MapPage,
    DetailPage,
    UpdatePage,
    ResultsPage
  ],
  bootstrap:    [ AppComponent ],
})

export class AppModule { }
