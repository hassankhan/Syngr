<?php
/**
 * Base Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class Object
{
    protected $options = array();
    protected $fields = array();

    /**
     * Constructor
     *
     * @param array $fields  - fields array [optional]
     * @param array $options - array of options [optional]
     * @codeCoverageIgnore
     */
    public function __construct($fields = array(), $options = array())
    {
        $this->fields  = $fields;
        $this->options = $options;
    }

    /**
     * Get fields
     *
     * @return array of fields
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set fields
     *
     * @param array $fields - array of fields
     * @return $this
     */
    public function setFields($fields)
    {
        if (!is_array($fields)) {
            throw new \Exception('Fields are not in an array');
        }

        foreach ($fields as $key => $field) {
            $this->fields[$key] = $field;
        }

        return $this;
    }

    /**
     * Create dynamic functions
     *
     * @param string $method    - method name
     * @param array  $arguments - array of arguments that get is called by
     * @throws Exception if get option doesn't exist
     * @return field value if get. $this if set.
     */
    function __call($method, $arguments)
    {
        $meth = $this->fromCamelCase(substr($method, 3, strlen($method)-3));
        $verb = substr($method, 0, 3);
        switch($verb){
        case 'get':
            if (array_key_exists($meth, $this->fields)) {
                return $this->fields[$meth];
            }
            throw new \Exception('The requested option: "'.$meth.'" does not exist');
            break;
        case 'set':
            $this->fields[$meth] = $arguments[0];
            return $this;
            break;
        default:
            throw new \Exception('The requested verb: "'.$verb.'" is not valid');
            break;
        }
    }

    /**
     * Convert camel case to underscore
     * http://www.paulferrett.com/2009/php-camel-case-functions/
     *
     * @param string $str - string to convert
     * @return string converted string
     */
    protected function fromCamelCase($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "_" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

    /**
     * Get option - supports nested options separated by "."
     *
     * @param string $key     - option key
     * @param array  $options - options array [optional]
     * @throws Exception if key not found
     * @return option value
     */
    public function getOption($key, $options = null)
    {
        $keys = explode(".", $key);

        if (is_null($options)) {
            $options = $this->options;
        }

        if (!is_array($options)) {
            throw new \Exception('Options are not in an array');
        }

        if (!array_key_exists($keys[0], $options)) {
            throw new \Exception('Option "'.$keys[0].'" has not been set');
        }

        $value = $options[$keys[0]];

        if (count($keys) > 1) {
            unset($keys[0]);
            return $this->getOption(implode(".", $keys), $value);
        }

        return $value;
    }

    /**
     * Set option - supports nested options separated by "."
     *
     * @param string $key     - option key
     * @param mixed  $value   - option value
     * @param array  $options - options array [optional]
     * @return this
     */
    public function setOption($key, $value, $options = null)
    {
        $keys = explode(".", $key);

        $base = false;
        if (is_null($options)) {
            $options = $this->options;
            // We are at the beginning of the set
            $base = true;
        }

        if (!is_array($options)) {
            throw new \Exception('Options are not in an array');
        }

        if (count($keys) > 1) {
            if (!array_key_exists($keys[0], $options)) {
                $options[$keys[0]] = array();
            }

            $options[$keys[0]] = $this->setOption(
                implode(".", array_slice($keys, 1)),
                $value,
                $options[$keys[0]]
            );
        } else {
            $options[$keys[0]] = $value;
        }

        // If we are at the top of tree export the options
        if ($base == true) {
            $this->options = $options;
        }

        return $options;
    }

}
