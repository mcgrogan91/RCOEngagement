@extends('layouts/main')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-12">
    	<div class="card">
				<div class="card-block">
					<h2 class="card-title">Map of RCO's in Philadelphia</h2>
					<div class="mt-5" id="map"></div>
					<h6 class="card-subtitle mb-2 text-muted">You can use this map to explore your area</h6>
					<p class="card-text">nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>
					<a href="#" class="card-link">Card link</a>
					<a href="#" class="card-link">Another link</a>
				</div>
			</div>
    </div>
	</div>
</div>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiYmlsbG1vcmlhcnR5IiwiYSI6ImNqMTVvZGF5bjAxMDEzM21vZDJoMTEya2QifQ.ok-L_bNQuF8knLOevFLezw';
var map = new mapboxgl.Map({
    container: 'map',
      style: 'mapbox://styles/mapbox/light-v9',
      center: [-75.118, 40.002],
      zoom: 10
});


map.on('load', () => {
// Add the data to your map as a layer
  map.addLayer({
    id: 'rco-data',
    type: 'fill',
    // Add a GeoJSON source containing place coordinates and information.
    source: {
      type: 'vector',
      // I uploaded the geojson data to mapbox and it created a vector file located here
      url: 'mapbox://billmoriarty.cj19vraqq08ft2qqsjfq3lgwk-5l6gv'
    },
    // this is the name of the file on mapbox
    'source-layer': 'RCO_-_Zoning_RCO_2',
    // this is that nice blue color for the map
    'paint': {
      // "fill-color": 'hsla(215, 87%, 55%, 0.13)'
      'fill-color': 'hsla(6,22%,52%, 0.13)'
    }
  });
});

    // When a click event occurs on a feature in the states layer, open a popup at the
    // location of the click, with description HTML from its properties.
    // I should make the names of the RCO's link to the RCO
map.on('click', 'locations', function (e) {
debugger;
  var popup = new mapboxgl.Popup();
  var string_for_popup;

  //this first check for No RCO's doesn't work yet
  if(e.features.length < 1){
    string_for_popup = "No RCO's serve this neighborhood. Maybe you should start one!";
    }
  // if there is 1 RCO for the area clicked
  else if(e.features.length == 1){
    string_for_popup = "The " +e.features.length+ " RCO that serves this neighborhood is:<br><br>";
    }
  // if there is more than 1 RCO for the area clicked
  else if(e.features.length > 1){
    string_for_popup = "The " +e.features.length+ " RCO's that serve this neighborhood are:<br><br>";
    }

  // loop thru and concatenate each RCO in this territory together in a variable for a Popup
  for(let i=0; i<e.features.length; i++){

    // use this to display the RCO's preferred contact information
    var rcoContactTemp;

    // check with preferred method of contact the RCO specified and use that for their displayed contact
    if(e.features[i].properties.PREFFERED_CONTACT_METHOD === "Email"){
        rcoContactTemp = e.features[i].properties.PRIMARY_EMAIL;
        }
    else if (e.features[i].properties.PREFFERED_CONTACT_METHOD === "Mail"){
        rcoContactTemp = e.features[i].properties.PRIMARY_ADDRESS;
    }
    else if (e.features[i].properties.PREFFERED_CONTACT_METHOD === "Phone"){
        rcoContactTemp = e.features[i].properties.PRIMARY_PHONE;
    }

      popup.setLngLat(e.lngLat)
      string_for_popup = string_for_popup.concat(e.features[i].properties.ORGANIZATION_NAME + "<br>" + rcoContactTemp + "<br><br>");

    }//end for

    // when the for loop is done, display the popup
    popup.setHTML(string_for_popup);
    popup.addTo(map);
});
</script>
</div>
@endsection
