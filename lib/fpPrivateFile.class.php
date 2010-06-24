<?php

class fpPrivateFile extends fpFile
{
  public function __construct($path)
  {
    if (strpos($path, sfConfig::get('sf_web_dir')) !== false) {
      throw new LogicException('The private file `'.$path.'` cannot be stored in public folder `'.sfConfig::get('sf_web_dir').'`. It is very unsecure');
    }
    
    return parent::__construct($path);
  }
  
  /**
   * 
   * @return string 
   */
  public function getUrl()
  {
    return $this->generatePublicLink()->getUrl();
  }
  
  /**
   * @return PublicFile
   */
  public function generatePublicLink()
  {
    $linkName = $this->_generatePublicLinkName();

    $link = new PublicFile(
      sfConfig::get('app_web_dir').'/static/temporary/'.$linkName);
      
    if ($link->exists()) {
      throw new Exception('The file with the same name as generated link `'.$link.'` exist. This would never happend or cron task does not clean downlaod links periodicaly');
    }
    
  //  $link->getFolder()->chmod(0777, true);
    chdir($link->getFolder());
    
    if (!@symlink($this, $link)) {
      throw new Exception('Cannot create a symlink `'.$link.'` to the publication `'.$this.'`');
    }
    
    //$link->chmod(0666);

    return $link;
  }

  /**
   *
   * @return string 
   */
  protected function _generatePublicLinkName()
  {
    $ext = pathinfo($this->_getPath(), PATHINFO_EXTENSION);
    $fileName = pathinfo($this->_getPath(), PATHINFO_FILENAME);
    $dirs = explode('/', pathinfo($this->_getPath(), PATHINFO_DIRNAME));
    $dirName = array_pop($dirs);

    return $dirName.'-'.$fileName.'-'.md5(
      rand(1000000, 10000000) . 
      time() . 
      $this->getPath() . 
      rand(1000000, 10000000)) . '.' . $ext;
  }
}