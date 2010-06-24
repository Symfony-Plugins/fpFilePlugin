<?php

class fpZipFileTestCase extends sfBasePhpunitTestCase
  implements sfPhpunitFixturePropelAggregator
{
  protected function _start()
  { 
    $test_dir = sfConfig::get('sf_cache_dir').'/test/phpunit-tmp'; 
    file_exists($test_dir) || mkdir($test_dir, 0777, true);
    file_exists($test_dir.'/linux_rulez.gif.zip') && unlink($test_dir.'/linux_rulez.gif.zip');
    file_exists($test_dir.'/linux_rulez.gif') && unlink($test_dir.'/linux_rulez.gif');
    
    copy($this->fixture()->getDirPackage().'/linux_rulez.gif.zip', $test_dir.'/linux_rulez.gif.zip');
    
    $this->_test_file = $test_dir.'/linux_rulez.gif.zip';
  }
  
  /**
   * @expectedException Exception
   */
  public function testFileHasInvalidExtension()
  {
    new ZipFile(__FILE__);
  }
  
  public function testFileHasValidExtension()
  {
    return new ZipFile($this->_test_file);
  }
  
  /**
   * @depends testFileHasValidExtension
   */
  public function testFileCanBeExtracted(ZipFile $file)
  {
    $test_dir = dirname($this->_test_file);
    
    $file->unzip($test_dir);
    
    $this->assertTrue(file_exists($test_dir.'/linux_rulez.gif'));
  }
}