<?php

namespace Patr1k\Phenum\Tests;

use PHPUnit\Framework\TestCase;
use Patr1k\Phenum;

final class EnumTest extends TestCase
{
    use Phenum\Enum;

    /**
     * @var string
     */
    public $gender;

    const GENDER_MALE        = 'M';
    const GENDER_FEMALE      = 'F';
    const GENDER_UNSPECIFIED = 'U';

    /**
     * Make sure enums are validated and saved
     */
    public function testDetectValidEnum()
    {
        $this->gender = self::validateEnum(self::GENDER_MALE, 'GENDER');
        $this->assertEquals(self::GENDER_MALE, $this->gender);

        $this->gender = self::validateEnum(self::GENDER_FEMALE, 'GENDER');
        $this->assertEquals(self::GENDER_FEMALE, $this->gender);

        $this->gender = self::validateEnum(self::GENDER_UNSPECIFIED, 'GENDER');
        $this->assertEquals(self::GENDER_UNSPECIFIED, $this->gender);
    }

    /**
     * Make sure invalid enum is detected and exception is thrown
     */
    public function testInvalidEnumException()
    {
        $this->expectException(Phenum\DomainException::class);
        $this->gender = self::validateEnum('A', 'GENDER');
    }

    /**
     * Make sure enum validation with bool response works
     */
    public function testBooleanValidation()
    {
        $this->assertTrue(self::isValidEnum(self::GENDER_MALE, 'GENDER'));
        $this->assertTrue(self::isValidEnum(self::GENDER_FEMALE, 'GENDER'));
        $this->assertTrue(self::isValidEnum(self::GENDER_UNSPECIFIED, 'GENDER'));
        $this->assertNotTrue(self::isValidEnum('A', 'GENDER'));
    }

    /**
     * Make sure domain keys/values can be retrieved
     */
    public function testGetDomainValues()
    {
        $expected_domain = [
            'GENDER_MALE'        => 'M',
            'GENDER_FEMALE'      => 'F',
            'GENDER_UNSPECIFIED' => 'U'
        ];

        $actual_domain = self::enumDomain('GENDER');

        $this->assertEquals($expected_domain, $actual_domain);
    }
}