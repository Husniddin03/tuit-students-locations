<style>
    .map-wrapper {
        width: 100%;
        height: 100vh;
        position: relative;
    }

    #map {
        width: 100%;
        height: 100%;
    }

    .search-box {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        width: 320px;
        z-index: 1000;
    }

    .search-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
    }

    .search-results {
        max-height: 250px;
        overflow-y: auto;
        margin-top: 8px;
        display: none;
        background: white;
        border-radius: 4px;
        border: 1px solid #ddd;
    }

    .result-item {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }

    .result-item:hover {
        background: #f5f5f5;
    }

    .locate-btn {
        position: absolute;
        right: 10px;
        bottom: 10px;
        background: white;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        z-index: 1000;
    }

    .locate-btn:hover {
        background: #f5f5f5;
    }

    .info-content {
        padding: 10px;
        max-width: 250px;
    }

    .info-title {
        margin: 0 0 8px 0;
        font-size: 16px;
        font-weight: bold;
        color: #FF4444;
    }

    .info-distance {
        margin: 0 0 5px 0;
        font-size: 13px;
        color: #1976d2;
        font-weight: 500;
    }

    .info-address {
        margin: 0 0 8px 0;
        font-size: 12px;
        color: #666;
    }

    .info-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #4285f4;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        margin-right: 5px;
        margin-top: 5px;
    }

    .info-btn:hover {
        background-color: #3367d6;
    }
</style>
<div class="flex flex-col col-span-full sm:col-span-12 bg-white dark:bg-gray-800 shadow-lg rounded-xl">

    <div class="map-wrapper">
        <div id="map"></div>

        <div class="search-box">
            <input type="text" class="search-input" placeholder="Ijara joylashuvini qidiring..." id="searchInput">
            <div class="search-results" id="searchResults"></div>
        </div>

        <button class="locate-btn" id="locateBtn" title="Joyimni top">📍</button>
    </div>
</div>



<script>
    // Demo data - bu yerga backend dan ma'lumot keladi
    const rentData = @json($rent);

    let map, userMarker, infoWindows = [];
    const markers = [];

    // Xaritani ishga tushirish
    function initMap() {
        const defaultCenter = {
            lat: 41.2995,
            lng: 69.2401
        };

        // Xaritani yaratish (optimizatsiyalangan sozlamalar)
        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultCenter,
            zoom: 12,
            styles: [{
                featureType: "poi",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }],
            gestureHandling: 'greedy',
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: true
        });

        // Foydalanuvchi markeri
        userMarker = new google.maps.Marker({
            map: map,
            position: defaultCenter,
            draggable: true,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                scaledSize: new google.maps.Size(40, 40)
            },
            title: "Sizning joylashuvingiz",
            optimized: true
        });

        // Markerlarni qo'shish (optimizatsiyalangan)
        addMarkersOptimized();

        // Event listenerlar
        setupEventListeners();

        // Foydalanuvchi joylashuvini olish
        getUserLocation();
    }

    // Markerlarni tezkor qo'shish
    function addMarkersOptimized() {
        const bounds = new google.maps.LatLngBounds();

        rentData.forEach(location => {
            if (!location.latitude || !location.longitude) return;

            const position = {
                lat: parseFloat(location.latitude),
                lng: parseFloat(location.longitude)
            };

            const marker = new google.maps.Marker({
                map: map,
                position: position,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                    scaledSize: new google.maps.Size(32, 32)
                },
                title: location.student?.first_name || 'Ijara',
                optimized: true // Muhim: markerlarni optimizatsiya qilish
            });

            // InfoWindow yaratish (lekin darhol ochmaslik)
            const infoWindow = new google.maps.InfoWindow({
                content: createInfoContent(location)
            });

            marker.addListener("click", () => {
                closeAllInfoWindows();
                infoWindow.open(map, marker);
                updateDistance(location, userMarker.getPosition());
            });

            markers.push({
                marker,
                infoWindow,
                location
            });
            bounds.extend(position);
        });

        bounds.extend(userMarker.getPosition());
    }

    // InfoWindow kontenti
    function createInfoContent(location) {
        return `
                <div class="info-content">
                    <h3 class="info-title">🏠 ${location.student?.first_name || 'Ijara'}</h3>
                    <p class="info-distance">📍 Masofa: <span id="dist-${location.id}">Hisoblanmoqda...</span></p>
                    <p class="info-address">${location.address || 'Manzil ko\'rsatilmagan'}</p>
                    ${location.student ? `<p class="info-address">Talaba: <strong>${location.student.first_name}</strong></p>` : ''}
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${location.latitude},${location.longitude}" 
                       target="_blank" class="info-btn">Yo'nalish</a>
                    <a href="/students/${location.student?.id || ''}" class="info-btn">Ma'lumot</a>
                </div>
            `;
    }

    // Barcha InfoWindowlarni yopish
    function closeAllInfoWindows() {
        markers.forEach(m => m.infoWindow.close());
    }

    // Event listenerlar
    function setupEventListeners() {
        // Xaritaga bosish
        map.addListener("click", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            userMarker.setPosition(pos);
            calculateAllDistances(pos);
        });

        // Markerni sudrab borish
        userMarker.addListener("dragend", (e) => {
            const pos = {
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            };
            calculateAllDistances(pos);
        });

        // Qidiruv
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            searchResults.innerHTML = '';

            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            const filtered = rentData.filter(loc => {
                const name = loc.student?.first_name || '';
                const address = loc.address || '';
                return name.toLowerCase().includes(query) || address.toLowerCase().includes(query);
            });

            if (filtered.length === 0) {
                searchResults.innerHTML = '<div class="result-item">Natija topilmadi</div>';
                searchResults.style.display = 'block';
                return;
            }

            searchResults.style.display = 'block';
            filtered.forEach(loc => {
                const div = document.createElement('div');
                div.className = 'result-item';
                div.innerHTML = `<strong>🏠 ${loc.student?.first_name || 'Ijara'}</strong><br>
                                     <small>${loc.address || 'Manzil ko\'rsatilmagan'}</small>`;
                div.addEventListener('click', () => {
                    map.setCenter({
                        lat: loc.latitude,
                        lng: loc.longitude
                    });
                    map.setZoom(16);
                    const targetMarker = markers.find(m => m.location.id === loc.id);
                    if (targetMarker) {
                        closeAllInfoWindows();
                        targetMarker.infoWindow.open(map, targetMarker.marker);
                    }
                    searchResults.style.display = 'none';
                    searchInput.value = '';
                });
                searchResults.appendChild(div);
            });
        });

        // Qidiruv tashqarisiga bosish
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.search-box')) {
                searchResults.style.display = 'none';
            }
        });

        // Joyimni top tugmasi
        document.getElementById('locateBtn').addEventListener('click', getUserLocation);
    }

    // Foydalanuvchi joylashuvini olish
    function getUserLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(pos);
                    map.setZoom(15);
                    userMarker.setPosition(pos);
                    calculateAllDistances(pos);
                },
                () => alert("Joylashuvni olishga ruxsat berilmadi 😔")
            );
        }
    }

    // Barcha masofalarni hisoblash
    function calculateAllDistances(userPos) {
        markers.forEach(m => {
            updateDistance(m.location, userPos);
        });
    }

    // Bitta masofani yangilash
    function updateDistance(location, userPos) {
        const dist = getDistance(userPos.lat, userPos.lng, location.latitude, location.longitude);
        const elem = document.getElementById(`dist-${location.id}`);
        if (elem) {
            elem.textContent = `${dist.toFixed(2)} km`;
        }
    }

    // Masofa hisoblash (Haversine)
    function getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    window.initMap = initMap;
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>
