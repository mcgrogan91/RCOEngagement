"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var core_1 = require("@angular/core");
var platform_browser_1 = require("@angular/platform-browser");
var forms_1 = require("@angular/forms");
var http_1 = require("@angular/http");
var app_component_1 = require("./app.component");
var header_component_1 = require("./components/header/header.component");
var search_component_1 = require("./components/search/search.component");
var footer_component_1 = require("./components/footer/footer.component");
var faq_component_1 = require("./components/faq/faq.component");
var about_component_1 = require("./components/about/about.component");
var map_component_1 = require("./components/map/map.component");
var detail_component_1 = require("./components/detail/detail.component");
var home_1 = require("./pages/home");
var faq_1 = require("./pages/faq");
var about_1 = require("./pages/about");
var map_1 = require("./pages/map");
var detail_1 = require("./pages/detail");
var update_1 = require("./pages/update");
var app_routing_1 = require("./app.routing");
var AppModule = (function () {
    function AppModule() {
    }
    return AppModule;
}());
AppModule = __decorate([
    core_1.NgModule({
        imports: [
            platform_browser_1.BrowserModule,
            forms_1.FormsModule,
            http_1.HttpModule,
            app_routing_1.routing
        ],
        declarations: [
            app_component_1.AppComponent,
            header_component_1.HeaderComponent,
            search_component_1.SearchComponent,
            about_component_1.AboutContentComponent,
            footer_component_1.FooterComponent,
            faq_component_1.FaqContentComponent,
            detail_component_1.DetailContentComponent,
            map_component_1.MapComponent,
            home_1.HomePage,
            faq_1.FaqPage,
            about_1.AboutPage,
            map_1.MapPage,
            detail_1.DetailPage,
            update_1.UpdatePage
        ],
        bootstrap: [app_component_1.AppComponent]
    })
], AppModule);
exports.AppModule = AppModule;
//# sourceMappingURL=app.module.js.map