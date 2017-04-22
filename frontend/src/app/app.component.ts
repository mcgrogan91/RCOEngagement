import { Component } from '@angular/core';
import { ConnectorService } from './services/connector.service';

@Component({
  selector: 'my-app',
  template: `
    <router-outlet></router-outlet>
    `,
  providers: [ConnectorService]
})
export class AppComponent  {}
