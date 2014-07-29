<?php

class contributions{

  const QUERY_INTERTWINED_CONTRIBS = 'select rev_id, rev_user_text,page_title, rev_timestamp FROM revision_userindex, page WHERE (rev_user_text = ? or rev_user_text = ?) AND page_id=rev_page order by rev_id desc limit 1000';

  public $loaded= false;
  public $user;
  public $intertwineduser;
  public $contributions;
  private $connection;

  function __construct($aConnection, $aName)
  {
    $this->connection = $aConnection;
    $this->user = $aName;
  }
  
  public function getIntertwinedContribs($aName)
  {
    $this->intertwineduser = $aName;
    
    $result = $this->connection->execute(contributions::QUERY_INTERTWINED_CONTRIBS,array($this->user, $this->intertwineduser));
    if ($result != NULL){
      foreach ($result as $row)
      {
        $this->contributions[$row['rev_id']]= array($row['rev_user_text'],$row['page_title'],$row['rev_timestamp']);
      }
      $this->loaded = true;
    }

  }
  
  public function printIntertwinedContribs()
  {
    if ($this->loaded){
      foreach($this->contributions as $key => $value)
      {
        echo ' User:'.$value[0].' Page : '.$value[1].' Timestamp :'.$value[2].'<br/>';
      }
    }else
    {
      echo 'Not loaded...';
    }
  
  }

}

?>
