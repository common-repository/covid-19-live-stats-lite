<?php

if( !function_exists('covid19livestats_update_data') ) {
  function covid19livestats_update_data() {

    global $wpdb;
    $table_name = $wpdb->prefix . "covid19_all_countries";

    $url = 'https://covid-19-data.p.rapidapi.com/country/all?format=undefined';
    $timeout = 3600;
    $args = array(
      'headers' => array(
        'x-rapidapi-host' => 'covid-19-data.p.rapidapi.com',
        'x-rapidapi-key' => 'a995011a11msh16435cebdeb4812p17974cjsndf2a388ef477'
      ));

    $response = wp_remote_get( $url, $args);
    $response = $response['body'];

    if( $response ) {
      
      $response = json_decode($response);
      // print_r($response);

      $total = count($response);

      for( $i=0; $i<$total;  $i++ ) {

        $data_count = $wpdb->get_var($wpdb->prepare( "SELECT id FROM " . $table_name . " WHERE country = %s", $response[$i]->country ));
        if( $data_count == 0 ) {


          if( $response[$i]->country == "DRC" ) {
            $response[$i]->country = "Democratic Republic of Congo";
            $code = "CG";
          }

          if( $response[$i]->country == "DRC" ) {
            $response[$i]->country = "Democratic Republic of Congo";
            $code = "CG";
          }
          else $code = covid19livestats_country_to_code( $response[$i]->country );

          $wpdb->insert( $table_name, array(
            'country' => $response[$i]->country,
            'code' => $code,
            'confirmed' => $response[$i]->confirmed,
            'recovered' => $response[$i]->recovered,
            'critical' => $response[$i]->critical,
            'deaths' => $response[$i]->deaths
          ) );
        }
        else {
          $wpdb->update($table_name, array(
            'confirmed' => $response[$i]->confirmed,
            'recovered' => $response[$i]->recovered,
            'critical' => $response[$i]->critical,
            'deaths' => $response[$i]->deaths
            ),
            array(
              'country' => $response[$i]->country
            ));
        }
      }
    }

  }
}

if( !function_exists('covid19livestats_flag') ) {
  function covid19livestats_flag( $country ) {

    $flagname = str_replace( ".", "", $country );
    $flagname = strtolower( str_replace( " ", "-", $flagname ) );
    $flagimageurl = plugin_dir_url( dirname( __FILE__ ) ) .'public/images/flags/'. $flagname .'.png';

    return $flagimageurl;
  }
}

if( !function_exists('covid19livestats_country_to_code') ) {
  function covid19livestats_country_to_code( $country ) {

    $countrycodes = array (
      'AF' => 'Afghanistan',
      'AX' => 'Åland Islands',
      'AL' => 'Albania',
      'DZ' => 'Algeria',
      'AS' => 'American Samoa',
      'AD' => 'Andorra',
      'AO' => 'Angola',
      'AI' => 'Anguilla',
      'AQ' => 'Antarctica',
      'AG' => 'Antigua and Barbuda',
      'AR' => 'Argentina',
      'AM' => 'Armenia',
      'AW' => 'Aruba',
      'AU' => 'Australia',
      'AT' => 'Austria',
      'AZ' => 'Azerbaijan',
      'BS' => 'Bahamas',
      'BH' => 'Bahrain',
      'BD' => 'Bangladesh',
      'BB' => 'Barbados',
      'BY' => 'Belarus',
      'BE' => 'Belgium',
      'BZ' => 'Belize',
      'BJ' => 'Benin',
      'BM' => 'Bermuda',
      'BT' => 'Bhutan',
      'BO' => 'Bolivia',
      'SA' => 'Bonaire, Sint Eustatius and Saba',
      'BA' => 'Bosnia and Herzegovina',
      'BW' => 'Botswana',
      'BV' => 'Bouvet Island',
      'BR' => 'Brazil',
      'IO' => 'British Indian Ocean Territory',
      'BN' => 'Brunei',
      'BG' => 'Bulgaria',
      'BF' => 'Burkina Faso',
      'BI' => 'Burundi',
      'KH' => 'Cambodia',
      'CM' => 'Cameroon',
      'CA' => 'Canada',
      'CV' => 'Cabo Verde',
      'KY' => 'Cayman Islands',
      'CF' => 'CAR',
      'TD' => 'Chad',
      'CL' => 'Chile',
      'CN' => 'China',
      'GB' => 'Channel Islands',
      'CX' => 'Christmas Island',
      'CC' => 'Cocos (Keeling) Islands',
      'CO' => 'Colombia',
      'KM' => 'Comoros',
      'CW' => 'Curaçao',
      'CG' => 'Democratic Republic of Congo',
      'CD' => 'Zaire',
      'CK' => 'Cook Islands',
      'CR' => 'Costa Rica',
      'CI' => 'Côte D\'Ivoire',
      'HR' => 'Croatia',
      'CU' => 'Cuba',
      'CY' => 'Cyprus',
      'CZ' => 'Czechia',
      'DK' => 'Denmark',
      'DJ' => 'Djibouti',
      'DM' => 'Dominica',
      'DO' => 'Dominican Republic',
      'EC' => 'Ecuador',
      'EG' => 'Egypt',
      'SV' => 'El Salvador',
      'GQ' => 'Equatorial Guinea',
      'ER' => 'Eritrea',
      'EE' => 'Estonia',
      'ET' => 'Ethiopia',
      'SZ' => 'Eswatini',
      'FK' => 'Falkland Islands (Malvinas)',
      'FO' => 'Faeroe Islands',
      'FJ' => 'Fiji',
      'FI' => 'Finland',
      'FR' => 'France',
      'GF' => 'French Guiana',
      'PF' => 'French Polynesia',
      'TF' => 'French Southern Territories',
      'GA' => 'Gabon',
      'GM' => 'Gambia',
      'GE' => 'Georgia',
      'DE' => 'Germany',
      'GH' => 'Ghana',
      'GI' => 'Gibraltar',
      'GR' => 'Greece',
      'GL' => 'Greenland',
      'GD' => 'Grenada',
      'GP' => 'Guadeloupe',
      'GU' => 'Guam',
      'GT' => 'Guatemala',
      'GG' => 'Guernsey',
      'GN' => 'Guinea',
      'GW' => 'Guinea-Bissau',
      'GY' => 'Guyana',
      'HT' => 'Haiti',
      'HM' => 'Heard Island and Mcdonald Islands',
      'VA' => 'Vatican City',
      'HN' => 'Honduras',
      'HK' => 'Hong Kong',
      'HU' => 'Hungary',
      'IS' => 'Iceland',
      'IN' => 'India',
      'ID' => 'Indonesia',
      'IR' => 'Iran',
      'IQ' => 'Iraq',
      'IE' => 'Ireland',
      'IM' => 'Isle of Man',
      'IL' => 'Israel',
      'IT' => 'Italy',
      'CI' => 'Ivory Coast',
      'JM' => 'Jamaica',
      'JP' => 'Japan',
      'JE' => 'Jersey',
      'JO' => 'Jordan',
      'KZ' => 'Kazakhstan',
      'KE' => 'Kenya',
      'KI' => 'Kiribati',
      'KP' => 'N. Korea',
      'KR' => 'S. Korea',
      'KW' => 'Kuwait',
      'KG' => 'Kyrgyzstan',
      'LA' => 'Laos',
      'LV' => 'Latvia',
      'LB' => 'Lebanon',
      'LS' => 'Lesotho',
      'LR' => 'Liberia',
      'LY' => 'Libya',
      'LI' => 'Liechtenstein',
      'LT' => 'Lithuania',
      'LU' => 'Luxembourg',
      'MO' => 'Macao',
      'MK' => 'North Macedonia',
      'MG' => 'Madagascar',
      'MW' => 'Malawi',
      'MY' => 'Malaysia',
      'MV' => 'Maldives',
      'ML' => 'Mali',
      'MT' => 'Malta',
      'MH' => 'Marshall Islands',
      'MQ' => 'Martinique',
      'MR' => 'Mauritania',
      'MU' => 'Mauritius',
      'YT' => 'Mayotte',
      'MX' => 'Mexico',
      'FM' => 'Micronesia',
      'MD' => 'Moldova',
      'MC' => 'Monaco',
      'MN' => 'Mongolia',
      'ME' => 'Montenegro',
      'MS' => 'Montserrat',
      'MA' => 'Morocco',
      'MZ' => 'Mozambique',
      'MS' => 'MS Zaandam',
      'MM' => 'Myanmar',
      'NA' => 'Namibia',
      'NR' => 'Nauru',
      'NP' => 'Nepal',
      'NL' => 'Netherlands',
      'AN' => 'Netherlands Antilles',
      'BQ' => 'Caribbean Netherlands',
      'NC' => 'New Caledonia',
      'NZ' => 'New Zealand',
      'NI' => 'Nicaragua',
      'NE' => 'Niger',
      'NG' => 'Nigeria',
      'NU' => 'Niue',
      'NF' => 'Norfolk Island',
      'MP' => 'Northern Mariana Islands',
      'NO' => 'Norway',
      'OM' => 'Oman',
      'PK' => 'Pakistan',
      'PW' => 'Palau',
      'PS' => 'Palestine',
      'PA' => 'Panama',
      'PG' => 'Papua New Guinea',
      'PY' => 'Paraguay',
      'PE' => 'Peru',
      'PH' => 'Philippines',
      'PN' => 'Pitcairn',
      'PL' => 'Poland',
      'PT' => 'Portugal',
      'PR' => 'Puerto Rico',
      'QA' => 'Qatar',
      'RE' => 'Reunion',
      'RO' => 'Romania',
      'RU' => 'Russia',
      'RW' => 'Rwanda',
      'SH' => 'Saint Helena, Ascension and Tristan da Cunha',
      'KN' => 'Saint Kitts and Nevis',
      'LC' => 'Saint Lucia',
      'SX' => 'Sint Maarten',
      'MF' => 'Saint Martin',
      'PM' => 'Saint Pierre and Miquelon',
      'VC' => 'St. Vincent Grenadines',
      'BL' => 'St. Barth',
      'WS' => 'Samoa',
      'SM' => 'San Marino',
      'ST' => 'Sao Tome and Principe',
      'SA' => 'Saudi Arabia',
      'SN' => 'Senegal',
      'RS' => 'Serbia',
      'SC' => 'Seychelles',
      'SL' => 'Sierra Leone',
      'SG' => 'Singapore',
      'SK' => 'Slovakia',
      'SI' => 'Slovenia',
      'SB' => 'Solomon Islands',
      'SO' => 'Somalia',
      'ZA' => 'South Africa',
      'GS' => 'South Georgia and the South Sandwich Islands',
      'ES' => 'Spain',
      'LK' => 'Sri Lanka',
      'SS' => 'South Sudan',
      'SD' => 'Sudan',
      'SR' => 'Suriname',
      'SJ' => 'Svalbard and Jan Mayen',
      'SZ' => 'Swaziland',
      'SE' => 'Sweden',
      'CH' => 'Switzerland',
      'SY' => 'Syria',
      'TW' => 'Taiwan',
      'TJ' => 'Tajikistan',
      'TZ' => 'Tanzania',
      'TH' => 'Thailand',
      'TL' => 'Timor-Leste',
      'TG' => 'Togo',
      'TK' => 'Tokelau',
      'TO' => 'Tonga',
      'TT' => 'Trinidad and Tobago',
      'TN' => 'Tunisia',
      'TR' => 'Turkey',
      'TM' => 'Turkmenistan',
      'TC' => 'Turks and Caicos',
      'TV' => 'Tuvalu',
      'UG' => 'Uganda',
      'UA' => 'Ukraine',
      'AE' => 'UAE',
      'GB' => 'UK',
      'US' => 'USA',
      'UM' => 'United States Minor Outlying Islands',
      'UY' => 'Uruguay',
      'UZ' => 'Uzbekistan',
      'VU' => 'Vanuatu',
      'VE' => 'Venezuela',
      'VN' => 'Vietnam',
      'VG' => 'British Virgin Islands',
      'VI' => 'U.S. Virgin Islands',
      'WF' => 'Wallis and Futuna',
      'EH' => 'Western Sahara',
      'YE' => 'Yemen',
      'ZM' => 'Zambia',
      'ZW' => 'Zimbabwe',
    );

    $code = array_search( $country, $countrycodes);
    return $code;
  }
}
