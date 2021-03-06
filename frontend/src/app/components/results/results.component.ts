import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ConnectorService } from '../../services/connector.service';

@Component({
  selector: 'resultsContent',
  templateUrl: './resultsContent.html',
  styleUrls: ['./resultsContent.scss']
})

export class ResultsContentComponent {
  search: string;
  private sub: any;
  loading: boolean;
  noResults: boolean;

  constructor(public connector:ConnectorService, private route: ActivatedRoute) {
  }

  ngOnInit() {
    this.sub = this.route.queryParams.subscribe(params => {
      this.search = params.q;

      this.connector.clearResults();

      this.connector.fetchByAddress(this.search)
        .subscribe(data => {
      }, err => {
      });
    });
  }
}
