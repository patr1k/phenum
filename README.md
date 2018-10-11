# Phenum - PHP Enumerator as a Trait

## How It Works
Unlike most enumerators which use an abstract class as a domain container, Phenum is a trait which can be attached to 
any class where the enumerated domain is expressed as constants.

### Advantages
- By representing enums using scalar constants rather than objects, this approach is slightly faster and more 
  memory efficient than OO-based approaches.
- Enums are more tightly coupled with the class to which they belong, which can make the code easier to read for 
  developers who are new to your project.

### Disadvantages
- Without using objects to represent enums, the auto-complete feature in your IDE won't know what the possible enum 
  values are for a given domain. You would need to know which class defines the domain values, then begin typing the 
  domain prefix to see the possible values.
```php
<?php
use Patr1k\Phenum;

class Person {
    use Phenum\Enum;
    
    /**
     * @var string
     */
    protected $gender;
    
    const GENDER_MALE        = 'M';
    const GENDER_FEMALE      = 'F';
    const GENDER_UNSPECIFIED = 'U';
    
    /**
     * @return string
     */
    public function getGender() {
        return $this->gender;
    }
    
    /**
     * @param  string $gender
     * @throws Phenum\DomainException
     */
    public function setGender($gender) {
        $this->gender = self::validateEnum($gender, 'GENDER');
    }
}
```

## Requirements
- PHP >= 5.6.0

## License
[MIT License](http://www.opensource.org/licenses/mit-license.php) *see LICENSE file*