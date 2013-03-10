<?php

namespace WidgetTest\Validator;

class PhoneTest extends TestCase
{
    /**
     * @dataProvider providerForPhone
     */
    public function testPhone($input)
    {
        $this->assertTrue($this->is('phone', $input));
        
        $this->assertFalse($this->is('notPhone', $input));
    }

    /**
     * @dataProvider providerForNotPhone
     */
    public function testNotPhone($input)
    {
        $this->assertFalse($this->is('phone', $input));
        
        $this->assertTrue($this->is('notPhone', $input));
    }

    public function providerForPhone()
    {
        return array(
            array('020-1234567'),
            array('0768-123456789'),
            // Phone number without city code
            array('1234567'),
            array('123456789'),
        );
    }

    public function providerForNotPhone()
    {
        return array(
            array('012345-1234567890'),
            array('010-1234567890'),
            array('123456'),
            array('not digit'),
        );
    }
}