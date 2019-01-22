<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

use PHPUnit\Framework\TestCase;
use Wizaplace\SemanticVersioning\Version;
use Wizaplace\SemanticVersioning\VersionFactory;

class VersionFactoryTest extends TestCase
{
    public function testFromString()
    {
        $this->assertEquals(new Version(1, 2, 3), VersionFactory::fromString('1.2.3'));
        $this->assertEquals(new Version(1, 0, 0, 'alpha.1'), VersionFactory::fromString('1.0.0-alpha.1'));
        $this->assertEquals(new Version(1, 0, 0, null, '20130313144700'), VersionFactory::fromString('1.0.0+20130313144700'));
        $this->assertEquals(new Version(1, 0, 0, 'beta', 'exp.sha.5114f85'), VersionFactory::fromString('1.0.0-beta+exp.sha.5114f85'));
    }

    public function testNextMajor()
    {
        $this->assertEquals(new Version(2, 0, 0), VersionFactory::nextMajor(new Version(1, 2, 3)));
    }

    public function testNextMinor()
    {
        $this->assertEquals(new Version(1, 3, 0), VersionFactory::nextMinor(new Version(1, 2, 3)));
    }

    public function testNextPatch()
    {
        $this->assertEquals(new Version(1, 2, 4), VersionFactory::nextPatch(new Version(1, 2, 3)));
    }
}
