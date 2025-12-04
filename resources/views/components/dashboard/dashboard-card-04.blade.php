<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-xl">
    <div id="map-container" style="z-index: 1; height: 800px;">
        <div id="map" style="width: 100%; height: 100%; border-radius: 12px;"></div>
    </div>
</div>

<script>
    const mapContainer = document.getElementById('map-container');
    window.rentData = @json($rent);

    let map, geocoder, userMarker;
    const locationMarkers = [];
    let allLocationsData = []; // Barcha joylashuvlar ma'lumotlari

    function initMap() {
        const defaultCenter = {
            lat: 41.2995,
            lng: 69.2401
        };

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
            styles: [
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{ visibility: "off" }]
                }
            ]
        });

        geocoder = new google.maps.Geocoder();

        // Foydalanuvchi joylashuvi uchun marker (ko'k rang)
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                labelOrigin: new google.maps.Point(16, -10)
            },
            title: "Sizning joylashuvingiz",
            label: {
                text: "SIZ",
                color: "#FFFFFF",
                fontSize: "13px",
                fontWeight: "bold",
                className: "user-marker-label"
            }
        });

        addLocateButton();
        addSearchBox();

        // Dormitory va Rent joylashuvlarini xaritaga qo'shish
        addLocations();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    map.setZoom(15);
                    userMarker.setPosition(userLocation);
                    calculateDistances(userLocation);
                },
                () => {
                    console.log("Joylashuv ma'lumotini olishda xatolik");
                }
            );
        }

        map.addListener("click", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            userMarker.setPosition({ lat, lng });
            calculateDistances({ lat, lng });
        });

        userMarker.addListener("dragend", function(event) {
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();
            calculateDistances({ lat, lng });
        });
    }

    // Rent joylashuvlarini xaritaga qo'shish
    function addLocations() {
        // Backend dan kelgan ma'lumotlar
        const rents = window.rentData || [];

        // Rent markerlarini qo'shish
        rents.forEach(location => {
            if (!location.latitude || !location.longitude ||
                isNaN(location.latitude) || isNaN(location.longitude)) {
                console.log('Invalid location:', location);
                return;
            }

            addMarker(location, 'rent');
        });

        allLocationsData = rents;
        console.log('Total locations added:', allLocationsData.length);
    }

    function addMarker(location, type) {
        const markerIcon = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';

        const marker = new google.maps.Marker({
            map: map,
            position: {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
            },
            icon: {
                url: markerIcon,
                labelOrigin: new google.maps.Point(16, -10)
            },
            title: location.student?.first_name || 'Ijara joylashuvi',
            label: {
                text: (location.student?.first_name || location.first_name || 'N/A').substring(0, 15),
                color: "#FF4444",
                fontSize: "12px",
                fontWeight: "bold",
                className: "location-marker-label"
            }
        });

        // InfoWindow (bosgan vaqti ko'rinadigan oyna)
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px; max-width: 250px;">
                    <h3 style="margin: 0 0 8px 0; font-size: 16px; font-weight: bold; color: #FF4444;">
                        🏠 ${location.student?.first_name || 'Ijara joylashuvi'}
                    </h3>
                    <p style="margin: 0 0 5px 0; font-size: 13px; color: #1976d2; font-weight: 500;">
                        📍 Masofa: <span id="distance-${location.id}">Hisoblanmoqda...</span>
                    </p>
                    <p style="margin: 0 0 8px 0; font-size: 12px; color: #666;">
                        ${location.address || 'Manzil ko\'rsatilmagan'}
                    </p>
                    ${location.student ? `
                    <p style="margin: 0 0 8px 0; font-size: 12px; color: #666;">
                        Talaba: <strong>${location.student.first_name}</strong>
                    </p>
                    ` : ''}
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${location.latitude},${location.longitude}" 
                       target="_blank"
                       style="display: inline-block; padding: 8px 16px; background-color: #4285f4; 
                              color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                        Yo'nalish olish
                    </a>
                    <a href="/students/${location.student.id}" 
                       style="display: inline-block; padding: 8px 16px; margin-top: 5px; background-color: #4285f4; 
                              color: white; text-decoration: none; border-radius: 4px; font-size: 13px;">
                        To'liq malumot
                    </a>
                </div>
            `
        });

        marker.addListener("click", () => {
            // Boshqa barcha InfoWindow'larni yopish
            locationMarkers.forEach(m => {
                if (m.infoWindow) {
                    m.infoWindow.close();
                }
            });

            infoWindow.open(map, marker);
        });

        locationMarkers.push({
            marker: marker,
            infoWindow: infoWindow,
            location: location,
            type: type
        });
    }

    // Qidiruv maydonini xaritaga qo'shish
    function addSearchBox() {
        const searchContainer = document.createElement("div");
        searchContainer.style.backgroundColor = "white";
        searchContainer.style.margin = "10px";
        searchContainer.style.padding = "10px";
        searchContainer.style.borderRadius = "8px";
        searchContainer.style.boxShadow = "0 2px 6px rgba(0,0,0,0.3)";
        searchContainer.style.width = "320px";
        searchContainer.style.zIndex = "1000";

        const searchInput = document.createElement("input");
        searchInput.type = "text";
        searchInput.placeholder = "Ijara joylashuvini qidiring...";
        searchInput.style.width = "100%";
        searchInput.style.padding = "10px";
        searchInput.style.border = "1px solid #ddd";
        searchInput.style.borderRadius = "4px";
        searchInput.style.fontSize = "14px";
        searchInput.style.boxSizing = "border-box";
        searchInput.style.outline = "none";

        const resultsContainer = document.createElement("div");
        resultsContainer.style.maxHeight = "250px";
        resultsContainer.style.overflowY = "auto";
        resultsContainer.style.marginTop = "8px";
        resultsContainer.style.display = "none";
        resultsContainer.style.backgroundColor = "white";
        resultsContainer.style.borderRadius = "4px";
        resultsContainer.style.border = "1px solid #ddd";

        searchContainer.appendChild(searchInput);
        searchContainer.appendChild(resultsContainer);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchContainer);

        // Qidiruv funksiyasi
        searchInput.addEventListener("input", function() {
            const query = this.value.toLowerCase().trim();
            resultsContainer.innerHTML = "";

            if (query.length < 2) {
                resultsContainer.style.display = "none";
                return;
            }

            const filtered = allLocationsData.filter(loc => {
                const name = loc.student?.first_name || loc.first_name || '';
                const address = loc.address || '';
                return name.toLowerCase().includes(query) || 
                       address.toLowerCase().includes(query);
            });

            if (filtered.length === 0) {
                resultsContainer.innerHTML = '<div style="padding: 10px; color: #999;">Natija topilmadi</div>';
                resultsContainer.style.display = "block";
                return;
            }

            resultsContainer.style.display = "block";

            filtered.forEach(loc => {
                const resultItem = document.createElement("div");
                resultItem.style.padding = "10px";
                resultItem.style.cursor = "pointer";
                resultItem.style.borderBottom = "1px solid #eee";
                resultItem.style.fontSize = "13px";
                
                resultItem.innerHTML = `
                    <strong>🏠 ${loc.student?.first_name || 'Ijara joylashuvi'}</strong><br>
                    <small style="color: #666;">${loc.address || 'Manzil ko\'rsatilmagan'}</small>
                `;

                resultItem.addEventListener("mouseover", function() {
                    this.style.backgroundColor = "#f5f5f5";
                });

                resultItem.addEventListener("mouseout", function() {
                    this.style.backgroundColor = "white";
                });

                resultItem.addEventListener("click", function() {
                    map.setCenter({
                        lat: loc.latitude,
                        lng: loc.longitude
                    });
                    map.setZoom(16);

                    const targetMarker = locationMarkers.find(m =>
                        m.location.id === loc.id
                    );

                    if (targetMarker) {
                        locationMarkers.forEach(m => {
                            if (m.infoWindow) {
                                m.infoWindow.close();
                            }
                        });

                        targetMarker.infoWindow.open(map, targetMarker.marker);
                    }

                    searchInput.value = loc.student?.name || loc.name || '';
                    resultsContainer.style.display = "none";
                });

                resultsContainer.appendChild(resultItem);
            });
        });

        document.addEventListener("click", function(e) {
            if (!searchContainer.contains(e.target)) {
                resultsContainer.style.display = "none";
            }
        });
    }

    function addLocateButton() {
        const controlDiv = document.createElement("div");
        const controlUI = document.createElement("button");

        controlUI.style.backgroundColor = "#fff";
        controlUI.style.border = "2px solid #fff";
        controlUI.style.borderRadius = "50%";
        controlUI.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
        controlUI.style.cursor = "pointer";
        controlUI.style.margin = "10px";
        controlUI.style.padding = "8px";
        controlUI.style.width = "44px";
        controlUI.style.height = "44px";
        controlUI.style.display = "flex";
        controlUI.style.alignItems = "center";
        controlUI.style.justifyContent = "center";
        controlUI.style.fontSize = "20px";
        controlUI.title = "Joyimni top";
        controlUI.innerHTML = "📍";

        controlDiv.appendChild(controlUI);
        map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);

        controlUI.addEventListener("click", () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map.setCenter(userLocation);
                        map.setZoom(15);
                        userMarker.setPosition(userLocation);
                        calculateDistances(userLocation);
                    },
                    () => {
                        alert("Joylashuvni olishga ruxsat berilmadi 😔");
                    }
                );
            } else {
                alert("Sizning brauzeringiz joylashuvni qo'llamaydi");
            }
        });
    }

    // Masofalarni hisoblash
    function calculateDistances(userLocation) {
        locationMarkers.forEach(marker => {
            const loc = marker.location;
            const distance = getDistance(
                userLocation.lat, 
                userLocation.lng,
                loc.latitude,
                loc.longitude
            );
            
            // InfoWindow ichidagi masofani yangilash
            const distanceElement = document.getElementById(`distance-${loc.id}`);
            if (distanceElement) {
                distanceElement.textContent = `${distance.toFixed(2)} km`;
            }
            
            marker.distance = distance;
        });
    }

    // Ikki nuqta orasidagi masofani hisoblash (Haversine formula)
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Yer radiusi kilometrda
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    window.initMap = initMap;
</script>

<style>
    .user-marker-label {
        background-color: #2196F3 !important;
        padding: 4px 8px !important;
        border-radius: 4px !important;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3) !important;
        border: 2px solid white !important;
    }

    .location-marker-label {
        background-color: #FFFFFF !important;
        padding: 3px 6px !important;
        border-radius: 3px !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3) !important;
        border: 1px solid currentColor !important;
    }

    #map {
        border-radius: 12px;
    }
</style>


<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap">
</script>