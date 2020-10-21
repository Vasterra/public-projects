<?php


namespace App\Classes;


class Security
{
    public static function cleanString( $str )
    {
        if( stristr( $str, '--coder--' ) ) {
            $array      = preg_split( '/--coder--/', $str );
            $array[ 1 ] = str_replace( '<', '&lt;', $array[ 1 ] );
            $array[ 1 ] = str_replace( '>', '&gt;', $array[ 1 ] );
            $str        = $array[ 0 ] . '--coder--' . $array[ 1 ] . '--coder--' . $array[ 2 ];
        }
        return $str;
    }

}
