<?php

namespace WidgetTest;

class LoggerTest extends TestCase
{
    //protected static $logger;
    
    /**
     * @var \Widget\Logger
     */
    protected $logger;
    
    protected function tearDown()
    {
        $this->object->clean();
     
        parent::tearDown();
        
        // TODO remove dir after test
//        $dir = static::$logger->getOption('dir');
//        if (is_dir($dir)) {
//            rmdir($dir);
//        }
    }
    
    public function testLog()
    {
        $logger = $this->object;

        $logger->debug(__METHOD__);

        $file = $logger->getFile();

        $this->assertContains(__METHOD__, file_get_contents($file));

        // clean all file in log diretory
        $logger->clean();

        $logger->setHandledLevel('info');

        $logger->debug(__METHOD__);
        
        $this->assertFileNotExists($file);
    }

    public function testGetFile()
    {
        $logger1 = new \Widget\Logger(array(
            'widget' => $this->widget,
            'fileSize' => 1,
        ));
        
        $logger1->debug(__METHOD__);
        
        $logger2 = new \Widget\Logger(array(
            'widget' => $this->widget,
            'fileSize' => 1,
        ));
        
        $logger2->debug(__METHOD__);
        
        $logger3 = new \Widget\Logger(array(
            'widget' => $this->widget,
            'fileSize' => 1,
        ));
        
        $logger3->debug(__METHOD__);
        
        $this->assertNotEquals($logger1->getFile(), $logger2->getFile());
    }
    
    public function testAllLevel()
    {
        $logger = $this->object;
        
        $logger->setHandledLevel('debug');

        $file = $logger->getFile();
        
        foreach ($logger->getOption('levels') as $level => $p) {
            $uid = uniqid();
            $logger->$level($uid);
            $this->assertContains($uid, file_get_contents($file));
        }
    }

    public function testFileSize()
    {
        $oldLogger = new \Widget\Logger(array(
            'widget' => $this->widget,
            'fileSize' => 1,
        ));
        
        $oldFile = $oldLogger->getFile();
        
        $oldLogger->debug(__METHOD__);

        $newLogger = new \Widget\Logger(array(
            'widget' => $this->widget,
            'fileSize' => 1,
        ));
        
        $newFile = $newLogger->getFile();

        $this->assertNotEquals($oldFile, $newFile);
    }
    
    public function testSetLevel()
    {
        $logger = $this->object;
        
        $file = $logger->getFile();
        
        $logger->setLevel('debug');
        
        // call by __invoke method
        $logger('no this level', __METHOD__);
        
        $this->assertContains('DEBUG', file_get_contents($file));
        
        $logger->clean();
        
        $logger->setLevel('info');
        
        // call by log method
        $logger->log('no this level', __METHOD__);
        
        $this->assertContains('INFO', file_get_contents($file));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testMkdirException()
    {
        $logger = $this->widget->newInstance('logger', array(
            'dir' => 'http://example/'
        ));
        $logger->getFile();
    }
}
