<?php
namespace Tests\Framework\Validator;

use App\Framework\Validator\ValidationError;
use PHPUnit\Framework\TestCase;

class ValidationErrorTest extends TestCase
{


    public function testString()
    {
        $error    = new ValidationError('demo', 'fake', ['a1', 'a2']);
        $property = (new \ReflectionClass($error))->getProperty('messages');
        $property->setAccessible(true);
        $property->setValue($error, ['fake' => 'problem %2$s %3$s']);
        $this->assertEquals('problem a1 a2', (string) $error);
    }//end testString()


    public function testUnknownError()
    {
        $rule  = 'fake';
        $field = 'demo';
        $error = new ValidationError($field, $rule, ['a1', 'a2']);
        $this->assertContains($field, (string) $error);
        $this->assertContains($rule, (string) $error);
    }//end testUnknownError()
}//end class
