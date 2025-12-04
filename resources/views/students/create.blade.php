<x-app-layout>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow-sm sm:rounded-tl-md sm:rounded-tr-md">
                            <div class="grid grid-cols-6 gap-6">
                                <!-- Student ID -->
                                <div class="col-span-6 sm:col-span-4">
                                    <label class="block text-sm font-medium mb-1" for="student_id">
                                        Student ID
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="student_id" name="student_id"
                                        type="number" required>
                                </div>

                                <!-- First Name -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="first_name">
                                        Ism
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="first_name" name="first_name"
                                        type="text" required>
                                </div>

                                <!-- Last Name -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="last_name">
                                        Familiya
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="last_name" name="last_name"
                                        type="text" required>
                                </div>

                                <!-- Middle Name -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="middle_name">
                                        Otasining ismi
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="middle_name" name="middle_name"
                                        type="text">
                                </div>

                                <!-- Faculty -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="faculty">
                                        Fakultet
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="faculty" name="faculty"
                                        type="text" required>
                                </div>

                                <!-- Group -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="group">
                                        Guruh
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="group" name="group"
                                        type="text" required>
                                </div>

                                <!-- Phone -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="phone">
                                        Telefon
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="phone" name="phone"
                                        type="tel">
                                </div>

                                <!-- Coach -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="coach">
                                        Murabbiy
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="coach" name="coach"
                                        type="text">
                                </div>

                                <!-- Father -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="father">
                                        Otasi
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="father" name="father"
                                        type="text">
                                </div>

                                <!-- Father Phone -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="father_phone">
                                        Otasining telefoni
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="father_phone" name="father_phone"
                                        type="tel">
                                </div>

                                <!-- Mother -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="mather">
                                        Onasi
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="mather" name="mather"
                                        type="text">
                                </div>

                                <!-- Mother Phone -->
                                <div class="col-span-6 sm:col-span-3">
                                    <label class="block text-sm font-medium mb-1" for="mather_phone">
                                        Onasining telefoni
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="mather_phone" name="mather_phone"
                                        type="tel">
                                </div>

                                <!-- DOIMIY MANZIL (Permanent Address) Section -->
                                <div class="col-span-6">
                                    <h3 class="text-lg font-medium mb-4 mt-4">Doimiy yashash manzili</h3>
                                </div>

                                <!-- Province -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="province">
                                        Viloyat
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="province" name="province"
                                        type="text">
                                </div>

                                <!-- Region -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="region">
                                        Tuman
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="region" name="region"
                                        type="text">
                                </div>

                                <!-- Address -->
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block text-sm font-medium mb-1" for="address">
                                        Manzil
                                    </label>
                                    <input class="form-input w-full mt-1 block" id="address" name="address"
                                        type="text">
                                </div>

                                <!-- Permanent Address Map -->
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium mb-1">
                                        Xaritadan doimiy manzilni tanlang
                                    </label>
                                    <div id="map" style="width: 100%; height: 400px; border-radius: 6px;"></div>
                                </div>

                                <!-- Latitude (Hidden) -->
                                <input type="hidden" id="latitude" name="latitude">

                                <!-- Longitude (Hidden) -->
                                <input type="hidden" id="longitude" name="longitude">

                                <!-- YASHASH TURI (Living Type) Section -->
                                <div class="col-span-6">
                                    <h3 class="text-lg font-medium mb-4 mt-4">Hozirgi yashash joyi</h3>
                                </div>

                                <!-- Living Type Selection -->
                                <div class="col-span-6">
                                    <label class="block text-sm font-medium mb-1">
                                        Yashash turi
                                    </label>
                                    <select class="form-input w-full mt-1 block" id="living_type" name="living_type" onchange="toggleLivingType()">
                                        <option value="">Tanlang</option>
                                        <option value="dormitory">Yotoqxona</option>
                                        <option value="rent">Ijara</option>
                                    </select>
                                </div>

                                <!-- Dormitory Fields -->
                                <div id="dormitory_fields" style="display: none;" class="col-span-6 grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="dormitory">
                                            Yotoqxona
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="dormitory" name="dormitory"
                                            type="text">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="room">
                                            Xona raqami
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="room" name="room"
                                            type="number">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="privileged">
                                            Imtiyoz (%)
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="privileged" name="privileged"
                                            type="number" step="0.01" value="0">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="dorm_amount">
                                            Summa
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="dorm_amount" name="dorm_amount"
                                            type="number" step="0.01" value="0">
                                    </div>
                                </div>

                                <!-- Rent Fields -->
                                <div id="rent_fields" style="display: none;" class="col-span-6 grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-2">
                                        <label class="block text-sm font-medium mb-1" for="rent_province">
                                            Viloyat
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="rent_province" name="rent_province"
                                            type="text">
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label class="block text-sm font-medium mb-1" for="rent_region">
                                            Tuman
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="rent_region" name="rent_region"
                                            type="text">
                                    </div>

                                    <div class="col-span-6 sm:col-span-2">
                                        <label class="block text-sm font-medium mb-1" for="rent_address">
                                            Manzil
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="rent_address" name="rent_address"
                                            type="text">
                                    </div>

                                    <div class="col-span-6">
                                        <label class="block text-sm font-medium mb-1">
                                            Xaritadan ijara manzilini tanlang
                                        </label>
                                        <div id="rent_map" style="width: 100%; height: 400px; border-radius: 6px;"></div>
                                    </div>

                                    <input type="hidden" id="rent_latitude" name="rent_latitude">
                                    <input type="hidden" id="rent_longitude" name="rent_longitude">

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="rent_type">
                                            Uy egasi sizga kim
                                        </label>
                                        <select class="form-input w-full mt-1 block" id="rent_type" name="rent_type">
                                            <option value="owner">O'z uyi</option>
                                            <option value="relative">Qrindosh</option>
                                            <option value="rent">Begona</option>
                                        </select>

                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="owner_name">
                                            Egasining ismi
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="owner_name" name="owner_name"
                                            type="text">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="owner_phone">
                                            Egasining telefoni
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="owner_phone" name="owner_phone"
                                            type="tel">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="rent_type">
                                            Toifa turi
                                        </label>
                                        <select class="form-input w-full mt-1 block" id="rent_type" name="category">
                                            <option value="red">Qizil</option>
                                            <option value="yellow">Sariq</option>
                                            <option value="green">Yashil</option>
                                        </select>

                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="contract">
                                            Shartnoma
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="contract" name="contract"
                                            type="number" step="0.01" value="0">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label class="block text-sm font-medium mb-1" for="rent_amount">
                                            Summa
                                        </label>
                                        <input class="form-input w-full mt-1 block" id="rent_amount" name="rent_amount"
                                            type="number" step="0.01" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-700/20 text-right sm:px-6 shadow-sm sm:rounded-bl-md sm:rounded-br-md">
                            <button type="submit"
                                class="btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white whitespace-nowrap">
                                Saqlash
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hidden sm:block">
                <div class="py-8">
                    <div></div>
                </div>
            </div>
        </div>
    </div>

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAM-lcwS2aMgdJd5AMxE8N_1Lu7M3aHJUw&callback=initMap"></script>

    <script>
        let map, rentMap;
        let marker, rentMarker;

        function initMap() {
            // Default location (Tashkent)
            const defaultLocation = { lat: 41.2995, lng: 69.2401 };

            // Permanent address map
            map = new google.maps.Map(document.getElementById("map"), {
                center: defaultLocation,
                zoom: 12,
            });

            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
            });

            google.maps.event.addListener(map, 'click', function(event) {
                placeMarker(event.latLng, marker, map, 'latitude', 'longitude');
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                updatePosition(event.latLng, 'latitude', 'longitude');
            });

            // Rent map (initialize but keep hidden)
            rentMap = new google.maps.Map(document.getElementById("rent_map"), {
                center: defaultLocation,
                zoom: 12,
            });

            rentMarker = new google.maps.Marker({
                position: defaultLocation,
                map: rentMap,
                draggable: true,
            });

            google.maps.event.addListener(rentMap, 'click', function(event) {
                placeMarker(event.latLng, rentMarker, rentMap, 'rent_latitude', 'rent_longitude');
            });

            google.maps.event.addListener(rentMarker, 'dragend', function(event) {
                updatePosition(event.latLng, 'rent_latitude', 'rent_longitude');
            });
        }

        function placeMarker(location, markerObj, mapObj, latId, lngId) {
            markerObj.setPosition(location);
            mapObj.panTo(location);
            updatePosition(location, latId, lngId);
        }

        function updatePosition(location, latId, lngId) {
            document.getElementById(latId).value = location.lat();
            document.getElementById(lngId).value = location.lng();
        }

        function toggleLivingType() {
            const livingType = document.getElementById('living_type').value;
            const dormitoryFields = document.getElementById('dormitory_fields');
            const rentFields = document.getElementById('rent_fields');

            if (livingType === 'dormitory') {
                dormitoryFields.style.display = 'contents';
                rentFields.style.display = 'none';
            } else if (livingType === 'rent') {
                dormitoryFields.style.display = 'none';
                rentFields.style.display = 'contents';
                // Resize rent map when it becomes visible
                setTimeout(function() {
                    google.maps.event.trigger(rentMap, 'resize');
                    rentMap.setCenter(rentMarker.getPosition());
                }, 100);
            } else {
                dormitoryFields.style.display = 'none';
                rentFields.style.display = 'none';
            }
        }
    </script>
</x-app-layout>