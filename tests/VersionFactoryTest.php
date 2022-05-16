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
        static::assertEquals(new Version(1, 2, 3), VersionFactory::fromString('1.2.3'));
        static::assertEquals(new Version(1, 0, 0, 'alpha.1'), VersionFactory::fromString('1.0.0-alpha.1'));
        static::assertEquals(
            new Version(1, 0, 0, null, '20130313144700'),
            VersionFactory::fromString('1.0.0+20130313144700')
        );
        static::assertEquals(
            new Version(1, 0, 0, 'beta', 'exp.sha.5114f85'),
            VersionFactory::fromString('1.0.0-beta+exp.sha.5114f85')
        );
    }

    public function testNextMajor()
    {
        static::assertEquals(new Version(2, 0, 0), VersionFactory::nextMajor(new Version(1, 2, 3)));
    }

    public function testNextMinor()
    {
        static::assertEquals(new Version(1, 3, 0), VersionFactory::nextMinor(new Version(1, 2, 3)));
    }

    public function testNextPatch()
    {
        static::assertEquals(new Version(1, 2, 4), VersionFactory::nextPatch(new Version(1, 2, 3)));
    }

    public function testFromStringEmpty()
    {
        $this->expectException(RuntimeException::class);
        VersionFactory::fromString('');
    }
}
