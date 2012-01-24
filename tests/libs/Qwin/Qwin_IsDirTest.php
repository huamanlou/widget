<?php

require_once dirname(__FILE__) . '/../../../libs/Qwin.php';
require_once dirname(__FILE__) . '/../../../libs/Qwin/IsDir.php';

/**
 * Test class for Qwin_IsDir.
 * Generated by PHPUnit on 2012-01-18 at 09:10:20.
 */
class Qwin_IsDirTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Qwin_IsDir
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Qwin_IsDir;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Qwin_IsDir::call
     * @covers Qwin_IsDir::__construct
     */
    public function testCall() {
        $object = $this->object;

        $this->assertEquals(false, $object->isDir(), 'Not File path');

        $object->source = __DIR__;

        $this->assertEquals($object->isDir(), __DIR__, 'File found');

        $object->source = '.file not found';

        $this->assertFalse($object->isDir(), 'File not found');

        $path = array_pop(explode(PATH_SEPARATOR, ini_get('include_path')));
        $files = scandir($path);
        foreach ($files as $file) {
            if ('.' == $file || '..' == $file) {
                continue;
            }
            if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                var_dump($path . DIRECTORY_SEPARATOR . $file);
                var_dump($file);
                $object->source = $file;
                $this->assertNotEquals(false, $object->isDir(), 'File in include path found');
                break;
            }
        }

        if (!function_exists('stream_resolve_include_path')) {
            function stream_resolve_include_path($param) {
                if ('.file not found' == $param) {
                    return false;
                } else {
                    return 'file found.';
                }
            }

            $this->assertNotEquals(false, $object->isDir(), 'File in include path found');

            $object->source = '.file not found';

            $this->assertFalse($object->isDir(), 'File in include path found');
        }
    }

}

?>
