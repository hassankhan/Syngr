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
        return (int) $this->getContent();
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

}
