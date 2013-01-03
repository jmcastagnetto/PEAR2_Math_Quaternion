<?php
/**
 * PEAR2\Math\Quaternion
 *
 * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-clause license
 * @version 0.1.0
 */
namespace PEAR2\Math;

/**
 * Class to represent an manipulate quaternions (q = a + b*i + c*j + d*k)
 *
 * A quaternion is an extension of the idea of complex numbers
 * In 1844 Hamilton described a system in which numbers were composed of
 * a real part and 3 imaginary and independent parts (i,j,k), such that:
 *
 *     i^2 = j^2 = k^2 = -1       and
 *     ij = k, jk = i, ki = j     and
 *     ji = -k, kj = -i, ik = -j
 *
 * The above are known as "Hamilton's rules"
 *
 * Interesting references on quaternions:
 *
 * - Sir William Rowan Hamilton "On Quaternions", Proceedings of the Royal
 *   Irish Academy, Nov. 11, 1844, vol. 3 (1847), 1-16
 *   (http://www.maths.tcd.ie/pub/HistMath/People/Hamilton/Quatern2/Quatern2.html)
 *
 * - Quaternion (from MathWorld): http://mathworld.wolfram.com/Quaternion.html
 *
 * Originally this class was part of NumPHP (Numeric PHP package)
 * In 2013 it was ported from PEAR to PEAR2
 *
 * Example:
 * <pre>
 * use PEAR2\Math\Quaternion;
 *
 * $a = new Quaternion(2,4,2,-0.5);
 * $b = new Quaternion(1,2,3,0.5);
 *
 * echo "a: ".$a."\n";
 * echo "b: ".$b."\n";
 * $t = QuaternionOp::conjugate($a);
 * echo "a': ".$t."\n";
 * $t = QuaternionOp::conjugate($b);
 * echo "b': ".$t."\n";
 * echo "length(a): ".$a->length()."  length2(a): ".$a->length2()."\n";
 * echo "real(a): ".$a->getReal()."\nimag(a): ";
 * print_r($a->getAllIm());
 * </pre>
 *
 * Output from example:
 * <pre>
 * a: 2 + 4i + 2j + -0.5k
 * b: 1 + 2i + 3j + 0.5k
 * a': 2 + -4i + -2j + 0.5k
 * b': 1 + -2i + -3j + -0.5k
 * length(a): 4.9244289008981  length2(a): 24.25
 * real(a): 2
 * imag(a): Array
 * (
 *     [i] => 4
 *     [j] => 2
 *     [k] => -0.5
 * )
 * </pre>
 *
 * @access  public
 * @package Quaternion
 */
class Quaternion {/*{{{*/

    /**
     * The real part of the quaternion
     *
     * @var    float
     * @access private
     */
    private $real;

    /**
     * Coefficient of the first imaginary root
     *
     * @var float
     * @access private
     */
    private $i;

    /**
     * Coefficient of the second imaginary root
     *
     * @var float
     * @access private
     */
    private $j;

    /**
     * Coefficient of the third imaginary root
     *
     * @var float
     * @access private
     */
    private $k;

    /**
     * Constructor for PEAR2\Math\Quaternion
     *
     * @param float $real
     * @param float $i
     * @param float $j
     * @param float $k
     * @return object PEAR2\Math\Quaternion
     * @access public
     */
    public function __construct ($real, $i, $j, $k) {/*{{{*/
        $this->setReal($real);
        $this->setI($i);
        $this->setJ($j);
        $this->setK($k);
    }/*}}}*/

    /**
     * Returns the square of the norm (length)
     *
     * @return float
     * @access public
     */
    public function length2() {/*{{{*/
            $r = $this->getReal();
            $i = $this->getI();
            $j = $this->getJ();
            $k = $this->getK();
            return ($r*$r + $i*$i + $j*$j + $k*$k);
    }/*}}}*/

    /**
     * Returns the norm of the quaternion
     *
     * @return float
     * @access public
     */
    public function norm() {/*{{{*/
        return sqrt($this->length2());
    }/*}}}*/

    /**
     * Returns the length (norm). Alias of PEAR2\Math\Quaternion::norm()
     *
     * @return float
     * @access public
     */
    public function length() {/*{{{*/
        return $this->norm();
    }/*}}}*/

    /**
     * Normalizes the quaternion
     *
     * @return mixed True on success
     * @throws PEAR2\Math\Quaternion\Exception if norm = 0 or if final norm != 1
     * @access public
     */
    public function normalize() throws PEAR2\Math\Quaternion\Exception  {/*{{{*/
        $n = $this->norm();
        if ($n == 0.0) {
            throw PEAR2\Exception('Quaternion cannot be normalized, norm = 0');
        } else {
            $this->setReal($this->getReal() / $n);
            $this->setI($this->getI() / $n);
            $this->setJ($this->getJ() / $n);
            $this->setK($this->getK() / $n);
            if ($this->norm() != 1.0) {
                throw PEAR2\Exception('Computation error while normalizing, norm != 1');
            } else {
                return true;
            }
        }
    }/*}}}*/

    /**
     * Converts the quaternion to its conjugate
     *
     * @return void
     * @access public
     */
    public function conjugate() {/*{{{*/
        $this->setI(-1 * $this->getI());
        $this->setJ(-1 * $this->getJ());
        $this->setK(-1 * $this->getK());
    }/*}}}*/

    /**
     * Negates the quaternion
     *
     * @return void
     * @access public
     */
    public function negate() {/*{{{*/
        $this->setReal(-1 * $this->getReal());
        $this->setI(-1 * $this->getI());
        $this->setJ(-1 * $this->getJ());
        $this->setK(-1 * $this->getK());
    }/*}}}*/

    /**
     * Sets the real part
     *
     * @param float $real
     * @return void
     * @access public
     */
    public function setReal($real) {/*{{{*/
        $this->real = floatval($real);
    }/*}}}*/

    /**
     * Returns the real part
     *
     * @return float
     * @access public
     */
    public function getReal() {/*{{{*/
        return $this->real;
    }/*}}}*/

    /**
     * Sets I
     *
     * @param float $i
     * @return void
     * @access public
     */
    public function setI($i) {/*{{{*/
        $this->i = floatval($i);
    }/*}}}*/

    /**
     * Returns I
     *
     * @return float
     * @access public
     */
    public function getI() {/*{{{*/
        return $this->i;
    }/*}}}*/

    /**
     * Sets J
     *
     * @param float $j
     * @return void
     * @access public
     */
    public function setJ($j) {/*{{{*/
        $this->j = floatval($j);
    }/*}}}*/

    /**
     * Returns J
     *
     * @return float
     * @access public
     */
    public function getJ() {/*{{{*/
        return $this->j;
    }/*}}}*/

    /**
     * Sets K
     *
     * @param float $k
     * @return void
     * @access public
     */
    public function setK($k) {/*{{{*/
        $this->k = floatval($k);
    }/*}}}*/

    /**
     * Returns K
     *
     * @return float
     * @access public
     */
    public function getK() {/*{{{*/
        return $this->k;
    }/*}}}*/

    /**
     * Sets I, J, K
     * @return void
     * @access public
     */
    public function setAllIm($i, $j, $k) {/*{{{*/
        $this->setI($i);
        $this->setJ($j);
        $this->setK($k);
    }/*}}}*/

    /**
     * Returns an associative array of I, J, K
     *
     * @return array
     * @access public
     */
    public function getAllIm() {/*{{{*/
        return array ( 'i' => $this->getI(), 'j' => $this->getJ(), 'k' => $this->getK() );
    }/*}}}*/

    /**
     * Clones the quaternion
     *
     * @return object PEAR2\Math\Quaternion
     * @access public
     */
    public function __clone() {/*{{{*/
        return new PEAR2\Math\Quaternion($this->getReal(), $this->getI(),
                                         $this->getJ(), $this->getK());
    }/*}}}*/

    /**
     * Simple string representation of the quaternion
     *
     * @return string
     * @access public
     */
    public function __toString () {/*{{{*/
        return ( $this->getReal()." + ".$this->getI()."i + ".
                 $this->getJ()."j + ".$this->getK()."k");
    }/*}}}*/



}/*}}} end of PEAR2\Math\Quaternion */

?>

