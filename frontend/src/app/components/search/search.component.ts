import { Component, Input} from '@angular/core';
import { Router } from '@angular/router';
import { ConnectorService } from '../../services/connector.service';

@Component({
  selector: 'search',
  templateUrl: './search.html',
  styleUrls: ['./search.scss']

})

export class SearchComponent  {

  @Input() address: string;

  constructor(public connectorService:ConnectorService, public router:Router) {}

  searchForRCO() {
    this.router.navigate(["/search"], {queryParams: {q: this.address}});
  }
}
