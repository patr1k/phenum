<?php
/**
 * @link    http://github.com/patr1k/phenum
 * @license http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Patr1k\Phenum;

/**
 * Enumeration Helper
 *
 * Verifies that a given value exists within an enumerated domain.
 */
trait Enum
{
    /**
     * @var array
     */
    private static $_enum_domains = [];

    /**
     * @param  string $domain
     * @return array
     */
    protected static function enumDomain($domain)
    {
        $domain = strtoupper($domain);

        if (!array_key_exists($domain, self::$_enum_domains)) {
            try {
                $mirror = new \ReflectionClass(static::class);
                self::$_enum_domains[$domain] = $mirror->getConstants();
            } catch ( \ReflectionException $e ) {
                self::$_enum_domains[$domain] = [];
            }
        }

        return self::$_enum_domains[$domain];
    }

    /**
     * @param  string $value
     * @param  string $domain
     * @return string
     * @throws DomainException
     */
    protected static function validateEnum($value, $domain)
    {
        foreach ( self::enumDomain($domain) as $k => $v ) {
            if ( $value === $v && 0 === strpos($k, $domain . '_') ) {
                return $value;
            }
        }

        throw new DomainException("Domain `{$domain}` does not contain value `{$value}`");
    }

    /**
     * Similar to above, but for when we just want to check validity of an input value without catching exceptions.
     *
     * @param  string $value
     * @param  string $domain
     * @return bool
     */
    protected static function isValidEnum($value, $domain)
    {
        return in_array($value, self::enumDomain($domain));
    }
}