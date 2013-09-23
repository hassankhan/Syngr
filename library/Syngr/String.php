<?php
/**
 * String Class
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
     * @const string - Regex options
     */
    const REGEX_MATCH_ALL  = 'regex_match_all';
    const REGEX_RETURN     = 'regex_return';

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
        parent::__construct(array('content' => $string));
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

    // For greater flexibility, make this work with regex too
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

    public function match($match_string, $flags = array())
    {
        $string            = $this->getContent();

        // Regex
        if (is_string($match_string) && $this->is_regex($match_string)) {
            return preg_match($match_string, $string) === 1 ? true : false;
        }
        elseif (is_string($match_string)) {
            $comparison_result = 0;
            // Case-insensitive, natural order
            if (
                in_array(self::CASE_INSENSITIVE, $flags)
                &&
                in_array(self::ORDER_NATURAL, $flags)
            ) {
                $comparison_result = strnatcasecmp(
                    $string,
                    $match_string
                );
            }
            // Case-insensitive
            elseif (in_array(self::CASE_INSENSITIVE, $flags)) {
                $comparison_result = strcasecmp(
                    $string,
                    $match_string
                );
            }
            // Natural order
            elseif (in_array(self::ORDER_NATURAL, $flags)) {
                $comparison_result = strnatcmp(
                    $string,
                    $match_string
                );
            }
            // Case-sensitive
            else {
                $comparison_result = strcmp($string, $match_string);
            }
            return $comparison_result === 0 ? true : false;
        }
        else {
            throw new \Exception(
                "Cannot match ("
                    . gettype($match_string)
                    . ") {$match_string} with string"
            );
        }
    }

    public function utf8_encode()
    {
        $this->setContent(utf8_encode($this->getContent()));
        return $this;
    }

    public function utf8_decode()
    {
        $this->setContent(utf8_decode($this->getContent()));
        return $this;
    }

    /**
     * Returns a hash of the current string in the specified algorithm
     * @param  string $algorithm - By default, is set to 'MD5'.
     * @return string            - The result of the hashing function
     */
    public function hash($algorithm = 'MD5')
    {
        $this->setContent(hash($algorithm, $this->getContent()));
        return $this;
    }

    public function html_decode()
    {
        $this->setContent(html_entity_decode($this->getContent()));
        return $this;
    }

    public function html_encode()
    {
        $this->setContent(htmlentities($this->getContent()));
        return $this;
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
        return $this;
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
     * @param  array   $flags   - Optional flags
     * @return String           - Returns current instance for method chaining
     */
    // Need to add regex support
    public function replace($search, $replace, $flags = array())
    {
        $text = $this->getContent();
        if($this->is_regex($search)) {
            $text = preg_replace($search, $replace, $text);
        }
        else {
            if (in_array(self::CASE_INSENSITIVE, $flags)) {
                $text = str_ireplace($search, $replace, $text);
            }
            else {
                $text = str_replace($search, $replace, $text);
            }
        }
        $this->setContent($text);
        return $this;
    }

    /**
     * Crude method to check for valid regex
     * @param  string  $regex - The string to be validated as regex
     * @return boolean        - Returns true if valid regex, otherwise false
     */
    public function is_regex($regex)
    {
        return preg_match("/^\/|\/$/", $regex) === 1 ? true : false;
    }
}
