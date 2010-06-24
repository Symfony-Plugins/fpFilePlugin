<?php

class fpNotExistFileTestCase extends sfBasePhpunitTestCase
  implements sfPhpunitFixturePropelAggregator
{
  public function testConstructNotRequierAnyParameters()
  {
    new NotExistFile();
  }
  
  public function testExistAlwaysReturnsFalse()
  {
    $file = new NotExistFile();
    $this->assertFalse($file->exists());
    
    $file = new NotExistFile($this->fixture()->getFilePackage('linux_rulez.gif.zip'));
    $this->assertFalse($file->exists());
  }
  
  /**
   * @dataProvider providerFileMethods
   * 
   * @expectedException LogicException
   */
  public function testOtherMethodsWillThrowAnException($method, $args)
  {
    $file = new NotExistFile();
    
    call_user_func_array(array($file, $method), $args);
  }
  
  public static function providerFileMethods()
  {
    return array(
      array('copy',       array('target_file')),
      array('getFolder',  array()),
      array('getPath',    array()),
      array('move',       array('target_file')));
  }
  
  public function testRemoveDoNothing()
  {
    $file = new NotExistFile();
    $result = $file->remove();
    
    $this->assertSame($file, $result);
  }

  public function testChmodDoNothing()
  {
    $file = new NotExistFile();
    $result = $file->chmod(0777);
    
    $this->assertSame($file, $result);
  }
}