<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'Hp2jQOR7m1zC6jYRdCcCtRz9HOQpov9Q2lCAIiPnMEzl6oZp2GaOPo5/67lFzaEpfoyn7H8L5n/eUFZIDDk/wDcrLy2wRJW3xEnjxP9K+hDyVqxDMV3VszIW9hJfOWhJaQq1UwH7200QeqFj93Vb5QdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
		$text = $event['message']['text'];
		
		if(($text == "อุณหภูมิตอนนี้")||($text == "อุณหภูมิวันนี้")||($text == "อุณหภูมิ")){
			$temp = 33;
			$reply_message = 'ขณะนี้อุณหภูมิที่ '.$temp.'°C องศาเซลเซียส';
		}
		else if(($text== "ตอนนี้อยู่ที่ไหน")||($text== "ตอนนี้อยู่ไหน")||($text== "อยู่ที่ไหน")||($text== "อยู่ไหน")){
			$reply_message = 'ขณะนี้อยู่ที่บ้าน!';
		}
	  	else if(($text== "ทำไมอ่านแล้วไม่ตอบ")||($text== "อ่านไม่ตอบ")||($text== "หยิ่งหรอ")||($text== "ไม่ตอบ")){
			$reply_message = '5555';
		}
	   	else if(($text== "แล้วไง")||($text== "เจอได้")||($text== "นก")||($text== "แหม")){
			$reply_message = 'อิอิ จะเอาป่ะล่ะ';
		}
	   	else if(($text== "หัวล้าน")||($text== "ไอ้สัส")||($text== "สัส")||($text== "จ้า")){
			$reply_message = 'ขอบคุณจ้า';
		}
	   else if(($text== "ทำไร")||($text== "ทำไรอยู่")||($text== "ปราง")||($text== "ไอสัส")){
			$reply_message = 'ยุ่งไร';
		   else if(($text== "กินข้าว")||($text== "กินไร")||($text== "กินไหม")||($text== "กิน")){
			$reply_message = 'ไม่เอา อ้วน';
		else
		{
			$reply_message = 'รอก่อน หัดพูดอยู่เว้ยเห้ย อย่าใจร้อน';
    		}
   
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>
