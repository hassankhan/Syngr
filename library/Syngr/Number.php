<?php
/**
 * Number Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class Number extends Object {

    /**
     * @const string - Trigonometric function options
     */
    const TRIG_ARC                = 'arc';
    const TRIG_HYPERBOLIC         = 'hyperbolic';
    const TRIG_INVERSE_HYPERBOLIC = 'inverse_hyperbolic';

    /**
     * Constructor function for string object
     * @param string $number - Textual data as represented by string
     */
    public function __construct($number = null)
    {
        parent::__construct(array('content' => $number));
    }

    /**
     * Overrides __toString()
     * @return string - String representation of data
     */
    public function __toString()
    {
        return strval($this->getContent());
    }

    public function value()
    {
        return $this->getContent();
    }

    public function absolute()
    {
        return new Number(abs($this->getContent()));
    }

    public function ceiling()
    {
        return new Number(ceil((float) $this->getContent()));
    }

    public function floor()
    {
        return new Number(floor((float) $this->getContent()));
    }

    public function round($precision = 0)
    {
        return new Number(round((float) $this->getContent(), $precision));
    }

    public function max($values)
    {
        $values[] = $this->getContent();
        return new Number(max($values));
    }

    public function min($values)
    {
        $values[] = $this->getContent();
        return new Number(min($values));
    }

    public function sqrt()
    {
        return new Number(sqrt($this->getContent()));
    }


    // This should probably be a static function or something
    public function random($min = 0, $max = null)
    {
        $number = 0;
        if ($min === 0 && $max === null){
            $number = mt_rand();
        }
        else {
            $number = mt_rand($min, $max);
        }
        return new Number($number);
    }

    public function exp($power)
    {
        return new Number(exp($power));
    }

    public function log($base = 10)
    {
        $number = $this->getContent();
        if ($base === 10) {
            $number = log10($number);
        }
        elseif ($base === 'e') {
            $number = log($number);
        }
        else{
            $number = log($number, $base);
        }
        return new Number($number);
    }

    public function pow($exponent = 1)
    {
        return new Number(pow($this->getContent(), $exponent));
    }

    public function cos($flags = array())
    {
        $number = $this->getContent();
        if (in_array(self::TRIG_INVERSE_HYPERBOLIC, $flags)) {
            $number = acosh($number);
        }
        elseif (in_array(self::TRIG_HYPERBOLIC, $flags)) {
            $number = cosh($number);
        }
        elseif (in_array(self::TRIG_ARC, $flags)) {
            $number = acos($number);
        }
        else {
            $number = cos($number);
        }
        return new Number($number);
    }

    public function sin($flags = array())
    {
        $number = $this->getContent();
        if (in_array(self::TRIG_INVERSE_HYPERBOLIC, $flags)) {
            $number = asinh($number);
        }
        elseif (in_array(self::TRIG_HYPERBOLIC, $flags)) {
            $number = sinh($number);
        }
        elseif (in_array(self::TRIG_ARC, $flags)) {
            $number = asin($number);
        }
        else {
            $number = sin($number);
        }
        return new Number($number);
    }

    public function tan($flags = array())
    {
        $number = $this->getContent();
        if (in_array(self::TRIG_INVERSE_HYPERBOLIC, $flags)) {
            $number = atanh($number);
        }
        elseif (in_array(self::TRIG_HYPERBOLIC, $flags)) {
            $number = tanh($number);
        }
        elseif (in_array(self::TRIG_ARC, $flags)) {
            $number = atan($number);
        }
        else {
            $number = tan($number);
        }
        return new Number($number);
    }

    /**
     * Checks to see whether vslue is finite
     * @return boolean - True if value is, otherwise false
     */
    public function is_finite()
    {
        return is_finite($this->getContent());
    }

    /**
     * Checks to see whether value is infinite
     * @return boolean - True if value is, otherwise false
     */
    public function is_infinite()
    {
        return is_infinite($this->getContent());
    }

    /**
     * Checks to see if value is Not-A-Number (NAN)
     * @return boolean - True if value is, otherwise false
     */
    public function is_nan()
    {
        return is_nan($this->getContent());
    }

}
