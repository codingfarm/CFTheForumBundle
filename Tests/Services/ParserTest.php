<?php
namespace CF\TheForumBundle\Services;

class ParserTest extends \PHPUnit_Framework_TestCase
{

    private $parser;

    protected function setUp()
    {
        $this->parser = new Parser();
    }

    public function testBbcode()
    {
        $bbcode = "Hello [b]world[/b]!";
        $expect = "Hello <strong>world</strong>!";
        $this->assertEquals($expect, $this->parser->bbcode($bbcode));
        $bbcode = "Hello [b]world!";
        $expect = "Hello world!";
        $this->assertEquals($expect, $this->parser->bbcode($bbcode));
        $bbcode = "Hello world[/b]!";
        $expect = "Hello world!";
        $this->assertEquals($expect, $this->parser->bbcode($bbcode));

        $bbcode = "Hello [i]world[/i]!";
        $expect = "Hello <em>world</em>!";
        $this->assertEquals($expect, $this->parser->bbcode($bbcode));
    }
}