<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

use PHPUnit\Framework\TestCase;
use Wizaplace\SemanticVersioning\Version;

class VersionTest extends TestCase
{
    public function testVersion()
    {
        $version = new Version(1, 2, 3);
        static::assertSame(1, $version->getMajor());
        static::assertSame(2, $version->getMinor());
        static::assertSame(3, $version->getPatch());
        static::assertNull($version->getPrerelease());
        static::assertSame([], $version->getPrereleaseIdentifiers());
        static::assertNull($version->getBuild());
        static::assertSame([], $version->getBuildIdentifiers());
        static::assertSame('1.2.3', $version->toString());
    }

    public function testVersionPreRelease()
    {
        $version = new Version(1, 0, 0, 'alpha.1');
        static::assertSame(1, $version->getMajor());
        static::assertSame(0, $version->getMinor());
        static::assertSame(0, $version->getPatch());
        static::assertSame('alpha.1', $version->getPrerelease());
        static::assertSame(['alpha', '1'], $version->getPrereleaseIdentifiers());
        static::assertSame('1.0.0-alpha.1', $version->toString());
    }

    public function testVersionBuild()
    {
        $version = new Version(1, 0, 0, null, '20130313144700');
        static::assertSame(1, $version->getMajor());
        static::assertSame(0, $version->getMinor());
        static::assertSame(0, $version->getPatch());
        static::assertNull($version->getPrerelease());
        static::assertSame([], $version->getPrereleaseIdentifiers());
        static::assertSame('20130313144700', $version->getBuild());
        static::assertSame(['20130313144700'], $version->getBuildIdentifiers());
        static::assertSame('1.0.0+20130313144700', $version->toString());
    }

    public function testVersionPrereleaseBuild()
    {
        $version = new Version(1, 0, 0, 'beta', 'exp.sha.5114f85');
        static::assertSame(1, $version->getMajor());
        static::assertSame(0, $version->getMinor());
        static::assertSame(0, $version->getPatch());
        static::assertSame('beta', $version->getPrerelease());
        static::assertSame(['beta'], $version->getPrereleaseIdentifiers());
        static::assertSame('exp.sha.5114f85', $version->getBuild());
        static::assertSame(['exp', 'sha', '5114f85'], $version->getBuildIdentifiers());
        static::assertSame('1.0.0-beta+exp.sha.5114f85', $version->toString());
    }

    public function testVersionEmptyString()
    {
        $version = new Version(1, 0, 0, '', '');
        static::assertSame(1, $version->getMajor());
        static::assertSame(0, $version->getMinor());
        static::assertSame(0, $version->getPatch());
        static::assertNull($version->getPrerelease());
        static::assertSame([], $version->getPrereleaseIdentifiers());
        static::assertNull($version->getBuild());
        static::assertSame([], $version->getBuildIdentifiers());
        static::assertSame('1.0.0', $version->toString());
    }

    public function testCompareTo()
    {
        static::assertEquals(-1, (new Version(1, 0, 0))->compareTo(new Version(2, 0, 0)));
        static::assertEquals(-1, (new Version(2, 0, 0))->compareTo(new Version(2, 1, 0)));
        static::assertEquals(-1, (new Version(2, 1, 0))->compareTo(new Version(2, 1, 1)));
        static::assertEquals(-1, (new Version(1, 0, 0, 'alpha'))->compareTo(new Version(1, 0, 0)));
        static::assertEquals(0, (new Version(1, 0, 0))->compareTo(new Version(1, 0, 0)));
        static::assertEquals(0, (new Version(1, 0, 0, 'alpha'))->compareTo(new Version(1, 0, 0, 'alpha')));
        static::assertEquals(1, (new Version(1, 0, 0))->compareTo(new Version(1, 0, 0, 'alpha')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'alpha'))->compareTo(new Version(1, 0, 0, 'alpha.1')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'alpha.1'))->compareTo(new Version(1, 0, 0, 'alpha.beta')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'alpha.beta'))->compareTo(new Version(1, 0, 0, 'beta')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'beta'))->compareTo(new Version(1, 0, 0, 'beta.2')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'beta.2'))->compareTo(new Version(1, 0, 0, 'beta.11')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'beta.11'))->compareTo(new Version(1, 0, 0, 'rc.1')));
        static::assertEquals(-1, (new Version(1, 0, 0, 'rc.1'))->compareTo(new Version(1, 0, 0)));
    }
}
