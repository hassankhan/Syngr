<?php
/**
 * Array Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class Arr extends \ArrayObject {

    /**
     * @const string - options
     */
    const RANDOM_CONSTANT = 'random_value';

    /**
     * Constructor function for string object
     * @param string $array - Textual data as represented by string
     */
    public function __construct($array = null)
    {
        parent::__construct(array('content' => $array));
    }

    /**
     * Overrides __toString()
     * @return string - String representation of data
     */
    public function __toString()
    {
        return $this->getContent();
    }

}
