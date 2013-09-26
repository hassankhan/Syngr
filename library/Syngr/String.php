<?php
/**
 * String Class
 *
 * This really ought to be updated to use mb_()-style methods,
 * would bake UTF-8 support in like it ain't no thang.
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
    public function __construct($string = null)
    {
        parent::__construct($string);
    }

    /**
     * Overrides __toString()
     * @return string - String representation of data
     */
    public function __toString()
    {
        return $this->content;
    }

    /**
     * Gets length of string
     * @return int - The length of the string
     */
    public function length()
    {
        return strlen($this->content);
    }

    // Currently replaces current content with new data
    // should this be expected behaviour
    // think of use cases
    // EDIT : Maybe it belongs in the array class?
    public function join($delimiter = '', $data)
    {
        return new String(implode($delimiter, $data));
    }

    // For greater flexibility, make this work with regex too
    public function split($splitter)
    {
        $text = $this->content;
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
        $string            = $this->content;

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
        return new String(utf8_encode($this->content));
    }

    public function utf8_decode()
    {
        return new String(utf8_decode($this->content));
    }

    /**
     * Returns a hash of the current string in the specified algorithm
     * @param  string $algorithm - By default, is set to 'MD5'.
     * @return string            - The result of the hashing function
     */
    public function hash($algorithm = 'MD5')
    {
        return new String(hash($algorithm, $this->content));
    }

    /**
     * Returns a blowfish encrypted string. This is a adaptation of
     * ircmaxwell's password_compat library
     * @param integer $cost     - The cost of the operation
     * @return \Syngr\String
     */
    public function bcrypt($cost = 13) {
        $string = $this->content;

        if (function_exists('password_hash')) {
            $string = password_hash(
                $string,
                PASSWORD_BCRYPT,
                array('cost' => $cost)
            );

        }
        else {
            if ($cost < 4 || $cost > 31) {
                trigger_error(
                    sprintf(
                        'password_hash(): Invalid bcrypt cost parameter specified: %d',
                        $cost
                    ),
                    E_USER_WARNING
                );
                return null;
            }
            // The length of salt to generate
            $raw_salt_len = 16;
            // The length required in the final serialization
            $required_salt_len = 22;
            $hash_format = sprintf("$2y$%02d$", $cost);

            $buffer = '';
            $buffer_valid = false;
            if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
                $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
                if ($buffer) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
                $buffer = openssl_random_pseudo_bytes($raw_salt_len);
                if ($buffer) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid && is_readable('/dev/urandom')) {
                $f = fopen('/dev/urandom', 'r');
                $read = strlen($buffer);
                while ($read < $raw_salt_len) {
                    $buffer .= fread($f, $raw_salt_len - $read);
                    $read = strlen($buffer);
                }
                fclose($f);
                if ($read >= $raw_salt_len) {
                    $buffer_valid = true;
                }
            }
            if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
                $bl = strlen($buffer);
                for ($i = 0; $i < $raw_salt_len; $i++) {
                    if ($i < $bl) {
                        $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                    } else {
                        $buffer .= chr(mt_rand(0, 255));
                    }
                }
            }

            $salt = str_replace('+', '.', base64_encode($buffer));
            $salt = substr($salt, 0, $required_salt_len);
            $hash = $hash_format . $salt;
            $string = crypt($string, $hash);

            return new String($string);
        }
    }

    public function html_decode()
    {
        return new String(html_entity_decode($this->content));
    }

    public function html_encode()
    {
        return new String(htmlentities($this->content));
    }

    /**
     * Returns portion of the string
     * @param  int $start  - Starting index of substring
     * @param  int $length - Length of substring
     * @return String      - Returns current instance for method chaining
     */
    public function substring($start, $length = null)
    {
        $string = $this->content;
        $length = $length === null ? strlen($string) : $length;
        return new String(substr($string, $start, $length));
    }

    public function trim($delimiter = ' ', $flags = array())
    {
        $text = $this->content;
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

        return new String($text);
    }

    /**
     * Switches all characters in string into uppercase
     * @return String - Returns current instance for method chaining
     */
    public function uppercase()
    {
        return new String(strtoupper($this->content));
    }

    /**
     * Switches all characters in string into lowercase
     * @return String - Returns current instance for method chaining
     */
    public function lowercase()
    {
        return new String(strtolower($this->content));
    }

    public function pad($length, $delimiter = ' ', $flags = array())
    {
        $text = $this->content;
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
        return new String($text);
    }

    /**
     * Reverses the order of characters in a string
     * @return String - Returns current instance for method chaining
     */
    public function reverse()
    {
        return new String(strrev($this->content));
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
        $text = $this->content;
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
        return new String($text);
    }

    /**
     * Validates regular expressions with different (mostly-used) delimiters
     * and afterwards applies a hook to check if its valid
     * @param  string  $regex - The string to be validated as regex
     * @return boolean        - Returns true if valid regex, otherwise false
     * @author AlexanderC <self@alexanderc.me>
     */
    public function is_regex($regex)
    {
        return 1 === preg_match("/^(\/|#|~|%|@|!).+(\/|#|~|%|@|!)(i|m|s|x|u|j)*$/ui", trim($regex))
            && false !== @preg_match($regex, '');
    }
}
