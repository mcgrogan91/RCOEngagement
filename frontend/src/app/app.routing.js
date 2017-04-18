"use strict";
var router_1 = require("@angular/router");
var home_1 = require("./pages/home");
var faq_1 = require("./pages/faq");
var about_1 = require("./pages/about");
var map_1 = require("./pages/map");
var detail_1 = require("./pages/detail");
var update_1 = require("./pages/update");
var appRoutes = [
    {
        path: '',
        component: home_1.HomePage
    },
    {
        path: 'faq',
        component: faq_1.FaqPage
    },
    {
        path: 'about',
        component: about_1.AboutPage
    },
    {
        path: 'map',
        component: map_1.MapPage
    },
    {
        path: 'detail',
        component: detail_1.DetailPage
    },
    {
        path: 'update',
        component: update_1.UpdatePage
    }
];
exports.routing = router_1.RouterModule.forRoot(appRoutes);
//# sourceMappingURL=app.routing.js.map