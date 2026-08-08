/**
 * Wilayah Indonesia Autocomplete & Searchable Cascading Datalist
 * Source: EMSIFA Wilayah Indonesia API (Kemendagri)
 */

(function () {
    const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    function toTitleCase(str) {
        if (!str) return '';
        return str.toLowerCase().replace(/(?:^|\s|\/|-)\w/g, function (match) {
            return match.toUpperCase();
        });
    }

    let provincesData = null;
    let kabDataMap = {}; // provId -> data
    let kecDataMap = {}; // kabId -> data
    let desaDataMap = {}; // kecId -> data

    window.initSearchableWilayah = function (config) {
        const inputProv = document.querySelector(config.provinsi);
        const listProv = document.querySelector(config.listProvinsi);
        const inputKab = document.querySelector(config.kabupaten);
        const listKab = document.querySelector(config.listKabupaten);
        const inputKec = document.querySelector(config.kecamatan);
        const listKec = document.querySelector(config.listKecamatan);
        const inputDesa = document.querySelector(config.desa);
        const listDesa = document.querySelector(config.listDesa);

        if (!inputProv || !inputKab || !inputKec || !inputDesa) return;

        function populateDatalist(datalistElem, items) {
            if (!datalistElem) return;
            datalistElem.innerHTML = '';
            items.forEach(item => {
                const opt = document.createElement('option');
                const titleName = toTitleCase(item.name);
                opt.value = titleName;
                opt.dataset.id = item.id;
                datalistElem.appendChild(opt);
            });
        }

        function findItemByName(items, name) {
            if (!items || !name) return null;
            const search = name.trim().toLowerCase();
            return items.find(item => 
                toTitleCase(item.name).toLowerCase() === search || 
                item.name.toLowerCase() === search
            );
        }

        // 1. Load Provinces
        function loadProvinces() {
            const handleData = (data) => {
                provincesData = data;
                populateDatalist(listProv, data);

                // Jika ada nilai awal (edit form / old input)
                if (inputProv.value) {
                    const match = findItemByName(data, inputProv.value);
                    if (match) {
                        loadKabupaten(match.id);
                    }
                }
            };

            if (provincesData) {
                handleData(provincesData);
            } else {
                fetch(`${API_BASE}/provinces.json`)
                    .then(r => r.json())
                    .then(handleData)
                    .catch(err => console.error('Gagal memuat provinsi:', err));
            }
        }

        // 2. Load Kabupaten / Kota
        function loadKabupaten(provId) {
            if (!provId) return;

            const handleData = (data) => {
                kabDataMap[provId] = data;
                populateDatalist(listKab, data);

                if (inputKab.value) {
                    const match = findItemByName(data, inputKab.value);
                    if (match) {
                        loadKecamatan(match.id);
                    }
                }
            };

            if (kabDataMap[provId]) {
                handleData(kabDataMap[provId]);
            } else {
                fetch(`${API_BASE}/regencies/${provId}.json`)
                    .then(r => r.json())
                    .then(handleData)
                    .catch(err => console.error('Gagal memuat kab/kota:', err));
            }
        }

        // 3. Load Kecamatan
        function loadKecamatan(kabId) {
            if (!kabId) return;

            const handleData = (data) => {
                kecDataMap[kabId] = data;
                populateDatalist(listKec, data);

                if (inputKec.value) {
                    const match = findItemByName(data, inputKec.value);
                    if (match) {
                        loadDesa(match.id);
                    }
                }
            };

            if (kecDataMap[kabId]) {
                handleData(kecDataMap[kabId]);
            } else {
                fetch(`${API_BASE}/districts/${kabId}.json`)
                    .then(r => r.json())
                    .then(handleData)
                    .catch(err => console.error('Gagal memuat kecamatan:', err));
            }
        }

        // 4. Load Desa
        function loadDesa(kecId) {
            if (!kecId) return;

            const handleData = (data) => {
                desaDataMap[kecId] = data;
                populateDatalist(listDesa, data);
            };

            if (desaDataMap[kecId]) {
                handleData(desaDataMap[kecId]);
            } else {
                fetch(`${API_BASE}/villages/${kecId}.json`)
                    .then(r => r.json())
                    .then(handleData)
                    .catch(err => console.error('Gagal memuat desa:', err));
            }
        }

        // Event Listeners for real-time typing / selection
        inputProv.addEventListener('input', function () {
            if (!provincesData) return;
            const match = findItemByName(provincesData, this.value);
            if (match) {
                loadKabupaten(match.id);
            }
        });

        inputKab.addEventListener('input', function () {
            // Cari dari data kabupaten prov saat ini
            const provMatch = provincesData ? findItemByName(provincesData, inputProv.value) : null;
            const currentKabData = provMatch && kabDataMap[provMatch.id] ? kabDataMap[provMatch.id] : [];
            const match = findItemByName(currentKabData, this.value);
            if (match) {
                loadKecamatan(match.id);
            }
        });

        inputKec.addEventListener('input', function () {
            const provMatch = provincesData ? findItemByName(provincesData, inputProv.value) : null;
            const currentKabData = provMatch && kabDataMap[provMatch.id] ? kabDataMap[provMatch.id] : [];
            const kabMatch = findItemByName(currentKabData, inputKab.value);
            const currentKecData = kabMatch && kecDataMap[kabMatch.id] ? kecDataMap[kabMatch.id] : [];
            const match = findItemByName(currentKecData, this.value);
            if (match) {
                loadDesa(match.id);
            }
        });

        // Focus listeners to reload options if user clicks or focuses
        inputProv.addEventListener('focus', function () {
            if (!provincesData) loadProvinces();
        });

        inputKab.addEventListener('focus', function () {
            if (provincesData) {
                const match = findItemByName(provincesData, inputProv.value);
                if (match && (!kabDataMap[match.id] || listKab.children.length === 0)) {
                    loadKabupaten(match.id);
                }
            }
        });

        inputKec.addEventListener('focus', function () {
            if (provincesData) {
                const provMatch = findItemByName(provincesData, inputProv.value);
                if (provMatch && kabDataMap[provMatch.id]) {
                    const kabMatch = findItemByName(kabDataMap[provMatch.id], inputKab.value);
                    if (kabMatch && (!kecDataMap[kabMatch.id] || listKec.children.length === 0)) {
                        loadKecamatan(kabMatch.id);
                    }
                }
            }
        });

        inputDesa.addEventListener('focus', function () {
            if (provincesData) {
                const provMatch = findItemByName(provincesData, inputProv.value);
                if (provMatch && kabDataMap[provMatch.id]) {
                    const kabMatch = findItemByName(kabDataMap[provMatch.id], inputKab.value);
                    if (kabMatch && kecDataMap[kabMatch.id]) {
                        const kecMatch = findItemByName(kecDataMap[kabMatch.id], inputKec.value);
                        if (kecMatch && (!desaDataMap[kecMatch.id] || listDesa.children.length === 0)) {
                            loadDesa(kecMatch.id);
                        }
                    }
                }
            }
        });

        // Initialize loading
        loadProvinces();
    };
})();
