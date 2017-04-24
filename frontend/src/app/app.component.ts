import { Component } from '@angular/core';
import { ConnectorService } from './services/connector.service';

@Component({
  selector: 'my-app',
  template: `
    <header></header>
    <router-outlet></router-outlet>
    <footer></footer>
    `,
  providers: [ConnectorService],
  styleUrls: ['./app.component.scss']
})
export class AppComponent  {}
