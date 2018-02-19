<?php

namespace common\components;

class GeoComponent {

    // длинна (в метрах) одного градуса широты
    private const ONE_LATITUDE_DEGREE = 111152.8928;
    
    public function calculateCoordinatesRange(float $latitude, float $longitude, int $radius)
    {
        $result                     = [];
        // длинна одного градуса долготы (в метрах) в данной широте
        $sLong                      = cos($latitude) * self::ONE_LATITUDE_DEGREE;
        
        // величина широты (в градусах) заданного радиуса
        $latDG                      = $radius / self::ONE_LATITUDE_DEGREE;
        
        // величина долготы (в градусах) заданного радиуса
        $longDG                     = $radius / $sLong;
        $result['latitude_from']    = $latitude - $latDG;
        $result['latitude_to']      = $latitude + $latDG;
        $result['longitude_from']   = $longitude - $longDG;
        $result['longitude_to']     = $longitude + $longDG;
        return $result;
    }
    
    /*
    * Расстояние между двумя точками
    * $φA, $λA - широта, долгота 1-й точки,
    * $φB, $λB - широта, долгота 2-й точки
    */
    
    public function calculateDistanse($φA, $λA, $φB, $λB)
    {
        // перевести координаты в радианы
        $lat1           = $φA * M_PI / 180;
        $lat2           = $φB * M_PI / 180;
        $long1          = $λA * M_PI / 180;
        $long2          = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1            = cos($lat1);
        $cl2            = cos($lat2);
        $sl1            = sin($lat1);
        $sl2            = sin($lat2);
        $delta          = $long2 - $long1;
        $cdelta         = cos($delta);
        $sdelta         = sin($delta);

        // вычисления длины большого круга
        $y              = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x              = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        //
        $ad             = atan2($y, $x);
        return $ad * self::EARTH_RADIUS;
    }
}