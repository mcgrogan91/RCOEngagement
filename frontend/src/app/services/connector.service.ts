import { NgModule, Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';
import { Observable } from 'rxjs/Observable';

@Injectable()
export class ConnectorService {

  public rcos: {};
  public list: {}[];
  public search: string;

  constructor(public http:Http) {
    this.rcos = {};
    this.list = [];
    this.search = "";
  }

  clearResults() {
    this.list = [];
    this.search = "";
  }

  extractData(res:Response) {
    let data = res.json() || [];

    this.rcos = {};
    this.list = [];

    data.forEach(rco => {
      this.rcos[rco.id] = rco;
      this.list.push(rco);

    });

    return this.rcos;
  }

  extractSingle(res:Response) {
    let data = res.json() || {};

    if (data.id) {
      this.rcos[data.id] = data;
    }

    return data;
  }

  handleError(error:any) {
    return Observable.throw(error.message);
  }

  fetchByAddress(address:string) {
    this.search = address;

    if (!this.search) {
      return Observable.throw("Nothing to search");
    }

    return this.http.get("http://api.myphilly.org/api/find?address="+address)
      .map(this.extractData.bind(this))
      .catch(this.handleError.bind(this));
  }

  fetchRCO(id:number) {
    return this.http.get("http://api.myphilly.org/api/get/"+id)
      .map(this.extractSingle.bind(this))
      .catch(this.handleError.bind(this));
  }

  getRCO(id:number) {
    if(this.rcos[id]) {
      console.log(this.rcos[id]);
      return Observable.fromPromise(Promise.resolve(this.rcos[id]));
    }

    return this.fetchRCO(id);
  }

}
