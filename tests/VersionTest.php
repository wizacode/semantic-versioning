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
        $this->assertSame(1, $version->getMajor());
        $this->assertSame(2, $version->getMinor());
        $this->assertSame(3, $version->getPatch());
        $this->assertNull($version->getPrerelease());
        $this->assertSame([], $version->getPrereleaseIdentifiers());
        $this->assertNull($version->getBuild());
        $this->assertSame([], $version->getBuildIdentifiers());
    }

    public function testVersionPreRelease()
    {
        $version = new Version(1, 0, 0, 'alpha.1');
        $this->assertSame(1, $version->getMajor());
        $this->assertSame(0, $version->getMinor());
        $this->assertSame(0, $version->getPatch());
        $this->assertSame('alpha.1', $version->getPrerelease());
        $this->assertSame(['alpha', '1'], $version->getPrereleaseIdentifiers());
    }

    public function testVersionBuild()
    {
        $version = new Version(1, 0, 0, null, '20130313144700');
        $this->assertSame(1, $version->getMajor());
        $this->assertSame(0, $version->getMinor());
        $this->assertSame(0, $version->getPatch());
        $this->assertNull($version->getPrerelease());
        $this->assertSame([], $version->getPrereleaseIdentifiers());
        $this->assertSame('20130313144700', $version->getBuild());
        $this->assertSame(['20130313144700'], $version->getBuildIdentifiers());
    }

    public function testVersionPrereleaseBuild()
    {
        $version = new Version(1, 0, 0, 'beta', 'exp.sha.5114f85');
        $this->assertSame(1, $version->getMajor());
        $this->assertSame(0, $version->getMinor());
        $this->assertSame(0, $version->getPatch());
        $this->assertSame('beta', $version->getPrerelease());
        $this->assertSame(['beta'], $version->getPrereleaseIdentifiers());
        $this->assertSame('exp.sha.5114f85', $version->getBuild());
        $this->assertSame(['exp', 'sha', '5114f85'], $version->getBuildIdentifiers());
    }

    public function testVersionEmptyString()
    {
        $version = new Version(1, 0, 0, '', '');
        $this->assertSame(1, $version->getMajor());
        $this->assertSame(0, $version->getMinor());
        $this->assertSame(0, $version->getPatch());
        $this->assertNull($version->getPrerelease());
        $this->assertSame([], $version->getPrereleaseIdentifiers());
        $this->assertNull($version->getBuild());
        $this->assertSame([], $version->getBuildIdentifiers());
    }

    public function testCompareTo()
    {
        $this->assertEquals(-1, (new Version(1, 0, 0))->compareTo(new Version(2, 0, 0)));
        $this->assertEquals(-1, (new Version(2, 0, 0))->compareTo(new Version(2, 1, 0)));
        $this->assertEquals(-1, (new Version(2, 1, 0))->compareTo(new Version(2, 1, 1)));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'alpha'))->compareTo(new Version(1, 0, 0)));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'alpha'))->compareTo(new Version(1, 0, 0, 'alpha.1')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'alpha.1'))->compareTo(new Version(1, 0, 0, 'alpha.beta')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'alpha.beta'))->compareTo(new Version(1, 0, 0, 'beta')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'beta'))->compareTo(new Version(1, 0, 0, 'beta.2')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'beta.2'))->compareTo(new Version(1, 0, 0, 'beta.11')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'beta.11'))->compareTo(new Version(1, 0, 0, 'rc.1')));
        $this->assertEquals(-1, (new Version(1, 0, 0, 'rc.1'))->compareTo(new Version(1, 0, 0)));
    }
}
