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
Object.defineProperty(exports, "__esModule", { value: true });
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