import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';


import { AppComponent }  from './app.component';
import { HeaderComponent }  from './components/header.component';
import { SearchComponent } from './components/search.component';
import { FooterComponent } from './components/footer.component';
import { FaqContentComponent } from './components/faq.component';
import { AboutContentComponent } from './components/about.component';
import { MapComponent } from './components/map.component';


import { HomePage} from './pages/home';
import { FaqPage } from './pages/faq';
import { AboutPage } from './pages/about';
import { DetailPage } from './pages/detail';
import { UpdatePage } from './pages/update';
import { routing } from './app.routing';


@NgModule({
  imports:      [ BrowserModule, HttpModule, routing ],
  declarations: [ AppComponent, HeaderComponent, SearchComponent, AboutContentComponent, FooterComponent, FaqContentComponent, MapComponent,
  				  HomePage, FaqPage, AboutPage, DetailPage,
  				  UpdatePage
  				],
  bootstrap:    [ AppComponent ]
})
export class AppModule { }
