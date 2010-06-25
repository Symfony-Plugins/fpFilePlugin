<?php

class fpPublicFileTestCase extends sfBasePhpunitTestCase
{
  /**
   * @expectedException fpFileException
   */
  public function testGetUrlInvalidPublicPath()
  {
    $file = new fpPublicFile(sfConfig::get('sf_root_dir'));
    $file->getUrl();
  }
  
  public function testConstructValidAbsolutePublicPath()
  {
    $file = new fpPublicFile(sfConfig::get('sf_web_dir').'/index.php');
    
    $this->assertEquals(sfConfig::get('sf_web_dir').'/index.php', $file->getPath());
    $this->assertEquals('/index.php', $file->getUrl());
  }
  
  public function testConstructValidRelativePublicPath()
  {
    $file = new fpPublicFile('index.php');
    
    $this->assertEquals(sfConfig::get('sf_web_dir').'/index.php', $file->getPath());
    $this->assertEquals('/index.php', $file->getUrl());
  }
}