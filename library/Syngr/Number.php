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
        $number = (int) $this->getContent();
        $this->setContent(abs($number));
        return $this;
    }

    public function ceiling()
    {
        $number = (float) $this->getContent();
        $this->setContent(ceil($number));
        return $this;
    }

    public function floor()
    {
        $number = (float) $this->getContent();
        $this->setContent(floor($number));
        return $this;
    }

    public function round($precision = 0)
    {
        $number = (float) $this->getContent();
        $this->setContent(round($number, $precision));
        return $this;
    }

    public function max($values)
    {
        $values[] = $this->getContent();
        $this->setContent(max($values));
        return $this;
    }

    public function min($values)
    {
        $values[] = $this->getContent();
        $this->setContent(min($values));
        return $this;
    }

    public function sqrt()
    {
        $this->setContent(sqrt($this->getContent()));
        return $this;
    }

    public function random($min = 0, $max = null)
    {
        if ($min === 0 && $max === null){
            $this->setContent(mt_rand());
        }
        else {
            $this->setContent(mt_rand($min, $max));
        }
        return $this;
    }

    public function exp($power)
    {
        $this->setContent(exp($power));
        return $this;
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
        $this->setContent($number);
        return $this;
    }

    public function pow($exponent = 1)
    {
        $number = $this->getContent();
        $this->setContent(pow($number, $exponent));
        return $this;
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
        $this->setContent($number);
        return $this;
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
        $this->setContent($number);
        return $this;
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
        $this->setContent($number);
        return $this;
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
