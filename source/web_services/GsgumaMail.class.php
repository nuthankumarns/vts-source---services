<?php
//ini_set("display_errors", "1");
//error_reporting(E_ALL);
/**
  Class GsgumaMail
  
  @description    Simple class for sending e-mail's encoded in UTF-8
  @autor          Gilton Guma [Brasil]
  @contact        giltonguma[at]gmail[dot]com
  @website        http://www.gsguma.com.br
  @date           2009-08-04
*/
class VTSMail {
  private $_name;
  private $_mail;
  private $_subject;
  private $_message;

  public function __construct(){
    $this->_name    = "Unknown";
    $this->_mail    = NULL;
    $this->_subject = "Unknown";
    $this->_message = NULL;
  }

  //Var's settings
  public function setName($value)   { $this->_name = utf8_encode($value);           } //To name
  public function setMail($value)   { $this->_mail = utf8_encode($value);           } //To e-mail
  public function setSubject($value){ $this->_subject = utf8_encode($value);        } //Subjetc
  public function setMessage($value){ $this->_message = utf8_encode(nl2br($value)); } //Message

  /**
    Method sendMail
    
    @return {boolean} [true|false]
  */
  public function sendMail(){
    if (!$this->_mail || !$this->_message) return false;
//ini_set("From", $this->from);

   // $domain  = utf8_encode(str_replace("www.","",$_SERVER['SERVER_NAME']));
	//echo $domain;exit();
	$domain = "tritonetech.com";
    $from    = "www.$domain <nuthan@$domain>";
    $subject = "=?utf-8?B?".base64_encode($this->_subject)."?=";
    $header  = "To: ".$this->_name." <".$this->_mail.">\n";
    $header .= "From: $from\n";
  //  $header .= "Reply-To: www.$domain <$from>\n";
	
    $header .= "Content-type: text/html;charset=utf-8\n";
    $header .= "Content-Transfer-Encoding: 8bit\n";
    $header .= "X-Mailer: PHP/".phpversion();

    $message = "<html><body style='font-family:arial,tahoma;font-size:12px;'>".$this->_message."<br /><br /><br /><br />
    <span style='color:#808080'>E-mail sent through the website <strong>www.$domain</strong></span>
    </body></html>";

    return @mail($this->_mail, $subject, $message, $header);
  }
}
?>
