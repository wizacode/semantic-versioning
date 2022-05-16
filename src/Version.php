<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */

declare(strict_types=1);

namespace Wizaplace\SemanticVersioning;

/**
 * Represents a version in semantic versioning
 */
class Version
{
    private int $major;

    private int $minor;

    private int $patch;

    private ?string $prerelease;

    private ?string $build;

    public function __construct(int $major, int $minor, int $patch, ?string $prerelease = null, ?string $build = null)
    {
        $this->major = $major;
        $this->minor = $minor;
        $this->patch = $patch;
        $this->prerelease = $prerelease ?: null;
        $this->build = $build ?: null;
    }

    public function __toString()
    {
        $versionString = sprintf('%d.%d.%d', $this->major, $this->minor, $this->patch);

        if (null !== $this->prerelease) {
            $versionString .= '-' . $this->prerelease;
        }

        if (null !== $this->build) {
            $versionString .= '+' . $this->build;
        }

        return $versionString;
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function compareTo(Version $value): int
    {
        if ($this->major !== $value->major) {
            return $this->major <=> $value->major;
        }

        if ($this->minor !== $value->minor) {
            return $this->minor <=> $value->minor;
        }

        if ($this->patch !== $value->patch) {
            return $this->patch <=> $value->patch;
        }

        if (null === $this->prerelease || null === $value->prerelease) {
            if (null === $this->prerelease && null === $value->prerelease) {
                return 0;
            }

            return null === $this->prerelease ? 1 : -1;
        }

        $comparison = \array_filter(
            \array_map(function ($a, $b): int {
                if (\is_numeric($a) && \is_numeric($b)) {
                    return \intval($a) <=> \intval($b);
                }

                return $a <=> $b;
            }, $this->getPrereleaseIdentifiers(), $value->getPrereleaseIdentifiers())
        );

        return empty($comparison) ? 0 : \reset($comparison);
    }

    public function getMajor(): int
    {
        return $this->major;
    }

    public function getMinor(): int
    {
        return $this->minor;
    }

    public function getPatch(): int
    {
        return $this->patch;
    }

    public function getPrerelease(): ?string
    {
        return $this->prerelease;
    }

    /**
     * @return string[]
     */
    public function getPrereleaseIdentifiers(): array
    {
        return $this->prerelease ? \explode('.', $this->prerelease) : [];
    }

    public function getBuild(): ?string
    {
        return $this->build;
    }

    /**
     * @return string[]
     */
    public function getBuildIdentifiers(): array
    {
        return $this->build ? \explode('.', $this->build) : [];
    }
}
