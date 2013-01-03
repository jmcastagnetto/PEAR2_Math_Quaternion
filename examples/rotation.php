<?php
/**
 * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-clause license
 * @version 0.1.0
 */

require '../src/PEAR2/Math/Quaternion.php';
require '../src/PEAR2/Math/QuaternionOp.php';
require '../src/PEAR2/Math/Quaternion/Exception.php';

use PEAR2\Math\Quaternion;
use PEAR2\Math\QuaternionOp;

// Represent the vector [3,5,-2] as a quaternion
$w = new Quaternion( 0, 3, 5, -2 );
// Create a quaternion representing a π/2 degrees rotation on X
$q = new Quaternion(cos(M_PI_4), sin(M_PI_4), 0, 0);
// and its inverse
$iq = QuaternionOp::inverse($q);
// Perform the rotation the 90 degress rotation of w:
// r = q * w * iq
$r = QuaternionOp::mult( $q ,QuaternionOp::mult( $w, $iq ));

echo "The vector [3,5,-2] represented as a quaternion (real=0) ";
echo "w = $w\n";
echo "The unit vector [1, 0, 0] rotated π/2 degrees ";
echo "q = $q\n";
echo "and its inverse ";
echo "1/q = $iq\n";
echo "The rotated quaternion ( real ~ 0 )";
echo "r = q w (1/q) = $r\n";
echo "and the final 3D vector [i,j,k]: ";
$v = $r->getAllIm();
echo "[".$v['i'].", ".$v['j'].", ".$v['k']."]\n";

