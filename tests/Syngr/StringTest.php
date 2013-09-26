<?php
namespace Syngr;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2013-09-22 at 08:42:26.
 */
class StringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var String
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new String('foobar');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     */
    public function testGetInitialContent()
    {
        $this->assertEquals('foobar', $this->object);
    }

    /**
     * @covers Syngr\String::length()
     */
    public function testGetInitialLength()
    {
        $this->assertEquals(6, $this->object->length());
    }

    /**
     * @covers Syngr\String::join()
     */
    public function testJoin()
    {
        $data = array('foo', 'bar');
        $this->assertEquals(
            'foobar',
            $this->object->join('', $data)
        );
    }

    /**
     * @covers Syngr\String::join()
     */
    public function testJoinWithDelimiter()
    {
        $data = array('foo', 'bar');
        $this->assertEquals(
            'foo bar',
            $this->object->join(' ', $data)
        );
    }

    /**
     * @covers Syngr\String::Split()
     */
    public function testSplitByLength()
    {
        $this->assertCount(2, $this->object->split(3));
    }

    /**
     * @covers Syngr\String::Split()
     */
    public function testSplitByDelimiter()
    {
        $this->object = new String('foo:bar');
        $this->assertCount(2, $this->object->split(':'));
    }

    /**
     * @covers                   Syngr\String::Split()
     * @expectedException        Exception
     * @expectedExceptionMessage Invalid delimiter/length given
     */
    public function testSplitWithInvalidSplitterException()
    {
        $this->object->split(array());
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatch()
    {
        $this->assertTrue($this->object->match('foobar'));
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchFailure()
    {
        $this->assertFalse($this->object->match('FOOBAR'));
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchCaseInsensitive()
    {
        $this->assertTrue(
            $this->object->match('FOOBAR', array(String::CASE_INSENSITIVE))
        );
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchCaseInsensitiveFailure()
    {
        $this->assertFalse(
            $this->object->match('WEEFAW', array(String::CASE_INSENSITIVE))
        );
    }

    /**
     * @covers Syngr\String::match()
     * @expectedException Exception
     * @expectedExceptionMessage Cannot match (integer) 666 with string
     */
    public function testMatchWithNonStringException()
    {
        $this->object->match(666);
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchNaturalOrder()
    {
        $this->object = new String('img1');
        $this->assertTrue(
            $this->object->match('img1', array(String::ORDER_NATURAL))
        );
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchNaturalOrderFailure()
    {
        $this->object = new String('img1');
        $this->assertFalse(
            $this->object->match('img2', array(String::ORDER_NATURAL))
        );
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchNaturalOrderCaseInsensitive()
    {
        $this->object = new String('img1');
        $this->assertTrue(
            $this->object->match(
                'IMG1',
                array(String::CASE_INSENSITIVE, String::ORDER_NATURAL)
            )
        );
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchNaturalOrderCaseInsensitiveFailure()
    {
        $this->object = new String('img1');
        $this->assertFalse(
            $this->object->match(
                'IMG2',
                array(String::CASE_INSENSITIVE, String::ORDER_NATURAL)
            )
        );
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchWithRegex()
    {
        $this->assertTrue($this->object->match('/oob/'));
    }

    /**
     * @covers Syngr\String::match()
     */
    public function testMatchWithRegexFailure()
    {
        $this->assertFalse($this->object->match('/xyz/'));
    }

    /**
     * @covers Syngr\String::utf8_encode()
     */
    public function testUtf8Encode()
    {
        $this->object = new String('Kissa käveli öisellä kadulla');
        $this->assertEquals(
            'Kissa kÃ¤veli Ã¶isellÃ¤ kadulla',
            $this->object->utf8_encode()
        );
    }

    /**
     * @covers Syngr\String::utf8_decode()
     */
    public function testUtf8Decode()
    {
        $this->object = new String('Kissa kÃ¤veli Ã¶isellÃ¤ kadulla');
        $this->assertEquals(
            'Kissa käveli öisellä kadulla',
            $this->object->utf8_decode()
        );
    }

    /**
     * @covers Syngr\String::hash()
     */
    public function testHash()
    {
        $this->assertEquals(
            '3858f62230ac3c915f300c664312c63f',
            $this->object->hash()
        );
    }

    /**
     * @covers Syngr\String::bcrypt()
     */
    public function testBcrypt()
    {
        if (!function_exists('password_hash')) {
            $this->markTestSkipped(
                'The password_hash() function is not available'
            );
        }
        else {
            $hash = $this->object->bcrypt();
            $this->assertEquals($hash, crypt('foobar', $hash));
        }
    }

    /**
     * @covers Syngr\String::hash()
     */
    public function testHashWithSha1()
    {
        $this->assertEquals(
            '8843d7f92416211de9ebb963ff4ce28125932878',
            $this->object->hash('sha1')
        );
    }

    /**
     * @covers Syngr\String::html_decode()
     */
    public function testHtml_decode()
    {
        $this->object = new String(
            "I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now"
        );
        $this->assertEquals(
            "I'll \"walk\" the <b>dog</b> now",
            (string) $this->object->html_decode()
        );
    }

    /**
     * @covers Syngr\String::html_encode()
     */
    public function testHtml_encode()
    {
        $this->object = new String(
            "I'll \"walk\" the <b>dog</b> now"
        );
        $this->assertEquals(
            "I'll &quot;walk&quot; the &lt;b&gt;dog&lt;/b&gt; now",
            (string) $this->object->html_encode()
        );
    }

    /**
     * @covers Syngr\String::substring
     */
    public function testSubstring()
    {
        $this->assertStringEndsWith(
            'bar',
            (string) $this->object->substring(2));
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrim()
    {
        $this->object = new String('   foobar   ');
        $this->assertEquals(
            'foobar',
            $this->object->trim());
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrimLeft()
    {
        $this->object = new String('   foobar   ');
        $this->assertEquals(
            'foobar   ',
            $this->object->trim(' ', array(String::STRING_LEFT))
        );
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrimRight()
    {
        $this->object = new String('   foobar   ');
        $this->assertEquals(
            '   foobar',
            $this->object->trim(' ', array(String::STRING_RIGHT))
        );
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrimCharacters()
    {
        $this->object = new String('$$$foobar£££');
        $this->assertEquals(
            'foobar',
            $this->object->trim('$£')
        );
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrimCharactersLeft()
    {
        $this->object = new String('$$$foobar£££');
        $this->assertEquals(
            'foobar£££',
            $this->object->trim('$£', array(String::STRING_LEFT))
        );
    }

    /**
     * @covers Syngr\String::trim()
     */
    public function testTrimCharactersRight()
    {
        $this->object = new String('$$$foobar£££');
        $this->assertEquals(
            '$$$foobar',
            $this->object->trim('$£', array(String::STRING_RIGHT))
        );
    }

    /**
     * @covers Syngr\String::uppercase
     */
    public function testUppercase()
    {
        $this->assertEquals('FOOBAR', $this->object->uppercase());
    }

    /**
     * @covers Syngr\String::lowercase
     */
    public function testLowercase()
    {
        $this->object = new String('FOOBAR');
        $this->assertEquals('foobar', $this->object->lowercase());
    }

    /**
     * @covers Syngr\String::pad()
     */
    public function testPad()
    {
        $this->assertEquals(
            'foobar   ',
            $this->object->pad(3)
        );
    }

    /**
     * @covers Syngr\String::pad()
     */
    public function testPadLeft()
    {
        $this->assertEquals(
            '   foobar',
            $this->object->pad(3, ' ', array(String::STRING_LEFT))
        );
    }

    /**
     * @covers Syngr\String::pad()
     */
    public function testPadBoth()
    {
        $this->assertEquals(
            '  foobar  ',
            $this->object->pad(4, ' ', array(String::STRING_BOTH))
        );
    }

    /**
     * @covers Syngr\String::pad()
     */
    public function testPadCharacters()
    {
        $this->assertEquals(
            'foobar####',
            $this->object->pad(4, '#')
        );
    }

    /**
     * @covers Syngr\String::reverse()
     */
    public function testReverse()
    {
        $this->assertEquals('raboof', $this->object->reverse());
    }

    /**
     * @covers Syngr\String::replace()
     */
    public function testReplaceWithString()
    {
        $this->assertEquals('feebar', $this->object->replace('oo', 'ee'));
    }

    /**
     * @covers Syngr\String::replace()
     */
    public function testReplaceWithCaseInsensitiveString()
    {
        $this->assertEquals(
            'feebar',
            $this->object->replace(
                'OO',
                'ee',
                array(String::CASE_INSENSITIVE)
            )
        );
    }

    /**
     * @covers Syngr\String::replace()
     */
    public function testReplaceWithRegex()
    {
        $this->assertEquals(
            'foujar',
            $this->object->replace('/ob/', 'uj')
        );
    }

    /**
     * @covers Syngr\String::is_regex()
     */
    public function testIs_regex()
    {
        $this->assertTrue(
            $this->object->is_regex('/^#?([a-f0-9]{6}|[a-f0-9]{3})$/ ')
        );
        // $this->markTestIncomplete('Not yet implemented');
    }

    /**
     * @covers Syngr\String::is_regex()
     */
    public function testIs_regexFailure()
    {
        $this->assertFalse(
            $this->object->is_regex(22)
        );
    }

}
