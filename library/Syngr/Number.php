<?php
/**
 * Number Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class Number extends Object {

    /**
     * @const string - Case options
     */
    const CASE_INSENSITIVE = 'case_insensitive';
    const CASE_SENSITIVE   = 'case_sensitive';

    /**
     * @const string - Ordering options
     */
    const ORDER_NATURAL    = 'order_natural';
    const ORDER_NORMAL     = 'order_normal';

    /**
     * @const string - String position options
     */
    const STRING_LEFT      = 'left';
    const STRING_RIGHT     = 'right';
    const STRING_BOTH      = 'both';

    /**
     * Constructor function for string object
     * @param string $string - Textual data as represented by string
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
        // $type = gettype($this->getContent());
        return $this->getContent();
    }

    public function absolute()
    {
        $number = (int) $this->getContent();
        $this->setContent(abs($number));
        return $this;
    }

    public function ceil()
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

}
