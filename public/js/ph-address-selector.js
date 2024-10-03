/**
 * __________________________________________________________________
 *
 * Phillipine Address Selector
 * __________________________________________________________________
 *
 * MIT License
 *
 * Copyright (c) 2020 Wilfred V. Pine
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package Phillipine Address Selector
 * @author Wilfred V. Pine <only.master.red@gmail.com>
 * @copyright Copyright 2020 (https://dev.confired.com)
 * @link https://github.com/redmalmon/philippine-address-selector
 * @license https://opensource.org/licenses/MIT MIT License
 */

function phAddress({regionSelector, provinceSelector, citySelector, brgySelector, regionCode = 0,
                       provinceCode = 0,
                       cityCode = 0,
                       brgyCode = 0}) {

    const region = document.querySelector(regionSelector);
    const province = document.querySelector(provinceSelector);
    const city = document.querySelector(citySelector);
    const brgy = document.querySelector(brgySelector);

    async function updateRegion() {
        try {

            const response = await fetch('/api/regions')

            if (!response.ok) {
                throw new Error('Cant find region');
            }

            region.innerHTML = null;

            const regions = await response.json();

            const selected = regionCode === regions.region_code;

            regions.forEach(region => {
                addSelection(regionSelector, region.region_code, region.region_name, selected);
            })

        } catch (error) {
            console.error(error.message);
        }
    }

    async function updateProvince(regionCode) {
        try {

            const response = await fetch(`/api/provinces/${regionCode}`)

            if (!response.ok) {
                throw new Error('Cant find provinces');
            }

            province.innerHTML = null;

            const provinces = await response.json();

            const selected = provinceCode === provinces.province_code;

            provinces.forEach(province => {
                addSelection(provinceSelector, province.province_code, province.province_name, selected);
            })

        } catch (error) {
            console.error(error.message);
        }
    }

    async function updateCity(provinceCode) {
        try {

            const response = await fetch(`/api/cities/${provinceCode}`)

            if (!response.ok) {
                throw new Error('Cant find cities');
            }

            city.innerHTML = null;

            const cities = await response.json();

            const selected = cityCode === cities.city_code;

            cities.forEach(city => {
                addSelection(citySelector, city.city_code, city.city_name, selected);
            })

        } catch (error) {
            console.error(error.message);
        }
    }

    async function updateBarangay(cityCode) {
        try {

            const response = await fetch(`/api/barangays/${cityCode}`)

            if (!response.ok) {
                throw new Error('Cant find barangay');
            }

            city.innerHTML = null;

            const cities = await response.json();

            const selected = cityCode === cities.city_code;

            cities.forEach(city => {
                addSelection(citySelector, city.city_code, city.city_name, selected);
            })

        } catch (error) {
            console.error(error.message);
        }
    }

    function addSelection(selector, value, name, selected = false) {
        const selection = document.querySelector(selector);
        const option = document.createElement('option');
        option.innerHTML = name;
        option.value = value;

        if (selected) {
            selection.value = value;
        }

        selection.appendChild(option);
    }

    region.addEventListener('change', async () => {
        updateProvince(region.value);
        city.innerHTML = null;
        brgy.innerHTML = null;
    });

    province.addEventListener('change', async () => {
        updateCity(province.value);
        brgy.innerHTML = null;
    });

    city.addEventListener('change', async () => {
        updateBarangay(city.value);
    });

    updateRegion();
}

// var my_handlers = {
//  fill province
//     fill_provinces: function () {
//
//         console.log('filling provinces');
//
//         //selected region
//         // var region_code = $(this).val();
//
//         // set selected text to input
//         var region_text = $(this).find("option:selected").text();
//         let region_input = $('#region-text');
//         region_input.val(region_text);
//         //clear province & city & barangay input
//         $('#province-text').val('');
//         $('#city-text').val('');
//         $('#barangay-text').val('');
//
//         //province
//         let dropdown = $('#province');
//         dropdown.empty();
//         dropdown.append('<option selected="true" disabled>Choose State/Province</option>');
//         dropdown.prop('selectedIndex', 0);
//
//         //city
//         let city = $('#city');
//         city.empty();
//         city.append('<option selected="true" disabled></option>');
//         city.prop('selectedIndex', 0);
//
//         //barangay
//         let barangay = $('#barangay');
//         barangay.empty();
//         barangay.append('<option selected="true" disabled></option>');
//         barangay.prop('selectedIndex', 0);
//
//         // filter & fill
//         var url = '{{base_path()}}/public/resources/ph-json/province.json';
//         $.getJSON(url, function (data) {
//             var result = data.filter(function (value) {
//                 // return value.region_code == region_code;
//             });
//
//             result.sort(function (a, b) {
//                 // return a.province_name.localeCompare(b.province_name);
//             });
//
//             $.each(result, function (key, entry) {
//                 dropdown.append($('<option></option>').attr('value', entry.province_code).text(entry.province_name));
//             })
//
//         });
//     },
//     // fill city
//     fill_cities: function () {
//         //selected province
//         var province_code = $(this).val();
//
//         // set selected text to input
//         var province_text = $(this).find("option:selected").text();
//         let province_input = $('#province-text');
//         province_input.val(province_text);
//         //clear city & barangay input
//         $('#city-text').val('');
//         $('#barangay-text').val('');
//
//         //city
//         let dropdown = $('#city');
//         dropdown.empty();
//         dropdown.append('<option selected="true" disabled>Choose city/municipality</option>');
//         dropdown.prop('selectedIndex', 0);
//
//         //barangay
//         let barangay = $('#barangay');
//         barangay.empty();
//         barangay.append('<option selected="true" disabled></option>');
//         barangay.prop('selectedIndex', 0);
//
//         // filter & fill
//         var url = '{{base_path()}}/public/resources/ph-json/city.json';
//         $.getJSON(url, function (data) {
//             var result = data.filter(function (value) {
//                 return value.province_code == province_code;
//             });
//
//             result.sort(function (a, b) {
//                 return a.city_name.localeCompare(b.city_name);
//             });
//
//             $.each(result, function (key, entry) {
//                 dropdown.append($('<option></option>').attr('value', entry.city_code).text(entry.city_name));
//             })
//
//         });
//     },
//     // fill barangay
//     fill_barangays: function () {
//         // selected barangay
//         var city_code = $(this).val();
//
//         // set selected text to input
//         var city_text = $(this).find("option:selected").text();
//         let city_input = $('#city-text');
//         city_input.val(city_text);
//         //clear barangay input
//         $('#barangay-text').val('');
//
//         // barangay
//         let dropdown = $('#barangay');
//         dropdown.empty();
//         dropdown.append('<option selected="true" disabled>Choose barangay</option>');
//         dropdown.prop('selectedIndex', 0);
//
//         // filter & Fill
//         var url = '{{base_path()}}/public/resources/ph-json/barangay.json';
//         $.getJSON(url, function (data) {
//             var result = data.filter(function (value) {
//                 return value.city_code == city_code;
//             });
//
//             result.sort(function (a, b) {
//                 return a.brgy_name.localeCompare(b.brgy_name);
//             });
//
//             $.each(result, function (key, entry) {
//                 dropdown.append($('<option></option>').attr('value', entry.brgy_code).text(entry.brgy_name));
//             })
//
//         });
//     },
//
//     onchange_barangay: function () {
//         // set selected text to input
//         var barangay_text = $(this).find("option:selected").text();
//         let barangay_input = $('#barangay-text');
//         barangay_input.val(barangay_text);
//     },
//
// };
//
//
// $(function () {
//     // events
//     $('#region').on('change', my_handlers.fill_provinces);
//     $('#province').on('change', my_handlers.fill_cities);
//     $('#city').on('change', my_handlers.fill_barangays);
//     $('#barangay').on('change', my_handlers.onchange_barangay);
//
//     // load region
//     let dropdown = $('#region');
//     dropdown.empty();
//     dropdown.append('<option selected="true" disabled>Choose Region</option>');
//     dropdown.prop('selectedIndex', 0);
//     const url = '{{base_path()}}/public/resources/ph-json/region.json';
//     // Populate dropdown with list of regions
//     $.getJSON(url, function (data) {
//         $.each(data, function (key, entry) {
//             dropdown.append($('<option></option>').attr('value', entry.region_code).text(entry.region_name));
//         })
//     });
// });
