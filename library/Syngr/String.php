<?php
/**
 * Base Class
 *
 * @author Hassan Khan <contact@hassankhan.me>
 */
namespace Syngr;

class String extends Object {

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
    public function __construct($string = '')
    {
        parent::__construct(
            array(
                'content' => $string
            )
        );
    }

    /**
     * Overrides __toString()
     * @return string - String representation of data
     */
    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * Gets length of string
     * @return int - The length of the string
     */
    public function length()
    {
        return strlen($this->getContent());
    }

    // Currently replaces current content with new data
    // should this be expected behaviour
    // think of use cases
    // EDIT : Maybe it belongs in the array class?
    public function join($delimiter = '', $data)
    {
        $this->setContent(implode($delimiter, $data));
        return $this;
    }

    // For greater flexibility, make this work with arrays too
    public function split($splitter)
    {
        $text = $this->getContent();
        if (is_int($splitter)) {
            $text = str_split($text, $splitter);
        }
        elseif (is_string($splitter)) {
            $text = explode($splitter, $text);
        }
        else {
            throw new \Exception('Invalid delimiter/length given');
        }
        return $text;
    }

    public function compare($string, $flags = array())
    {
        $comparison_result = 0;

        if (is_string($string)) {
            // Case-insensitive, natural order
            if (
                in_array(
                    array(self::CASE_INSENSITIVE, self::ORDER_NATURAL),
                    $flags
                )
            ) {
                $comparison_result = strnatcasecmp(
                    $this->getContent(),
                    $string
                );
            }
            // Case-insensitive
            elseif (in_array(self::CASE_INSENSITIVE, $flags)) {
                $comparison_result = strcasecmp($this->getContent(), $string);
            }
            // Natural order
            elseif (in_array(self::ORDER_NATURAL, $flags)) {
                $comparison_result = strnatcmp(
                    $this->getContent(),
                    $string
                );
            }
            // Case-sensitive
            else {
                $comparison_result = strcmp($this->getContent(), $string);
            }
            return $comparison_result === 0 ? true : false;
        }
        else {
            throw new \Exception('Cannot compare ' . gettype($string) . ' with string');
        }
    }

    /**
     * Returns a hash of the current string in the specified algorithm
     * @param  string $algorithm - By default, is set to 'MD5'.
     * @return string            - The result of the hashing function
     */
    public function hash($algorithm = 'MD5')
    {
        return hash($algorithm, $this->getContent());
    }

    /**
     * Returns portion of the string
     * @param  int $start  - Starting index of substring
     * @param  int $length - Length of substring
     * @return String      - Returns current instance for method chaining
     */
    public function substring($start, $length = null)
    {
        $string = $this->getContent();
        $length = $length === null ? strlen($string) : $length;
        $this->setContent(substr($string, $start, $length));
        return $this;
    }

    public function trim($delimiter = ' ', $flags = array())
    {
        $text = $this->getContent();
        if ($delimiter === ' ') {
            if (in_array(self::STRING_LEFT, $flags)) {
                $text = ltrim($text);
            }
            elseif (in_array(self::STRING_RIGHT, $flags)) {
                $text = rtrim($text);
            }
            else {
                $text = trim($text);
            }
        }
        else {
            if (in_array(self::STRING_LEFT, $flags)) {
                $text = ltrim($text, $delimiter);
            }
            elseif (in_array(self::STRING_RIGHT, $flags)) {
                $text = rtrim($text, $delimiter);
            }
            else {
                $text = trim($text, $delimiter);
            }
        }

        $this->setContent($text);
        return $this;
    }

    /**
     * Switches all characters in string into uppercase
     * @return String - Returns current instance for method chaining
     */
    public function uppercase()
    {
        $this->setContent(strtoupper($this->getContent()));
        return $this;
    }

    /**
     * Switches all characters in string into lowercase
     * @return String - Returns current instance for method chaining
     */
    public function lowercase()
    {
        $this->setContent(strtolower($this->getContent()));
        return $this;
    }

    public function pad($length, $delimiter = ' ', $flags = array())
    {
        $text = $this->getContent();
        if (in_array(self::STRING_LEFT, $flags)) {
            $text = str_pad(
                $text,
                strlen($text) + $length,
                $delimiter,
                STR_PAD_LEFT
            );
        }
        elseif (in_array(self::STRING_BOTH, $flags)) {
            $text = str_pad(
                $text,
                strlen($text) + $length,
                $delimiter,
                STR_PAD_BOTH
            );
        }
        else {
            $text = str_pad(
                $text,
                strlen($text) + $length,
                $delimiter
            );
        }
        $this->setContent($text);
        return $this->getContent();
    }

    /**
     * Reverses the order of characters in a string
     * @return String - Returns current instance for method chaining
     */
    public function reverse()
    {
        $this->setContent(strrev($this->getContent()));
        return $this;
    }

    /**
     * Finds and replaces text in string
     * @param  string  $search  - The string to look for
     * @param  string  $replace - The string to replace with
     * @param  integer $count   - (Optional) Limit the number of replacements, unlimited by default
     * @param  array   $flags   - Optional flags
     * @return String           - Returns current instance for method chaining
     */
    // Need to add regex support
    public function replace($search, $replace, $count = 0, $flags = array())
    {
        $text = $this->getContent();
        if ($count === 0) {
            $text = str_replace($search, $replace, $text);
        }
        else {
            $text = str_replace($search, $replace, $text, $count);
        }
        $this->setContent($text);
        return $this;
    }
}
