//Define within full script scope, does not need to be within document ready as scripts required are loaded in head
function addRowTable(code, coords) {
    var tr = document.createElement("tr");
    var td = document.createElement("td");
    td.textContent = code;
    tr.appendChild(td);
    tr.onclick = function () {
        map.flyTo(coords, 14);
    };
    document.getElementById("t_points").appendChild(tr);
}

//Confirm selected locations
function confirmLocations() {
    //Gather required variables
    let from = document.getElementById("from").value
    let fromCode = document.getElementById("from-code").value
    let to = document.getElementById("to").value
    let toCode = document.getElementById("to-code").value

    //If somehow Pickup location == Delivery location, reject the values
    if (fromCode == toCode) {
        bootbox.alert({
            message: "Pickup Location can't be the same as Delivery Location!",
            centerVertical: true,
        })
        return;
    }

    //If all is well, lets actually confirm the locations
    if (fromCode != '' && toCode != '') {
        bootbox.confirm({
            message: "<b>Pick up from : </b><br>" + from + "<br><b>Deliver to :</b><br>  " + to + "<br>",
            centerVertical: true,
            size:'large',
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == false) {
                    locationConfirmationDismissed = true;
                } else {
                    submitDeliveryDetails("Delivery!");
                }
            }
        });
    }
    //Validation failed, identify from simple fork which input has failed and return validation message
    else {
        if (fromCode == '') {
            bootbox.alert({
                message: "Please select a Pick up Location!",
                centerVertical: true,
            })
        } else if (toCode == '') {
            bootbox.alert({
                message: "Please select a Delivery Location!",
                centerVertical: true,
            })
        }
        map.closePopup()
    }
}

//Validation helpers
function validateFromLocation(code) {
    //Get to location for validation
    let toCode = document.getElementById("to-code").value
    //Check if to code is set
    if (toCode) {
        //Ensure pickup and delivery location not the same
        if (toCode == code) {
            bootbox.alert({
                message: "Pickup Location can't be the same as Delivery Location!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        //Validation succeeded
        else {
            return true;
        }
    }
    //Nothing to validate
    else {
        return true;
    }
}
function validateCustomFromLocation(name) {
//Get to location for validation
    let to = document.getElementById("to").value
    //Check if to code is set
    if (name) {
        //Ensure pickup and delivery location not the same
        if (to == name) {
            bootbox.alert({
                message: "Pickup Location can't be the same as Delivery Location!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        if(name.length > 50){
            bootbox.alert({
                message: "Delivery name can't be longer than 50 characters!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        //Validation succeeded
        else {
            return true;
        }
    }
    //Nothing to validate
    else {
        return true;
    }
}

//Validation helpers
function validateToLocation(code) {
    //Get to location for validation
    let fromCode = document.getElementById("from-code").value
    //Check if to code is set
    if (fromCode) {
        //Ensure pickup and delivery location not the same
        if (fromCode == code) {
            bootbox.alert({
                message: "Pickup Location can't be the same as Delivery Location!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        //Validation succeeded
        else {
            return true;
        }
    }
    //Nothing to validate
    else {
        return true;
    }
}
function validateCustomToLocation(name) {
    //Get to location for validation
    let from = document.getElementById("from").value
    //Check if to code is set
    if (name) {
        //Ensure pickup and delivery location not the same
        if (from == name) {
            bootbox.alert({
                message: "Pickup Location can't be the same as Delivery Location!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        if(name.length > 50){
            bootbox.alert({
                message: "Delivery name can't be longer than 50 characters!",
                centerVertical: true,
            })
            map.closePopup()
            return false;
        }
        //Validation succeeded
        else {
            return true;
        }
    }
    //Nothing to validate
    else {
        return true;
    }
}

//Set from location on marker popup button click event
function setFromLocation(title, code) {
    if(!validateFromLocation(code)){
        return;
    }

    //**[ Validation succeeded ]**\\

    //Set location title (Input top left and used elsewhere in alerts etc)
    document.getElementById("from").value = title
    //Set location code
    document.getElementById("from-code").value = code

    //If the user has previously dismissed the confirmation dialogue, don't pester the user, let the user manually request delivery when ready
    if (locationConfirmationDismissed == false) {
        confirmLocations();
    }

    //User should not have to close the popup manually, clear popups from interface
    map.closePopup()
}
function setToLocation(title, code) {
    if(!validateToLocation(code)){
        return;
    }

    //**[ Validation succeeded ]**\\

    //Set location title (Input top left and used elsewhere in alerts etc)
    document.getElementById("to").value = title
    //Set location code
    document.getElementById("to-code").value = code

    //If the user has previously dismissed the confirmation dialogue, don't pester the user, let the user manually request delivery when ready
    if (locationConfirmationDismissed == false) {
        confirmLocations();
    }
    //User should not have to close the popup manually, clear popups from interface//User should not have to close the popup manually, clear popups from interface
    map.closePopup()
}

//Set user location
function setCustomFromLocation() {
    bootbox.prompt("Pick up location name?", function (name) {
        if(!validateCustomFromLocation(name)){
            return;
        } else {
            document.getElementById("from-code").value = "custom-from"
            document.getElementById("from").value = name
        }

        //If the user has previously dismissed the confirmation dialogue, don't pester the user, let the user manually request delivery when ready
        if (locationConfirmationDismissed == false) {
            confirmLocations();
        }
    });
    map.closePopup()
}
function setCustomToLocation() {
    bootbox.prompt("Delivery location name?", function (name) {
        if(!validateCustomToLocation(name)){
            map.closePopup()
            return;
        } else {
            document.getElementById("to-code").value = "custom-to"
            document.getElementById("to").value = name
        }

        //If the user has previously dismissed the confirmation dialogue, don't pester the user, let the user manually request delivery when ready
        if (locationConfirmationDismissed == false) {
            confirmLocations();
        }
    });
    map.closePopup()
}

//Add markers to map (Called on init)
function addMarker(title, code, lat, lng) {
    //Define marker object
    var p = L.marker([lat, lng], title);
    //Set marker properties
    p.title = title;
    p.alt = title;
    //Define popupContent with onClick functions to manage Pickup/Delivery location
    let popupContent = "<button type='button' class='btn btn-primary' onclick='setFromLocation(\"" + title + "\",\"" + code + "\")'>Set as Pickup Location</button><hr>"
    popupContent += "<button type='button' class='btn btn-primary' onclick='setToLocation(\"" + title + "\",\"" + code + "\")'>Set as Delivery Location</button><hr>"
    //Bind the generated popupContent to the marker
    p.bindPopup(popupContent)
    //Finally add the marker to the map
    p.addTo(map);
    //Set the name as a tooltip and Open it up so user can see what location is what marker
    p.bindTooltip(title,{permanent:true}).openTooltip()
    addRowTable(title, [lat, lng]);
}
function addMarkerOnClick(e) {
    if (userMarker != null) {
        userMarker.remove();
    }
    let popupContent = "<button type='button' class='btn btn-primary' onclick='setCustomFromLocation()'>Set as Pickup Location</button><hr>"
    popupContent += "<button type='button' class='btn btn-primary' onclick='setCustomToLocation()'>Set as Delivery Location</button><hr>"

    // Add New marker to map at click location; add popup window
    userMarker = new L.marker(e.latlng).addTo(map).bindPopup(popupContent).openPopup();

}

//Submit delivery demo function
function submitDeliveryDetails(message) {
    bootbox.alert({
        message: "Locations selected!",
        centerVertical: true,
    })
}

//** Begin initialization **\\

//If the user dismisses the confirmation, don't constantly repeat it
var locationConfirmationDismissed = false;

//Marker array
var markers = [];
//User location marker
var userMarker = null;

//Let's define the map object and render
var map = L.map('map').setView([-27.9150338, 24.8737837], 6);
//Use open street maps
var openStreeMap = L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

//Define provider
const provider = new GeoSearch.OpenStreetMapProvider()
//Define search bar and geosearch provider
const search = new GeoSearch.GeoSearchControl({
    showMarker: false, // optional: true|false  - default true
    provider: provider,
    style: 'bar'
});

map.addControl(search);

//Define map on click function (It will pass the "click event" as a function)
map.on('click', addMarkerOnClick);

//On Document ready
(function ($) {
    'use strict';

    var points = markerFallback;
    for (var i = 0; i < points.length; i++) {
        addMarker(points[i]["name"], points[i]["value"], points[i]["latitude"], points[i]["longitude"]);
    }

    $("#range").change(function (e) {
        var radius = parseInt($(this).val())
        markers.forEach(function (e) {
            e.setRadius(radius);
            e.addTo(map);
        });
    });
})(jQuery);

