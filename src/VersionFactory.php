<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\SemanticVersioning;

/**
 * Creates Version objects via static methods
 */
class VersionFactory
{
    public const REGEXP_INTEGER = '(\d+)';
    public const REGEXP_DOT_SEPARATED_IDENTIFIERS = '([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*)';

    public static function fromString(string $versionString): Version
    {
        $regexp = \sprintf(
            '/^%s\.%s\.%s(?:\-%s)?(?:\+%s)?$/',
            self::REGEXP_INTEGER,
            self::REGEXP_INTEGER,
            self::REGEXP_INTEGER,
            self::REGEXP_DOT_SEPARATED_IDENTIFIERS,
            self::REGEXP_DOT_SEPARATED_IDENTIFIERS
        );

        if (1 !== \preg_match($regexp, $versionString, $matches, PREG_UNMATCHED_AS_NULL)) {
            throw new \RuntimeException('Version string does not follow semantic versioning: ' . $versionString);
        }

        \array_shift($matches);

        return new Version(
            \intval($matches[0]),
            \intval($matches[1]),
            \intval($matches[2]),
            $matches[3] ?? null,
            $matches[4] ?? null
        );
    }

    public static function nextMajor(Version $version): Version
    {
        return new Version($version->getMajor() + 1, 0, 0);
    }

    public static function nextMinor(Version $version): Version
    {
        return new Version($version->getMajor(), $version->getMinor() + 1, 0);
    }

    public static function nextPatch(Version $version): Version
    {
        return new Version($version->getMajor(), $version->getMinor(), $version->getPatch() + 1);
    }
}
