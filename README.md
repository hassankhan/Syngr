# Syngr [![Build Status](https://travis-ci.org/hassankhan/Syngr.png?branch=master)](https://travis-ci.org/hassankhan/Syngr) [![Coverage Status](https://coveralls.io/repos/hassankhan/Syngr/badge.png)](https://coveralls.io/r/hassankhan/Syngr)

    Syngr : SYNtactic suGaR

This project is an effort to consolidate PHP's wildly varying functions, and provide some sort of Standard Library for it.

## Usage

The idea is to make programming in PHP simpler, and force it to behave in a more predictable manner. Most, if not all, methods for these types all operate on the object itself, which gives us a nice side-benefit of being able to chain multiple methods on an object.

### String methods

    $string = new String('hello world');
    echo $string->uppercase()       // HELLO WORLD
                ->substring(0, 6)   // HELLO
                ->replace(' ', '?') // HELLO?
                ->trim('?');        // HELLO

#### Array conversion
    join()
    split()

#### Comparison
    compare() // Change to match() after implementing preg_match()

#### Encoding

#### Hashing
    hash()

#### HTML

#### Searching

#### String Formatting

#### Substring
    substring()

#### Text Formatting
    trim()
    uppercase()
    lowercase()
    pad()
    length()
    reverse()
    replace()

### Number methods

    $number = new Number(6.9);
    echo $number->ceiling()              // 7
                ->max(array(5, 9, 49.1)) // 49.1
                ->floor()                // 49
                ->sqrt()                 // Value
                ->value();               // Get raw value rather than string

#### Algebraic functions
    absolute()
    ceiling()
    floor()
    round()
    max()
    min()
    sqrt()

#### Conversions
    convert()

#### Random
    random()

#### Transcendental functions
    exp()
    log()
    pow()

#### Trigonometric
    cos()
    sin()
    tan()


## Project Setup

Clone the project somewhere, ``cd`` to the directory and type in ``composer install``.

Syngr's dependencies are listed in the ``composer.json`` file, but if you're installing as a user then it has no extra dependencies (whoop!).

The best way to see Syngr in action is to look at the test code // Add an examples folder.

## Testing

### Unit Tests

Run ``phpunit`` from the terminal in the project folder to run unit tests.

### Integration Tests

1. _Run other local services / provide credentials for external services._
2. `rake spec:integration`

## Documentation

From the project folder, type in ``php vendor/bin/sami.php update gen-docs.php``. The documentation will be generated in a folder called 'docs'.

## Troubleshooting & Useful Tools

_Examples of common tasks_

> e.g.
>
> - How to make curl requests while authenticated via oauth.
> - How to monitor background jobs.
> - How to run the app through a proxy.

## Contributing changes

- _Internal git workflow_
- _Pull request guidelines_
- _Tracker project_
- _Google group_
- _irc channel_
- _"Please open github issues"_

## License
This project is licensed under the MIT License.
