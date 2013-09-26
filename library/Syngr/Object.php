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
    public function __construct($content)
    {
        $this->content = $content;
    }

}
