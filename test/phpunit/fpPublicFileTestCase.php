<?php

class fpPublicFileTestCase extends sfBasePhpunitTestCase
{
  /**
   * @expectedException Exception
   */
  public function testGetUrlInvalidPublicPath()
  {
    $file = new PublicFile(sfConfig::get('sf_root_dir'));
    $file->getUrl();
  }
  
  public function testConstructValidAbsolutePublicPath()
  {
    $file = new PublicFile(sfConfig::get('sf_web_dir').'/index.php');
    
    $this->assertEquals(sfConfig::get('sf_web_dir').'/index.php', $file->getPath());
    $this->assertEquals('/index.php', $file->getUrl());
  }
  
  public function testConstructValidRelativePublicPath()
  {
    $file = new PublicFile('index.php');
    
    $this->assertEquals(sfConfig::get('sf_web_dir').'/index.php', $file->getPath());
    $this->assertEquals('/index.php', $file->getUrl());
  }
}