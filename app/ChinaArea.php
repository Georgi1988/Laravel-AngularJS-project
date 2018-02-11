<?php

namespace App;

use Doctrine\Common\Cache\ChainCache;
use Illuminate\Database\Eloquent\Model;

define('CNAREA_LEVEL_PROVINCE', 0);
define('CNAREA_LEVEL_CITY',     1);
define('CNAREA_LEVEL_COUNTRY',  2);
define('CNAREA_LEVEL_TOWN',     3);
define('CNAREA_LEVEL_VILLAGE',  4);

class ChinaArea extends Model
{
    public static function getArea($id) {
        return ChinaArea::find($id);
    }
    public static function getAreaByName($name) {
        return ChinaArea::where('short_name', $name)->first();
    }

    public static function getProvinces() {
        return ChinaArea::where('level', CNAREA_LEVEL_PROVINCE)->get();
    }

    public static function getCities($province_id) {
        $province = ChinaArea::where('id', $province_id)->first();

        if ($province->level == CNAREA_LEVEL_PROVINCE) {
            return ChinaArea::where('parent_id', $province_id)
                ->where('level', CNAREA_LEVEL_CITY)
                ->get();
        }

        return null;
    }

    public static function getCountries($city_id) {
        $city = ChinaArea::where('id', $city_id)->first();

        if ($city->level == CNAREA_LEVEL_CITY) {
            return ChinaArea::where('parent_id', $city_id)
                ->where('level', CNAREA_LEVEL_COUNTRY)
                ->get();
        }

        return null;
    }

    public static function getTowns($country_id) {
        $country = ChinaArea::where('id', $country_id)->first();

        if ($country->level == CNAREA_LEVEL_COUNTRY) {
            return ChinaArea::where('parent_id', $country_id)
                ->where('level', CNAREA_LEVEL_TOWN)
                ->get();
        }

        return null;
    }

    public static function isProvince($id)
    {
        return ChinaArea::where('id', $id)->where('level', CNAREA_LEVEL_PROVINCE)->first() != null;
    }

    public static function isAreaInOtherArea($id, $parent_id)
    {
        return ChinaArea::where('id', $id)->where('parent_id', $parent_id)->first() != null;
    }

    public static function getAreas($province_id = null, $city_id = null, $country_id = null, $town_id = null) {
        $provinces = ChinaArea::getProvinces();

        $provinceID = ($province_id != null && ChinaArea::isProvince($province_id)) ? $province_id : 1;

        $cityID = $city_id;
        $cities = ChinaArea::getCities($provinceID);

        if ($cityID == null || isAreaInOtherArea($cityID, $provinceID) == false) {
            $cityID = ($cities != null && sizeof($cities) != 0) ? $cities[0]->id : 0;
        }

        $countryID = $country_id;
        $countries = ($cityID != 0) ? ChinaArea::getCountries($cityID) : null;

        if ($countryID == null || $cityID == 0 || isAreaInOtherArea($countryID, $cityID) == false) {
            $countryID = ($countries != null && sizeof($countries) != 0) ? $countries[0]->id : 0;
        }

        $townID = $town_id;
        $towns = ($countryID != 0) ? ChinaArea::getTowns($countryID) : null;

        if ($townID == null || $countryID == 0 || isAreaInOtherArea($townID, $countryID) == false) {
            $townID = ($towns != null && sizeof($towns) != 0) ? $towns[0]->id : 0;
        }

        return array(
            'province' => array('index' => $provinceID, 'list' => $provinces),
                'city' => array('index' => $cityID,     'list' => $cities),
             'country' => array('index' => $countryID,  'list' => $countries),
                'town' => array('index' => $townID,     'list' => $towns),
        );
    }
}
