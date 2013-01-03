<?php
/**
 * PEAR2\Math\QuaternionOp
 *
 * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-clause license
 * @version 0.1.0
 */
namespace PEAR2\Math;

/**
 * QuaternionOp: class that implements operations on quaternions
 *
 * Originally this class was part of NumPHP (Numeric PHP package)
 *
 * Example:
 * <pre>
 * use PEAR2\Math\Quaternion;
 * use PEAR2\Math\QuaternionOp;
 *
 * $a = new Quaternion(2,4,2,-0.5);
 * $b = new Quaternion(1,2,3,0.5);
 *
 * if (!QuaternionOp::areEqual($a, QuaternionOp::negate($a))) {
 *     echo "a and neg(a) are different\n";
 * }
 * $t=QuaternionOp::negate($a);
 * echo "Neg(a) is ".$t->toString()."\n";
 * $t=QuaternionOp::conjugate($a);
 * echo "Conj(a) is ".$t->toString()."\n";
 * $t=QuaternionOp::inverse($a);
 * echo "Inv(a) is ".$t->toString()."\n";
 * $t=QuaternionOp::multReal($a, 1.23);
 * echo "MultReal(a, 1.23) is ".$t->toString()."\n";
 *
 * echo "====\n";
 * $t=QuaternionOp::mult($a,$b);
 * echo "a*b: ".$t->toString()."\n";
 * $t=QuaternionOp::mult($b,$a);
 * echo "b*a: ".$t->toString()."\n";
 * $t=QuaternionOp::mult($a,QuaternionOp::conjugate($a));
 * echo "a*a': ".$t->toString()."\n";
 * echo "length(a*a'): ".$t->length()."\n";
 * $t=QuaternionOp::add($a,$b);
 * echo "a+b: ".$t->toString()."\n";
 * $t=QuaternionOp::sub($a,$b);
 * echo "a-b: ".$t->toString()."\n";
 * $t=QuaternionOp::sub($b,$a);
 * echo "b-a: ".$t->toString()."\n";
 * $t=QuaternionOp::sub($b,QuaternionOp::conjugate($a));
 * echo "b-a': ".$t->toString()."\n";
 * $t=QuaternionOp::sub(QuaternionOp::conjugate($b), $a);
 * echo "b'-a: ".$t->toString()."\n";
 * $t=QuaternionOp::sub(QuaternionOp::conjugate($b), QuaternionOp::conjugate($a));
 * echo "b'-a': ".$t->toString()."\n";
 * $t = QuaternionOp::div($a, $b);
 * echo "a/b: ".$t->toString()."\n";
 * $t = QuaternionOp::div($b, $a);
 * echo "b/a: ".$t->toString()."\n";
 * </pre>
 *
 * Output from example:
 * <pre>
 * a and neg(a) are different
 * Neg(a) is -2 + -4i + -2j + 0.5k
 * Conj(a) is 2 + -4i + -2j + 0.5k
 * Inv(a) is 0.40613846605345 + -0.8122769321069i + -0.40613846605345j + 0.10153461651336k
 * MultReal(a, 1.23) is 2.46 + 4.92i + 2.46j + -0.615k
 * ====
 * a*b: -11.25 + 6i + 9j + 1.5k
 * b*a: -18.25 + 12i + 6j + -1.5k
 * a*a': -16.25 + -16i + -8j + 2k
 * length(a*a'): 24.25
 * a+b: 3 + 6i + 5j + 0k
 * a-b: 1 + 2i + -1j + -1k
 * b-a: -1 + -2i + 1j + 1k
 * b-a': -1 + 6i + 5j + 0k
 * b'-a: -1 + -6i + -5j + 0k
 * b'-a': -1 + 2i + -1j + -1k
 * a/b: -19.720187057174 + 9.059625885652i + 4.529812942826j + -1.1324532357065k
 * b/a: -12.843861533947 + 2.8122769321069i + 4.2184153981603j + 0.70306923302672k
 * </pre>
 *
 * @access  public
 * @package Quaternion
 */
class QuaternionOp {/*{{{*/

    /**
     * Whether the object is a Quaternion instance
     *
     * @param object Quaternion $q1
     * @return boolean TRUE if object is a Quaternion, FALSE otherwise
     * @access public
     */
    static function isQuaternion ($q) {/*{{{*/
        return $q instanceof Quaternion;
    }/*}}}*/

    /**
     * Calculate the conjugate of a quaternion
     *
     * @param object Quaternion $q
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function conjugate($q) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)) {
            throw Quaternion\Exception("Parameter needs to be a Quaternion object");
        }
        $q2 = clone $q;
        $q2->conjugate();
        return $q2;
    }/*}}}*/

    /**
     * Returns a negated quaternion
     *
     * @param object Quaternion $q
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function negate($q) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q)) {
            throw Quaternion\Exception("Parameter needs to be a Quaternion object");
        $q2 = clone $q;
        $q2->negate();
        return $q2;
    }/*}}}*/

    /**
     * Returns the inverse of the given quaternion
     *
     * @param object Quaternion $q1
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     * @see QuaternionOp::multReal
     */
     static function inverse ($q) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q)) {
            throw Quaternion\Exception("Parameter needs to be a Quaternion object");
        }
        $c = QuaternionOp::conjugate($q);
        $norm = $q->norm();
        if ($norm == 0) {
            throw Quaternion\Exception(
                'Quaternion norm is zero, cannot calculate inverse');
        }
        $invmult = 1/$norm;
        return QuaternionOp::multReal($c, $invmult);
    }/*}}}*/

    /**
     * Checks if two quaternions represent the same number
     *
     * @param object Quaternion $q1
     * @param object Quaternion $q2
     * @return boolean TRUE if q1 == q2, FALSE otherwise
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function areEqual ($q1, $q2) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)
            || !QuaternionOp::isQuaternion($q2)) {
            throw Quaternion\Exception("Parameters need to be Quaternion objects");
        }
        return ( $q1->getReal() === $q2->getReal()
            && $q1->getI() === $q2->getI()
            && $q1->getJ() === $q2->getJ()
            && $q1->getK() === $q2->getK() );
    }/*}}}*/

    /**
     * Adds two quaternions: q1 + q2
     *
     * @param object Quaternion $q1
     * @param object Quaternion $q2
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function add ($q1, $q2) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)
            || !QuaternionOp::isQuaternion($q2)) {
            throw Quaternion\Exception("Parameters need to be Quaternion objects");
        }
       return new Quaternion( $q1->getReal() + $q2->getReal(),
                              $q1->getI() + $q2->getI(),
                              $q1->getJ() + $q2->getJ(),
                              $q1->getK() + $q2->getK() );
    }/*}}}*/

    /**
     * Substracts two quaternions: q1 - q2
     *
     * @param object Quaternion $q1
     * @param object Quaternion $q2
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function sub ($q1, $q2) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)
            || !QuaternionOp::isQuaternion($q2)) {
            throw Quaternion\Exception("Parameters need to be Quaternion objects");
        }
        return QuaternionOp::add($q1, QuaternionOp::negate($q2));
    }/*}}}*/

    /**
     * Multiplies two quaternions: q1 * q2
     * It uses a fast multiplication algorithm.
     *
     * @param object Quaternion $q1
     * @param object Quaternion $q2
     * @return object a Quaternion on success, PEAR_Error otherwise
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function mult ($q1, $q2) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)
            || !QuaternionOp::isQuaternion($q2)) {
            throw Quaternion\Exception("Parameters need to be Quaternion objects");
        }
        // uses the fast multiplication algorithm
        $a = $q1->getReal(); $q1im = $q1->getAllIm();
        $b = $q1im["i"]; $c = $q1im["j"]; $d = $q1im["k"];

        $x = $q2->getReal(); $q2im = $q2->getAllIm();
        $y = $q2im["i"]; $z = $q2im["j"]; $w = $q2im["k"];

        $t0 = ($d - $c) * ($z - $w);
        $t1 = ($a + $b) * ($x + $y);
        $t2 = ($a - $b) * ($z + $w);
        $t3 = ($c + $d) * ($x - $y);
        $t4 = ($d - $b) * ($y - $z);
        $t5 = ($d + $b) * ($y + $z);
        $t6 = ($a + $c) * ($x - $w);
        $t7 = ($a - $c) * ($x + $w);
        $t8 = $t5 + $t6 + $t7;
        $t9 = 0.5 * ($t4 + $t8);

        $r = $t0 + $t9 - $t5;
        $i = $t1 + $t9 - $t8;
        $j = $t2 + $t9 - $t7;
        $k = $t3 + $t9 - $t6;

        return new Quaternion($r, $i , $j, $k);
    }/*}}}*/

    /**
     * Divides two quaternions: q1 / q2
     *
     * @param object Quaternion $q1
     * @param object Quaternion $q2
     * @return object a Quaternion on success
     * @throws PEAR2\Quaternion\Exception
     * @access public
     */
    static function div($q1, $q2) throws PEAR2\Quaternion\Exception {/*{{{*/
        if (!QuaternionOp::isQuaternion($q1)
            || !QuaternionOp::isQuaternion($q2)) {
            throw Quaternion\Exception("Parameters need to be Quaternion objects");
        }
        $i2 = QuaternionOp::inverse($q2);
        return QuaternionOp::mult($i2, $q1);
    }/*}}}*/

    /**
     * Multiplies a quaternion by a real number: q1 * realnum
     *
     * @param object Quaternion $q1
     * @param float $realnum
     * @return object a Quaternion on success, PEAR_Error otherwise
     * @access public
     */
    static function multReal (&$q, $realnum) {/*{{{*/
        if (!QuaternionOp::isQuaternion($q) || !is_numeric($realnum)) {
            throw Quaternion\Exception(
                "A Quaternion object and a real number are needed");
        }
        return new Quaternion ( $realnum * $q->getReal(),
                                $realnum * $q->getI(),
                                $realnum * $q->getJ(),
                                $realnum * $q->getK() );
    }/*}}}*/

}/*}}} end of QuaternionOp */
?>

