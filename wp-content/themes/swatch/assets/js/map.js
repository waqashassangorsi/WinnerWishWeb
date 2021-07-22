'use strict';

/* global google: false */

(function($) {
    $(document).ready(function() {
        $('.google-map').each( function() {
            var mapDiv = $(this);
            var mapData = window[mapDiv.attr('id')];

            function createMap( position ) {

                var style = [{
                    'stylers': [{
                        'visibility': 'off'
                    }]
                },{
                    'featureType': 'road',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#ffffff'
                    }]
                },{
                    'featureType': 'road.arterial',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#f1c40f'
                    }]
                },{
                    'featureType': 'road.highway',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#f1c40f'
                    }]
                },{
                    'featureType': 'landscape',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#ecf0f1'
                    }]
                },{
                    'featureType': 'water',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#73bfc1'
                    }]
                },{},{
                    'featureType': 'road',
                        'elementType': 'labels',
                        'stylers': [{
                        'visibility': 'off'
                    }]
                },{
                    'featureType': 'poi.park',
                        'elementType': 'geometry.fill',
                        'stylers': [{
                        'visibility': 'on'
                    },{
                        'color': '#2ecc71'
                    }]
                },{
                    'elementType': 'labels',
                        'stylers': [{
                        'visibility': 'off'
                    }]
                },{
                    'featureType': 'landscape.man_made',
                        'elementType': 'geometry',
                        'stylers': [{
                        'weight': 0.9
                    },{
                        'visibility': 'off'
                    }]
                }];

                var options = {
                    zoom: parseInt( mapData.mapZoom, 10 ),
                    scrollwheel: false,
                    mapTypeId: google.maps.MapTypeId[mapData.mapType]
                };

                if( mapData.mapStyle === 'flat' ) {
                    options.styles = style;
                }
                return new google.maps.Map(mapDiv[0], options);
            }

            // create map
            var map = createMap();

            // create bounds in case we dont have center map coordinates
            // every time a marker is added we increase the bounds
            var bounds = new google.maps.LatLngBounds();
            var visibleMarker = false;

            function addMarker(position, index) {

                var image = {
                    url: mapData.markerURL,
                    size: new google.maps.Size(30, 48),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(15, 48)
                };

                if(mapData.marker === 'show') {
                    visibleMarker = true;
                }
                var marker = new google.maps.Marker({
                    position: position,
                    icon:image,
                    map: map,
                    visible: visibleMarker
                });

                // extend bounds to encase new marker
                bounds.extend(position);

            }

            // create markers
            if(mapData.address) {
                // lookup addresses
                var markerAddressCount = 0;
                $.each(mapData.address, function(index, address) {
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ 'address': address}, function(results, status) {
                        if(status === google.maps.GeocoderStatus.OK) {
                             if(undefined !== results[0]) {
                                var location = results[0].geometry.location;
                                var position = new google.maps.LatLng(location.lat(), location.lng());
                                addMarker(position, index);
                             }
                        }
                        else {
                            console.log('Geocode was not successful for the following reason: ' + status);
                        }

                        // increment count so we can keep track of all markers loaded
                        markerAddressCount++;
                        // if all markers are loaded then fit map
                        if( markerAddressCount === mapData.address.length) {
                            map.fitBounds(bounds);
                        }
                    });
                });
            }
            else if(undefined !== mapData.latlng) {
                for(var i = 0; i < mapData.latlng.length; i++) {
                    var coordinates = mapData.latlng[i].split(',');
                    var position = new google.maps.LatLng(coordinates[0], coordinates[1]);
                    addMarker(position, i);
                }
                map.fitBounds(bounds);
            }
            var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
                this.setZoom(parseInt(mapData.mapZoom, 10));
                google.maps.event.removeListener(boundsListener);
            });
        });
    });

})(jQuery);