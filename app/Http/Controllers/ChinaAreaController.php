<?php

namespace App\Http\Controllers;

use App\ChinaArea;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChinaAreaController extends Controller
{
    public static function getArea($id) {
        $area = ChinaArea::getArea($id);

        if ($area != null) {
            return json_encode(array('status' => true, 'result' => array('data' => $area)));
        }

        return json_encode(array('status' => false, 'error_message' => 'There is no area of China.'));
    }

    public static function getAreaIndexByName() {
        $area = ChinaArea::getAreaByName($_REQUEST['name']);

        if ($area != null) {
            return json_encode(array('status' => true, 'result' => array('index' => $area->id)));
        }

        return json_encode(array('status' => false, 'error_message' => 'There is no area of China.'));
    }

    public static function getProvinceNames() {
        $provinces = ChinaArea::getProvinces();

        if ($provinces != null && sizeof($provinces) != 0) {
            $results = array();

            foreach ($provinces as $province) {
                $results[] = array('value' => $province->id, 'name' => $province->short_name);
            }

            return json_encode(array('status' => true, 'result' => array('provinces' => $results)));
        }

        return json_encode(array('status' => false, 'error_message' => 'There is no provinces on database'));
    }

    public static function getCityNames($province_id) {
        $cities = ChinaArea::GetCities($province_id);

        if ($cities != null && sizeof($cities) != 0) {
            $results = array();

            foreach ($cities as $city) {
                $results[] = array('value' => $city->id, 'name' => $city->short_name);
            }

            return json_encode(array('status' => true, 'result' => array('cities' => $results)));
        }

        return json_encode(array('status' => false, 'error_message' => 'This is not province ID or there are no cities under this province.'));
    }

    public static function getCountryNames($city_id) {
        $countries = ChinaArea::getCountries($city_id);

        if ($countries != null && sizeof($countries) != 0) {
            $results = array();

            foreach ($countries as $country) {
                $results[] = array('value' => $country->id, 'name' => $country->short_name);
            }

            return json_encode(array('status' => true, 'result' => array('countries' => $results)));
        }

        return json_encode(array('status' => false, 'error_message' => 'This is not city ID or there are no countries under this city.'));
    }

    public static function getTownNames($country_id) {
        $towns = ChinaArea::getTowns($country_id);

        if ($towns != null && sizeof($towns) != 0) {
            $results = array();

            foreach ($towns as $town) {
                $results[] = array('value' => $town->id, 'name' => $town->short_name);
            }

            return json_encode(array('status' => true, 'result' => array('towns' => $results)));
        }

        return json_encode(array('status' => false, 'error_message' => 'This is not country ID or There are no townes under this country.'));
    }

    public static function getInitialAreas($province_id = null, $city_id = null, $country_id = null, $town_id = null) {
        $result = json_encode(ChinaArea::getAreas($province_id, $city_id, $country_id, $town_id));

        $provinces = array();
        $cities = array();
        $countries = array();
        $towns = array();

        foreach ($result['province']['list'] as $province) {
            $provinces[] = array('value' => $province->id, 'name' => $province->short_name);
        }

        foreach ($result['city']['list'] as $city) {
            $cities[] = array('value' => $city->id, 'name' => $city->short_name);
        }

        foreach ($result['country']['list'] as $country) {
            $countries[] = array('value' => $country->id, 'name' => $country->short_name);
        }

        foreach ($result['town']['list'] as $town) {
            $towns[] = array('value' => $town->id, 'name' => $town->short_name);
        }

        return json_encoder(array(
            'province' => array('index' => $result['province']['index'], 'list' => $provinces),
                'city' => array('index' => $result['city']['index'],     'list' => $cities),
             'country' => array('index' => $result['country']['index'],  'list' => $countries),
                'town' => array('index' => $result['town']['index'],     'list' => $towns))
        );
    }
}
