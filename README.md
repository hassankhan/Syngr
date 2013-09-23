# Syngr [![Build Status](https://travis-ci.org/hassankhan/Syngr.png?branch=master)](https://travis-ci.org/hassankhan/Syngr) [![Coverage Status](https://coveralls.io/repos/hassankhan/Syngr/badge.png)](https://coveralls.io/r/hassankhan/Syngr)

    Syngr : Syntactic Sugar

This project is an effort to consolidate PHP's wildly varying functions, and provide some sort of Standard Library for it.

## Usage

The idea is to make programming in PHP simpler, and force it to behave in a more predictable manner. Most, if not all, methods for these types all operate on the object itself, which gives us a nice side-benefit of being able to chain multiple methods on an object.

### String methods

    $string = new String('hello world');
    echo $string->uppercase()
                ->substring(0, 6)
                ->replace(' ', '?')
                ->trim('?');

    // Should print out
    // HELLO

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

#### Algebraic functions
    absolute()
    ceiling()
    floor()
    round()
    max()
    min()
    sqrt()

#### Conversions

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

1. _What dependencies does it have (where are they expressed) and how do I install them?_
2. _How can I see the project working before I change anything?_

## Testing

_How do I run the project's automated tests?_

### Unit Tests

1. ``phpunit``

### Integration Tests

1. _Run other local services / provide credentials for external services._
2. `rake spec:integration`

## Deploying

### _How to setup the deployment environment_

- _Required heroku addons, packages, or chef recipes._
- _Required environment variables or credentials not included in git._
- _Monitoring services and logging._

### _How to deploy_

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
