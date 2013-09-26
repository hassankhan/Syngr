<?php
/**
 * Base Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class Object
{

    /**
     * The variable's content
     * @var mixed
     */
    protected $content = null;

    /**
     * Constructor
     *
     * @param mixed $content  - Variable content
     * @codeCoverageIgnore
     */
    public function __construct($content = null)
    {
        $this->content = $content;
    }

    public function is_a($class_name)
    {
        return ($this instanceof $class_name) === true ? true : false;
    }

}
