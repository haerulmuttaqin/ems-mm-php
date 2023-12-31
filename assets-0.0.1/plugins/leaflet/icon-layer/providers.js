import {APP_VERSION, BASE_URL} from "../../../dist/js/main.js";

(function(factory) {
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = factory(require('leaflet'));
    } else {
        window.providers = factory(window.L);
    }
})(function(L) {
    var providers = {};

    providers['OpenStreetMap_Mapnik'] = {
        title: 'osm',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/openstreetmap_mapnik.png',
        layer: L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        })
    };

    providers['OpenStreetMap_BlackAndWhite'] = {
        title: 'osm bw',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/openstreetmap_blackandwhite.png',
        layer: L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        })
    };

    providers['OpenStreetMap_DE'] = {
        title: 'osm de',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/openstreetmap_de.png',
        layer: L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        })
    }

    /*providers['Stamen_Toner'] = {
        title: 'toner',
        icon: BASE_URL + 'assets/plugins/leaflet/icon-layer/icons/stamen_toner.png',
        layer: L.tileLayer('http://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png', {
            attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            subdomains: 'abcd',
            minZoom: 0,
            maxZoom: 20,
            ext: 'png'
        })
    };*/

    providers['Esri_OceanBasemap'] = {
        title: 'esri ocean',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/esri_oceanbasemap.png',
        layer: L.tileLayer('http://server.arcgisonline.com/ArcGIS/rest/services/Ocean_Basemap/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri &mdash; Sources: GEBCO, NOAA, CHS, OSU, UNH, CSUMB, National Geographic, DeLorme, NAVTEQ, and Esri',
            maxZoom: 13
        })
    };

    providers['HERE_normalDay'] = {
        title: 'normalday',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/here_normalday.png',
        layer: L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/normal.day/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
            attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
            subdomains: '1234',
            mapID: 'newest',
            app_id: 'OPINc5ojWRttQZBNJZVi',
            app_code: 'OES64_A6i3e-1lpskLiyMQ',
            base: 'base',
            maxZoom: 20
        })
    };

    providers['HERE_normalDayGrey'] = {
        title: 'day grey',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/here_normaldaygrey.png',
        layer: L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/normal.day.grey/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
            attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
            subdomains: '1234',
            mapID: 'newest',
            app_id: 'OPINc5ojWRttQZBNJZVi',
            app_code: 'OES64_A6i3e-1lpskLiyMQ',
            base: 'base',
            maxZoom: 20
        })
    };

    providers['HERE_satelliteDay'] = {
        title: 'satellite',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/here_satelliteday.png',
        layer: L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/satellite.day/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
            attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
            subdomains: '1234',
            mapID: 'newest',
            app_id: 'OPINc5ojWRttQZBNJZVi',
            app_code: 'OES64_A6i3e-1lpskLiyMQ',
            base: 'aerial',
            maxZoom: 20
        })
    };

    providers['CartoDB_Positron'] = {
        title: 'positron',
        icon: BASE_URL + 'assets-'+APP_VERSION+'/plugins/leaflet/icon-layer/icons/cartodb_positron.png',
        layer: L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="http://cartodb.com/attributions">CartoDB</a>',
            subdomains: 'abcd',
            maxZoom: 19
        })
    };

    return providers;
});