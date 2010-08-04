<?php

class fpFileManager
{
  /**
   * 
   * @var fpFileManager
   */
  protected static $_instance;
  
  /**
   * 
   * @var fpTempFolder
   */
  protected $_tempFolder;
  
  protected function __construct()
  {
    $this->_tempFolder = new fpTempFolder();
  }
  
  public function __clone() {}
  
  /**
   * 
   * @param sfValidatedFile $validatedFile
   * 
   * @return fpFile
   */
  public function convertSfValidatedFile(sfValidatedFile $validatedFile)
  {
    $fpFileSource = new fpFile($validatedFile->getTempName());
    $fpFileTarger = new fpFile($this->_tempFolder.'/'.$validatedFile->getOriginalName());
    
    $fpFileSource->copy($fpFileTarger);
    
    return $fpFileTarger;
  }
  
  /**
   * @return fpFileManager
   */
  public static function getInstance()
  {
    self::$_instance || self::$_instance = new self();
    
    return self::$_instance;
  }
}