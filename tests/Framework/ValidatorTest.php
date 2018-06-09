<?php
/**
 * Created by IntelliJ IDEA.
 * User: meg4r0m
 * Date: 09/06/18
 * Time: 10:23
 */

namespace Tests\Framework;

use App\Framework\Validator;
use Tests\DatabaseTestCase;

/**
 * Class ValidatorTest
 * @package Tests\Framework
 */
class ValidatorTest extends DatabaseTestCase
{

    /**
     * @param array $params
     * @return Validator
     */
    private function makeValidator(array $params)
    {
        return new Validator($params);
    }

    /**
     *
     */
    public function testRequiredIfFail()
    {
        $errors = $this->makeValidator(['name' => 'joe'])
            ->required('name', 'content')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    /**
     *
     */
    public function testNotEmpty()
    {
        $errors = $this->makeValidator(['name' => 'joe', 'content' => ''])
            ->notEmpty('content')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    /**
     *
     */
    public function testRequiredIfSuccess()
    {
        $errors = $this->makeValidator(['name' => 'joe', 'content' => 'content'])
            ->required('name', 'content')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    /**
     *
     */
    public function testSlugSuccess()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-azeaze34',
            'slug2' => 'azeaze'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->getErrors();
        $this->assertCount(0, $errors);
    }

    /**
     *
     */
    public function testSlugError()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-aze-azeAze34',
            'slug2' => 'aze-aze_azeAze34',
            'slug3' => 'aze-aze_azeAze34-',
            'slug4' => 'aze--aze-azeaze34'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->slug('slug4')
            ->getErrors();
        $this->assertEquals(['slug', 'slug2', 'slug3', 'slug4'], array_keys($errors));
    }

    /**
     *
     */
    public function testLength()
    {
        $params = ['slug' => '123456789'];
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3)->getErrors());
        $errors = $this->makeValidator($params)->length('slug', 12)->getErrors();
        $this->assertCount(1, $errors);
        $this->assertCount(1, $this->makeValidator($params)->length('slug', 3, 4)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', 3, 20)->getErrors());
        $this->assertCount(0, $this->makeValidator($params)->length('slug', null, 20)->getErrors());
        $this->assertCount(1, $this->makeValidator($params)->length('slug', null, 8)->getErrors());
    }

    /**
     *
     */
    public function testDateTime()
    {
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(0, $this->makeValidator(['date' => '2012-12-12 00:00:00'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-12-12'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2012-21-12 11:12:13'])->dateTime('date')->getErrors());
        $this->assertCount(1, $this->makeValidator(['date' => '2013-02-29 11:12:13'])->dateTime('date')->getErrors());
    }

    /**
     *
     */
    public function testExists()
    {
        $pdo = $this->getPDO();
        $pdo->exec('CREATE TABLE test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255)
        )');
        $pdo->exec('INSERT INTO test (name) VALUES ("a1")');
        $pdo->exec('INSERT INTO test (name) VALUES ("a2")');
        $this->assertTrue($this->makeValidator(['category' => 1])->exists('category', 'test', $pdo)->isValid());
        $this->assertFalse($this->makeValidator(['category' => 123123])->exists('category', 'test', $pdo)->isValid());
    }

}