const myHandlers = {

    provinceURL: 'ph-json/province.json',

    clear: function (selector, form = null) {
        if(form){
            form.querySelector(selector).innerHTML = '';
        }else{
            document.querySelector(selector).innerHTML = '';
        }
    },

    initial: function (selector, title) {
        const selection = document.querySelector(selector);
        selection.innerHTML = `<option selected="true" disabled>${title}</option>`;
    },

    addOptions: function (selector, entries) {

        const selection = document.querySelector(selector);

        entries.forEach(entry => {
            const option = document.createElement('option');
            option.value = entry.code;
            option.textContent = entry.name;
            selection.appendChild(option);
        });
    },

    fillProvinces: function () {

        const regionCode = this.querySelector('.province').value;

        myHandlers.clear('province-text');
        myHandlers.clear('city-text');
        myHandlers.clear('barangay-text');

        // this.initial('province', 'Choose State/Province')
        // this.initial('city', 'Choose State/Province')
        // this.initial('barangay', 'Choose State/Province')

        fetch(this.provinceURL)
            .then(response => response.json())
            .then(data => {

                const provinces = data.filter(value => value.region_code === regionCode);
                provinces.sort((a, b) => a.province_name.localeCompare(b.province_name));

                this.addOptions('province', provinces.map(province => {
                    return {
                        name: province.province_name,
                        code: province.province_code,
                    }
                }));
            });
    },

//         ,
//
// // Fill city
//         fillCities: function () {
//             // Selected province
//             var provinceCode = this.value;
//
//             // Set selected text to input
//             var provinceText = this.options[this.selectedIndex].text;
//             document.getElementById('province-text').value = provinceText;
//
//             // Clear city and barangay input
//             document.getElementById('city-text').value = '';
//             document.getElementById('barangay-text').value = '';
//
//             // City dropdown
//             var cityDropdown = document.getElementById('city');
//             cityDropdown.innerHTML = '<option selected="true" disabled>Choose city/municipality</option>';
//
//             // Barangay dropdown
//             var barangayDropdown = document.getElementById('barangay');
//             barangayDropdown.innerHTML = '<option selected="true" disabled></option>';
//
//             // Filter & fill cities
//             var url = 'ph-json/city.json';
//             fetch(url)
//                 .then(response => response.json())
//                 .then(data => {
//                     var result = data.filter(value => value.province_code === provinceCode);
//                     result.sort((a, b) => a.city_name.localeCompare(b.city_name));
//
//                     result.forEach(entry => {
//                         var option = document.createElement('option');
//                         option.value = entry.city_code;
//                         option.textContent = entry.city_name;
//                         cityDropdown.appendChild(option);
//                     });
//                 });
//         }
//         ,
//
// // Fill barangay
//         fillBarangays: function () {
//             // Selected barangay
//             var cityCode = this.value;
//
//             // Set selected text to input
//             var cityText = this.options[this.selectedIndex].text;
//             document.getElementById('city-text').value = cityText;
//
//             // Clear barangay input
//             document.getElementById('barangay-text').value = '';
//
//             // Barangay dropdown
//             var barangayDropdown = document.getElementById('barangay');
//             barangayDropdown.innerHTML = '<option selected="true" disabled>Choose barangay</option>';
//
//             // Filter & fill barangays
//             var url = 'ph-json/barangay.json';
//             fetch(url)
//                 .then(response => response.json())
//                 .then(data => {
//                     var result = data.filter(value => value.city_code === cityCode);
//                     result.sort((a, b) => a.brgy_name.localeCompare(b.brgy_name));
//
//                     result.forEach(entry => {
//                         var option = document.createElement('option');
//                         option.value = entry.brgy_code;
//                         option.textContent = entry.brgy_name;
//                         barangayDropdown.appendChild(option);
//                     });
//                 });
//         }
//         ,
//
//         onchangeBarangay: function () {
//             // Set selected text to input
//             var barangayText = this.options[this.selectedIndex].text;
//             document.getElementById('barangay-text').value = barangayText;
//         }
}


// Initialize event listeners and load regions on page load
document.addEventListener("DOMContentLoaded", function () {
    // Events
    document.getElementById('region').addEventListener('change', myHandlers.fillProvinces.bind(document.getElementById('region')));
    document.getElementById('province').addEventListener('change', myHandlers.fillCities.bind(document.getElementById('province')));
    document.getElementById('city').addEventListener('change', myHandlers.fillBarangays.bind(document.getElementById('city')));
    document.getElementById('barangay').addEventListener('change', myHandlers.onchangeBarangay.bind(document.getElementById('barangay')));

    // Load regions
    let regionDropdown = document.getElementById('region');
    regionDropdown.innerHTML = '<option selected="true" disabled>Choose Region</option>';

    const url = 'ph-json/region.json';

    fetch(url)
        .then(response => response.json())
        .then(data => {
            data.forEach(entry => {
                var option = document.createElement('option');
                option.value = entry.region_code;
                option.textContent = entry.region_name;
                regionDropdown.appendChild(option);
            });
        });
});
