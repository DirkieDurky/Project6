var ua = navigator.userAgent.toLowerCase();
var map;
var mapView;
var thuis;
var TrackerLayer;
var TrackerSource;
var TrackerPoint;
var RouteLayer;
var RouteSource;
var RoutePoint;
var locTijd = MSecs();
var posTijd = MSecs();
var vorigePositieLon = -1;
var vorigePositieLat = -1;
var vorigeHoek = -1;
var Posities = [];
var HPosIcon;
var NogUpdaten = [];
var FollowLayer;
var KeukenIcon;
var KeukenLayer;
var zoom = 15;
var rotate = 100;
var toonTijd;
var huidigeTijd;
var ClockTimeOut = -1;
var VorigeSavePositiesTijd = -1;
var Rotatie = 0;
var SimTeller = 0;
var AantalTrackPunten = 0;
var gpxArray = [];
var maxLon = -1;
var maxLat = -1;
var minLon = 9999;
var minLat = 9999;
var trackerTimeOut = -1;
var simTimeOut = -1;
var HuidigePositie = -1;
var LocatieIDHpos = -1;
var BezigMetOpslaan = -1;


var options = {
    enableHighAccuracy: false,
    timeout: Number.POSITIVE_INFINITY,
    maximumAge: 0
};

function Init() {
    zoom = 13;
    thuis = ol.proj.transform([7.03634, 50.05294], 'EPSG:4326', 'EPSG:3857');
    $("#map").empty();

    MaakMapLayer();

    HaalPunten(); // zit ajax in volgende procedures in result function

    setInterval(function () {
        $("#tijd").html("&#9201; " + Tijd());
    }, 1000);
}

function MaakMapLayer() {
    var baseLayer = new ol.layer.Tile({
        source: new ol.source.OSM()
    }
    );

    mapView = new ol.View({
        center: thuis,
        zoom: zoom,
        maxZoom: 19,
        constrainRotation: 16  // 16 draai posities
    }
    );
    map = new ol.Map({
        target: 'map',
        layers: [baseLayer],
        view: mapView,
        controls: ol.control.defaults({
            attribution: false,
            zoom: false,
            rotate: false
        }
        )
    }
    );
}

function MaakRouteLayer() {
    var gpx = new ol.layer.Vector({
        source: new ol.source.Vector({
            url: 'routes/' + RouteName + ".gpx",
            format: new ol.format.GPX()
        }
        ),
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: "darkblue",
                width: 2
            }
            )
        }
        )
    }
    );
    map.addLayer(gpx);
    Ok();
}

function HaalPunten() {
    $("#action").html("Loading route...");
    ResetMaxMinPos();

    $.ajax({
        type: "GET",
        url: "routes/" + RouteName + ".gpx?" + TijdAsInt(),
        dataType: "xml",
        error: AjaxError,
        success: VerwerkPunten
    }
    );
}

function VerwerkPunten(gpx) {
    var lon;
    var lat;
    data = [];
    $(gpx).find("wpt").each(function () {
        data.push(MaakWaypointPoint($(this)));
    }
    );
    if (data.length > 0) {
        var wpts = new ol.source.Vector({
            features: data
        }
        );


        var wptl = new ol.layer.Vector({
            source: wpts
        }
        );
        map.addLayer(wptl);
    }
    AantalTrackPunten = 0;
    gpxArray = [];
    $(gpx).find("trkpt").each(function () {
        lon = parseFloat($(this).attr("lon"));
        lat = parseFloat($(this).attr("lat"));
        SetMaxMinPos(lon, lat);
        AantalTrackPunten++;
        gpxArray.push({
            Lon: lon,
            Lat: lat,
            Tijd: Date.now()
        }
        );

        /*     {
                                            console.log("(" + lon + "," + lat + "),");
             }
        */
    }
    );
    MaakRouteLayer();

    MaakTrackerLayer();
    if (PINCode > 0) { // Volgend
        MaakFollowLayer();

        HaalTrackers();

        //      activeerVolgen();
        if (VGT < 0)
            simuleerVolgen(gpx);
    }
    SchaalEnCentreerMap();
    Ok();
}

function MaakWaypointPoint(punt) {
    var naam = $(punt).find("name").text();
    var lon = punt.attr("lon");
    var lat = punt.attr("lat");

    var tpointStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [1, 1],
            src: 'herberg.png'
        }
        ),
        text: new ol.style.Text({
            font: '14px Arial, Verdana, Helvetica, sans-serif',
            fill: new ol.style.Fill({
                color: '#000'
            }
            ),
            text: naam,
            textAlign: 'center',
            textBaseline: 'bottom',
            offsetY: -25,
            placement: 'point'
        }
        )
    }
    );
    var tpoint = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lon), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857'))
    }
    );
    tpoint.setStyle(tpointStyle);
    return tpoint;
}

function MaakTrackerLayer() {
    TrackerSource = new ol.source.Vector({
        features: []
    }
    );


    TrackerLayer = new ol.layer.Vector({
        source: TrackerSource,
    }
    );
    map.addLayer(TrackerLayer);
}

function HaalTrackers() {
    clearTimer(trackerTimeOut);
    TrackerSource.clear();
    $("#action").html("Loading trackers...");
    $.ajax({
        type: "POST",
        url: "haaltrackers.php",
        data: {
            PINCode: PINCode
        },
        success: SuccessTrackers,
        timeout: 30000,
        error: ErrorTrackers
    }
    );
}

function SuccessTrackers(trackers) {
    var kleur;
    var trackers;
    var tps = [];
    var lon;
    var lat;
    for (var t in trackers) {
        lon = parseFloat(trackers[t].Lon);
        lat = parseFloat(trackers[t].Lat);
        tps.push(MaakTrackerPoint(lon, lat, -1));
    }
    if (tps.length > 0) {
        if (VGT > 0) {  //  tps.push(MaakTrackerPoint(lon, lat, 1));
            tps.push(MaakTrackerPoint(lon, lat, 2));
            SetMaxMinPos(lon, lat);
            HuidigePositie = ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857');
            centerMap(HuidigePositie);
        }
        TrackerSource.addFeatures(tps);
    }

    trackerTimeOut = setTimeout(function () {
        HaalTrackers();
    },
        5000);
    Ok();
    NoError();
}

function ErrorTrackers(xhr, reason, ex) {
    $("#error").html("Error trackers: " + reason + "==" + ex + "==" + xhr);
    trackerTimeOut = setTimeout(function () {
        HaalTrackers();
    },
        10000);
    centerMap(thuis);
}

function SimuleerTrackers(gpx) {
    var lon;
    var lat;
    var tps = [];
    var tel = 0;
    var tussentel;
    $("#action").html("Laden trackers.....");
    TrackerSource.clear();
    $(gpx).find("trkpt").each(function () {
        if (tel > SimTeller) {
            lon = parseFloat($(this).attr("lon"));
            lat = parseFloat($(this).attr("lat"));
            tps.push(MaakTrackerPoint(lon, lat, -1));
            if (tel > (50 + SimTeller)) {
                return false
            }
        }
        tel++;
    }
    );
    if (tps.length > 0) {
        tps.push(MaakTrackerPoint(lon, lat, 1));
        tps.push(MaakTrackerPoint(lon, lat, 2));
        SetMaxMinPos(lon, lat);
        TrackerSource.addFeatures(tps);
        $("#messages").html("&#9872; N " + lat.toFixed(6) + "&nbsp;&nbsp;&nbsp;E " + lon.toFixed(6));
        NoError();
    } else {
        $("#error").html("Geen active locatie gevonden!");
    }
    trackerTimeOut = setTimeout(function () {
        SimTeller += 50;
        if (SimTeller > AantalTrackPunten) {
            SimTeller = 0;
        }
        ResetMaxMinPos();
        SimuleerTrackers(gpx);
    },
        5000);
    Ok();
}

function SchaalEnCentreerMap() {
    lon = (minLon + maxLon) / 2;
    lat = (minLat + maxLat) / 2;
    HuidigePositie = ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857');
    mapView.fit(ol.proj.transformExtent([minLon, minLat, maxLon, maxLat],
        'EPSG:4326',
        mapView.getProjection()),
        {
            size: map.getSize()
        }
    );
    centerMap(HuidigePositie);
}

function MaakFollowLayer() {
    HPosIcon = new ol.Feature({
        geometry: new ol.geom.Point(thuis),
        name: 'Follow'
    }
    );
    var vSource = new ol.source.Vector({
        features: [HPosIcon]
    }
    );

    var iconStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchorXUnits: 'fraction',
            anchorYUnits: 'pixels',
            scale: 0.5,
            opacity: 0.75,
            src: 'follow.png'
        }
        )
    }
    );
    if (VGT > 0)
        return;

    FollowLayer = new ol.layer.Vector({
        source: vSource,
        style: iconStyle
    }
    );
    map.addLayer(FollowLayer);
}


function activeerVolgen() {
    if (HuidigePositie !== -1)
        showHuidigePositie(HuidigePositie); // Toon direct laatste huidige positie
    /*     var result = navigator.permissions.query({name:'geolocation'}).then(function(result)
                                                                             {    alert(result.state);
                                                                             }
                                                                            );
    */

    LocatieIDHpos = navigator.geolocation.watchPosition(showHuidigePositie, LocError, options);
    mapView.setRotation(0);
    var coord = HPosIcon.getGeometry().getCoordinates(); // Huidige positie
    centerMap(coord);
}

function simuleerVolgen() {
    var lon;
    var lat;
    var hoek;
    var snelheid;
    var nauwkeurigheid = 999;
    if (AantalTrackPunten < 1) {
        return;
    }
    HuidigePositie = {
        timestamp: -1,
        coords: {
            longitude: gpxArray[0].Lon,
            latitude: gpxArray[0].Lat,
            heading: 0,
            speed: 20,
            accuracy: 1
        }
    }
    SimTeller = 1;
    simTimeOut = setInterval(function () {
        SimTeller++;
        if (SimTeller > AantalTrackPunten)
            SimTeller = 1;
        var hoek = 0;
        if (SimTeller > 1) {
            hoek = berekenHoek(gpxArray[SimTeller - 2].Lat, gpxArray[SimTeller - 2].Lon,
                gpxArray[SimTeller - 1].Lat, gpxArray[SimTeller - 1].Lon);
        }
        showHuidigePositie({
            timestamp: MSecs(),
            coords: {
                longitude: gpxArray[SimTeller - 1].Lon,
                latitude: gpxArray[SimTeller - 1].Lat,
                heading: hoek,
                speed: 20,
                accuracy: 1
            }
        }
        );
    },
        5000);
    //  LocatieIDHpos = navigator.geolocation.watchPosition(showHuidigePositie, LocError, options);
    mapView.setRotation(0);
    var coord = HPosIcon.getGeometry().getCoordinates(); // Huidige positie
    centerMap(coord);
}

function deActiveerHuidigePositie() {
    if (LocatieIDHpos !== -1)
        navigator.geolocation.clearWatch(LocatieIDHpos);
    mapView.setRotation(0);
    $("#knopAuto").html("Auto volgen");
    $("#knopAuto").removeAttr("volgen");
}

function LocError(error) {
    var txt;
    switch (error.code) {
        case error.PERMISSION_DENIED:
            txt = "afgebroken"
            break;
        case error.POSITION_UNAVAILABLE:
            txt = "geen locatie"
            break;
        case error.TIMEOUT:
            txt = "time out"
            break;
        case error.UNKNOWN_ERROR:
            txt = "onbekend"
            break;
    }
    $("#error").html("loc error: " + txt);
}

function AjaxError(xhr, reason, ex) {
    $("#error").html("Error: " + reason + " " + ex);
}

function MaakTrackerPoint(lon, lat, islaatste = -1)    // islaatste < 0 : eersten
// islaatste = 1 : voolaatste
// islaatste = 2 : laatste
{
    var src = 'red.png';
    var scale = 0.3;
    var opacity = 1;
    if (islaatste > 0) {
        scale = 1;
        opacity = 1;
    }
    if (islaatste > 1) {
        src = 'ezel.png';
        scale = 1;
        opacity = 1;
    }

    var tpointStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0, 0],
            scale: scale,
            opacity: opacity,
            src: src
        }
        )
    }
    )
    var tpoint = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lon), parseFloat(lat)], 'EPSG:4326', 'EPSG:3857'))
    }
    );
    tpoint.setStyle(tpointStyle);
    return tpoint;
}

function formatTijd(datum) {
    return datum.substring(8, 10) + ":" +
        datum.substring(10, 12) + ":" +
        datum.substring(12, 14);
}

function setMovementClass(Kleur) {
    $("#tijd").removeClass("clsRood clsGroen");
    $("#tijd").addClass("cls" + Kleur);
}

function showHuidigePositie(position) {
    if ((HuidigePositie !== -1) &&
        (position.timestamp <= HuidigePositie.timestamp))
        return;

    var lon = parseFloat(position.coords.longitude);
    var lat = parseFloat(position.coords.latitude);

    var hoek = parseFloat(position.coords.heading);
    var snelheid = 0;
    if (position.coords.speed)
        snelheid = parseFloat(position.coords.speed);

    var nauwkeurigheid = 999;
    if (position.coords.accuracy)
        nauwkeurigheid = parseFloat(position.coords.accuracy);

    if ((vorigePositieLat < 0) || (vorigePositieLon < 0)) {
        vorigePositieLat = lat;
        vorigePositieLon = lon;
    }
    var afstand = berekenAfstand(vorigePositieLat, vorigePositieLon, lat, lon);

    if ((snelheid < 0.3) || (afstand < 3) || nauwkeurigheid > 20) {
        if (MSecs() - locTijd > 5000)
            setMovementClass("Rood");
        return;
    }

    if (BezigMetOpslaan > 0)
        return; // Kan een enkele positie verloren gaan

    if (MSecs() - posTijd > 5000) {
        posTijd = MSecs();
        Posities.push({
            Lon: lon,
            Lat: lat,
            Tijd: TijdAsInt()
        }
        );

        var tps = MaakTrackerPoint(lon, lat, -1)
        TrackerSource.addFeature(tps);
    }

    vorigePositieLat = lat;
    vorigePositieLon = lon;

    // Elke seconde huidige positie laten zien
    if (MSecs() - locTijd < 1000)
        return;

    locTijd = MSecs();

    var coord = ol.proj.transform([lon, lat], 'EPSG:4326', 'EPSG:3857');
    centerMap(coord);
    HPosIcon.getGeometry().setCoordinates(coord);
    HuidigePositie = position;
    $("#messages").html("&#9872; N" + lat.toFixed(6) + "&nbsp;&nbsp;E" + lon.toFixed(6));
    setMovementClass("Groen");

    if (hoek) {
        hoek = hoek * -3.141592654 / 180;
        mapView.adjustRotation(hoek, coord); // radialen
    }
    NoError();

    var time = Math.floor(Date.now() / 1000);
    if (((time - VorigeSavePositiesTijd) < 10) || (Posities.length < 1))
        return; // Elke 10 seconden update

    VorigeSavePositiesTijd = time;
    saveLocs();
}

function saveLocs() {
    $("#action").html("Upload... " + Posities.length);
    try {
        BezigMetOpslaan = 1;
        var pos = Posities.slice();
        Posities = [];
    } catch (err) {
        $("#error").html("Save: " + err);
    } finally {
        BezigMetOpslaan = -1;
    }
    $.ajax({
        type: "POST",
        url: "saveloc.php",
        timeout: 30000,
        data: {
            posities: JSON.stringify(pos),
            PINCode: PINCode
        },
        async: true,
        success: function (result) {
            Ok();
            if (!($.isNumeric(result))) {
                alert(result);
                $("#map").empty();
            }
        },
        error: function (xhr) {
            $("#error").html("Error: " +
                xhr.status + " -- " +
                xhr.statusText);
            Herstel(pos);
        }
    }
    );
}

function Herstel(pos) {
    try {
        BezigMetOpslaan = 1;
        Posities = $.merge(pos, Posities);
    } catch (err) {
        $("#error").html(" Recovery: " + err);
    } finally {
        BezigMetOpslaan = -1;
    }
}

function Tijd() {
    var time = new Date();
    var h = time.getHours();
    var m = time.getMinutes();
    var s = time.getSeconds();
    var fullTime = ((h < 10) ? ("0" + h) : (h)) + ":" +
        ((m < 10) ? ("0" + m) : (m)) + ":" +
        ((s < 10) ? ("0" + s) : (s));
    return fullTime;
}

function DatumTijd() {
    var time = new Date();
    var d = time.getDate()
    var z = 1 + time.getMonth();
    var j = time.getFullYear()
    var h = time.getHours();
    var m = time.getMinutes();
    var s = time.getSeconds();
    var fullTime = d + "-" +
        ((z < 10) ? ("0" + h) : (h)) + "-" +
        ((d < 10) ? ("0" + h) : (h)) + " " +
        ((h < 10) ? ("0" + h) : (h)) + ":" +
        ((m < 10) ? ("0" + m) : (m)) + ":" +
        ((s < 10) ? ("0" + s) : (s));
    return fullTime;
}

function TijdAsInt() {
    var time = new Date();
    var h = time.getHours();
    var m = time.getMinutes();
    var s = time.getSeconds();
    var n = time.getMilliseconds();
    return (h * 10000000) + (m * 100000) + (s * 1000) + n;
}

function MSecs() {
    var d = new Date();
    return d.getTime();
}

function toRad(num) {
    return num * Math.PI / 180;
}

function berekenAfstand(lat1, lon1, lat2, lon2) {
    const EARTH_RADIUS = 6371000;
    var dLat = toRad(lat2 - lat1);
    var dLon = toRad(lon2 - lon1);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(toRad(lat1)) *
        Math.cos(toRad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var distance = EARTH_RADIUS * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return distance;
}

function berekenHoek(lat1, lon1, lat2, lon2) {
    var y = Math.sin(lon2 - lon1) * Math.cos(lat2);
    var x = Math.cos(lat1) * Math.sin(lat2) -
        Math.sin(lat1) * Math.cos(lat2) * Math.cos(lon2 - lon1);
    var b = Math.atan2(y, x);
    return (b * 180 / Math.PI + 360) % 360;
}

function centerMap(coord) {
    if (zoom < 0)
        mapView.setCenter(coord);
    else mapView.setCenter(coord, zoom);
    zoom = -1;
}

function clearTimer(timeOutID) {
    if (timeOutID > -1)
        clearTimeout(timeOutID);
    timeOutID = -1;
}

function ResetMaxMinPos() {
    maxLon = -1;
    maxLat = -1;
    minLon = 9999;
    minLat = 9999;
}

function SetMaxMinPos(lon, lat) {
    maxLon = Math.max(maxLon, lon);
    minLon = Math.min(minLon, lon);
    maxLat = Math.max(maxLat, lat);
    minLat = Math.min(minLat, lat);
}

function Ok() {
    $("#action").empty();
}

function NoError() {
    $("#error").empty();
}

