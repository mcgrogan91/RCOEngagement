import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';

import 'rxjs/Rx';

import { AppComponent }  from './app.component';
import { HeaderComponent }  from './components/header/header.component';
import { SearchComponent } from './components/search/search.component';
import { FooterComponent } from './components/footer/footer.component';
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
    routing
  ],
  declarations: [
    AppComponent,
    HeaderComponent,
    SearchComponent,
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
