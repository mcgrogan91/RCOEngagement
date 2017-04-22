import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ConnectorService } from '../../services/connector.service';

@Component({
  selector: 'detailContent',
  templateUrl: './detailContent.html',
  styleUrls: ['./detailContent.scss']

})

export class DetailContentComponent  {

  id: number;
  rco: object;
  private sub: any;
  loading: boolean;

  constructor(private connector:ConnectorService, private route: ActivatedRoute){
    this.loading = true;
  }

  ngOnInit() {
    this.sub = this.route.params.subscribe(params => {
      this.id = +params["id"];
      this.loading = true;
      this.connector.getRCO(this.id)
        .subscribe(rco => {
          this.rco = rco;
          this.loading = false;
        });
    });
  }


}
