<?php

class fpPublicFolderTestCase extends sfBasePhpunitTestCase
{
  protected $_absolutePath;
  
  protected $_relativePath;
  
  protected function _start()
  {
    $this->_relativePath = __CLASS__;
    $this->_absolutePath = sfConfig::get('app_web_dir').'/'.$this->_relativePath;
    if (!file_exists($this->_absolutePath)) {
      mkdir($this->_absolutePath);
    }
  }
  
  protected function _end()
  {
    if (file_exists($this->_absolutePath)) {
      $f = new fpFolder($this->_absolutePath);
      $f->remove();
    }
  }

  public function testConstructNotExistPath()
  {
    $expectedFolderName = preg_replace('/[^\w]/', '_', __METHOD__);
    $expectedFolder = sfConfig::get('app_web_dir').'/'.$expectedFolderName;
    file_exists($expectedFolder) && rmdir($expectedFolder);
    
    $folder = new fpPublicFolder($expectedFolderName);
    
    $this->assertEquals($expectedFolder, $folder->getPath());
    $this->assertTrue(file_exists($expectedFolder));
    
    file_exists($expectedFolder) && rmdir($expectedFolder);
  }
  
  public function testConstructValidAbsolutePath()
  {     
    $folder = new fpPublicFolder($this->_absolutePath);
    
    $this->assertEquals($this->_absolutePath, $folder->getPath());
  }
  
  public function testConstructValidAppRelativePublicPath()
  {
    $folder = new fpPublicFolder($this->_relativePath);
    
    $this->assertEquals($this->_absolutePath, $folder->getPath());
  }
  
  public function testConstructForEmptyPathReturnsRootPublicFolder()
  {     
    $folder = new fpPublicFolder();
    
    $this->assertEquals(sfConfig::get('app_web_dir'), $folder->getPath());
  }
  
  /**
   * @depends testConstructForEmptyPathReturnsRootPublicFolder
   */
  public function testGetUrl()
  {
    $folder = new fpPublicFolder();
    
    $this->assertEquals('/test', $folder->getUrl());
  }
}