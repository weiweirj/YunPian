<?php
/**
 * 云片 短信发送平台
 */
class YunPian
{
  private $apikey='';
  function __construct($apikey)
  {
    //如果上面那行报错，请把__construct替换成YunPian
    $this->apikey=$apikey;
  }
  public function tplSingleSend($mobile , $tplId,$tpl_value=array(),$apikey='') {
    if (!empty($apikey)) {
      $this->apikey=$apikey;
    }
    $tpl_value_str='';
    foreach ($tpl_value as $key => $value) {
      $tpl_value_str.=(empty($tpl_value_str))?'':('&');
      $tpl_value_str.=urlencode('#'.$key.'#').'='.urlencode($value);
    }
    $param = [
            'apikey' => $this->apikey,
            'mobile' => $mobile,
            'tpl_id' => $tplId,
            'tpl_value' =>urlencode($tpl_value_str)
            ];
    $param_str='';
    foreach ($param as $key => $value) {
      $param_str.=(empty($param_str))?'':('&');
      $param_str.=$key.'='.$value;
    }
    $post_code=$this->post("https://sms.yunpian.com/v2/sms/tpl_single_send.json", $param_str);
    return json_decode($post_code,true)['code']=='0'?true:false;
  }
  private function post($url,$data){
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_TIMEOUT, 500);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($curl, CURLOPT_URL, $url);
      $result = curl_exec($curl);
      curl_close($curl);
      return $result;
  }
}
