let mymap;
function onStart() {
    mymap = L.map('myMap').setView([48.151381, 17.071984], 16);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWljYWxlIiwiYSI6ImNrM3p4NWxjYzEwMXUzcnM4bjQ5N2R4eGkifQ.2JmXdWWPCFwM5AJ5UujDWw', {
        id: 'mapbox/streets-v11',
        accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);

    let blokA = {"type": "Feature",
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.072547376155853,
                        48.15182003649369
                    ],
                    [
                        17.073880434036255,
                        48.15182003649369
                    ],
                    [
                        17.073880434036255,
                        48.1519685614724
                    ],
                    [
                        17.072547376155853,
                        48.1519685614724
                    ],
                    [
                        17.072547376155853,
                        48.15182003649369
                    ]
                ]
            ]
        },
        "properties": {
            "name": "blokA"
        }
    };
    let blokB = {"type": "Feature",
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.072997987270355,
                        48.152322872336256
                    ],
                    [
                        17.074357867240906,
                        48.152322872336256
                    ],
                    [
                        17.074357867240906,
                        48.15246602754695
                    ],
                    [
                        17.072997987270355,
                        48.15246602754695
                    ],
                    [
                        17.072997987270355,
                        48.152322872336256
                    ]
                ]
            ]
        },
        "properties": {
            "name": "blokB"
        }
    };
    let blokC = {"type": "Feature",
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.072815597057343,
                        48.152831071526535
                    ],
                    [
                        17.073872387409207,
                        48.152831071526535
                    ],
                    [
                        17.073872387409207,
                        48.15297422531943
                    ],
                    [
                        17.072815597057343,
                        48.15297422531943
                    ],
                    [
                        17.072815597057343,
                        48.152831071526535
                    ]
                ]
            ]
        },
        "properties": {
            "name": "blokC"
        }
    };
    let blokD = {"type": "Feature",
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.073196470737457,
                        48.15333389746188
                    ],
                    [
                        17.074365913867947,
                        48.15333389746188
                    ],
                    [
                        17.074365913867947,
                        48.15347704985201
                    ],
                    [
                        17.073196470737457,
                        48.15347704985201
                    ],
                    [
                        17.073196470737457,
                        48.15333389746188
                    ]
                ]
            ]
        },
        "properties": {
            "name": "blokD"
        }
    };
    let blokE = {"type": "Feature",
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.072820961475372,
                        48.153840297249474
                    ],
                    [
                        17.07388311624527,
                        48.153840297249474
                    ],
                    [
                        17.07388311624527,
                        48.15397986945726
                    ],
                    [
                        17.072820961475372,
                        48.15397986945726
                    ],
                    [
                        17.072820961475372,
                        48.153840297249474
                    ]
                ]
            ]
        },
        "properties": {
            "name": "blokE"
        }
    };
    let tis   = {
        "type": "Feature",
        "properties": {},
        "geometry": {
            "type": "Polygon",
            "coordinates": [
                [
                    [
                        17.072555422782898,
                        48.152827492676586
                    ],
                    [
                        17.072810232639313,
                        48.152827492676586
                    ],
                    [
                        17.072810232639313,
                        48.154446896776534
                    ],
                    [
                        17.072555422782898,
                        48.154446896776534
                    ],
                    [
                        17.072555422782898,
                        48.152827492676586
                    ]
                ]
            ]
        }
    };
    L.geoJSON(blokA).addTo(mymap).bindPopup("Blok A<br>Ústav matematiky, Ústav informatiky");
    L.geoJSON(blokB).addTo(mymap).bindPopup("Blok B<br>Ústav elektrotechniky, Ústav energetiky");
    L.geoJSON(blokC).addTo(mymap).bindPopup("Blok C<br>Ústav elektroenergetiky a aplikovanej elektrotechniky");
    L.geoJSON(blokD).addTo(mymap).bindPopup("Blok D<br>Ústav robotiky a kybernetiky");
    L.geoJSON(blokE).addTo(mymap).bindPopup("Blok E<br>Ústav elektroniky a fotoniky");
    L.geoJSON(tis).addTo(mymap).bindPopup("Blok TIŠ<br>Technologický inštitút športu");

    let icon = L.Icon.extend({
        options: {
            iconSize:     [40, 40],
            iconAnchor:   [20, 40],
            popupAnchor:  [-3, -76]
        }
    });

    let busIcon = new icon({iconUrl: 'busIcon.jpg'}),
        trainIcon = new icon({iconUrl: 'trainIcon.jpg'});

    L.marker([48.154127, 17.076838], {icon: busIcon}).addTo(mymap).bindPopup("Zastávka autobusu<br>Zoo<br>Spoje: 30, 32, 37, 92, 192, N29");
    L.marker([48.156288, 17.071759], {icon: busIcon}).addTo(mymap).bindPopup("Zastávka autobusu<br>Televízia<br>Spoje: 31, 39, N31, X31");
    L.marker([48.147964, 17.072514], {icon: busIcon}).addTo(mymap).bindPopup("Zastávka autobusu<br>Botanická záhrada<br>Spoje: 29, 32, N29, N33, N34");
    L.marker([48.148164, 17.071705], {icon: trainIcon}).addTo(mymap).bindPopup("Zastávka električky<br>Botanická záhrada<br>Spoje: X6");

    L.Routing.control({
        waypoints: [
            ,
            L.latLng(48.151709, 17.072415)
        ],
        routeWhileDragging: true,
        geocoder: L.Control.Geocoder.nominatim()
    }).addTo(mymap);
}