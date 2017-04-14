import { Injectable } from '@angular/core';
import * as mapboxgl from 'mapbox-gl';
import { Map } from 'mapbox-gl';

@Injectable()
export class MapService {
  map: Map;

  constructor() {
    (mapboxgl as any).accessToken = 'pk.eyJ1IjoiYmlsbG1vcmlhcnR5IiwiYSI6ImNqMTVvZGF5bjAxMDEzM21vZDJoMTEya2QifQ.ok-L_bNQuF8knLOevFLezw';
  }
}
