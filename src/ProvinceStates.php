<?php

namespace LongTailVentures;

class ProvinceStates
{
    public static function getProvinces()
    {
        return array(
            'AB' => 'Alberta',
            'BC' => 'British Columbia',
            'MB' => 'Manitoba',
            'NB' => 'New Brunswick',
            'NL' => 'Newfoundland and Labrador',
            'NS' => 'Nova Scotia',
            'NT' => 'Northwest Territories',
            'NU' => 'Nunavut',
            'ON' => 'Ontario',
            'PE' => 'Prince Edward Island',
            'QC' => 'Quebec',
            'SK' => 'Saskatchewan',
            'YT' => 'Yukon'
        );
    }


    public static function getStates()
    {
        return array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'DC' => 'Washington D.C.',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming'
        );
    }


    public static function getProvinceStates($isCanada = false)
    {
        return $isCanada
            ? array_merge(self::getProvinces(), self::getStates())
            : array_merge(self::getStates(), self::getProvinces());
    }


    public static function getProvinceState($provinceStateAbbreviation)
    {
        $provinceStateAbbreviation = strtoupper($provinceStateAbbreviation);
        $provinceStates = self::getProvinceStates();

        $provinceState = isset($provinceStates[$provinceStateAbbreviation])
            ? $provinceStates[$provinceStateAbbreviation]
            : null;

        return $provinceState;
    }


    public static function getProvinceStateAbbreviation($name)
    {
        $provinceStates = self::getProvinceStates();
        $provinceStateAbbreviation = array_search(
            strtolower($name),
            array_map('strtolower', $provinceStates)
        );

        if ($provinceStateAbbreviation === false)
            $provinceStateAbbrevaition = null;

        return $provinceStateAbbreviation;
    }
}
