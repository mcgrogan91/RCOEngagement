"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require("@angular/core");
var map_service_1 = require("../../shared/map.service");
var mapbox_gl_1 = require("mapbox-gl");
var MapComponent = (function () {
    function MapComponent(mapService) {
        this.mapService = mapService;
    }
    MapComponent.prototype.ngOnInit = function () {
        var map = new mapbox_gl_1.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v9',
            center: [-75.118, 40.002],
            zoom: 10
        });
        this.mapService.map = map;
        // map.on('load', () => {
        // // Add the data to your map as a layer
        //   map.addLayer({
        //     id: 'rco-data',
        //     type: 'fill',
        //     // Add a GeoJSON source containing place coordinates and information.
        //     source: {
        //       type: 'vector',
        //       // I uploaded the geojson data to mapbox and it created a vector file located here
        //       url: 'mapbox://billmoriarty.cj19vraqq08ft2qqsjfq3lgwk-5l6gv'
        //     },
        //     // this is the name of the file on mapbox
        //     'source-layer': 'RCO_-_Zoning_RCO_2',
        //     // this is that nice blue color for the map
        //     'paint': {
        //       // "fill-color": 'hsla(215, 87%, 55%, 0.13)'
        //       'fill-color': 'hsla(6,22%,52%, 0.13)'
        //     }
        //   });
        // });
        // When a click event occurs on a feature in the states layer, open a popup at the
        // location of the click, with description HTML from its properties.
        // I should make the names of the RCO's link to the RCO
        // map.on('click', 'locations', function (e) {
        //
        //   var popup = new mapboxgl.Popup();
        //   var string_for_popup;
        //
        //   //this first check for No RCO's doesn't work yet
        //   if(e.features.length < 1){
        //     string_for_popup = "No RCO's serve this neighborhood. Maybe you should start one!";
        //     }
        //   // if there is 1 RCO for the area clicked
        //   else if(e.features.length == 1){
        //     string_for_popup = "The " +e.features.length+ " RCO that serves this neighborhood is:<br><br>";
        //     }
        //   // if there is more than 1 RCO for the area clicked
        //   else if(e.features.length > 1){
        //     string_for_popup = "The " +e.features.length+ " RCO's that serve this neighborhood are:<br><br>";
        //     }
        //
        //   // loop thru and concatenate each RCO in this territory together in a variable for a Popup
        //   for(let i=0; i<e.features.length; i++){
        //
        //     // use this to display the RCO's preferred contact information
        //     var rcoContactTemp;
        //
        //     // check with preferred method of contact the RCO specified and use that for their displayed contact
        //     if(e.features[i].properties.PREFFERED_CONTACT_METHOD === "Email"){
        //         rcoContactTemp = e.features[i].properties.PRIMARY_EMAIL;
        //         }
        //     else if (e.features[i].properties.PREFFERED_CONTACT_METHOD === "Mail"){
        //         rcoContactTemp = e.features[i].properties.PRIMARY_ADDRESS;
        //     }
        //     else if (e.features[i].properties.PREFFERED_CONTACT_METHOD === "Phone"){
        //         rcoContactTemp = e.features[i].properties.PRIMARY_PHONE;
        //     }
        //
        //       popup.setLngLat(e.lngLat)
        //       string_for_popup = string_for_popup.concat(e.features[i].properties.ORGANIZATION_NAME + "<br>" + rcoContactTemp + "<br><br>");
        //
        //     }//end for
        //
        //     // when the for loop is done, display the popup
        //     popup.setHTML(string_for_popup);
        //     popup.addTo(map);
        // });
    };
    return MapComponent;
}());
MapComponent = __decorate([
    core_1.Component({
        selector: 'web-map',
        templateUrl: './map.html',
        styleUrls: ['./map.css'],
        providers: [map_service_1.MapService]
    }),
    __metadata("design:paramtypes", [map_service_1.MapService])
], MapComponent);
exports.MapComponent = MapComponent;
//# sourceMappingURL=map.component.js.map