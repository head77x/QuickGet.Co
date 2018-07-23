/**
* 필요한 파라메터 채우기	
*/
	 
$params=array();
$params['appid']='';  //와라페이 개발자 사이트 또는 와라페이 앱의 내정보>APPID 에서 확인
$params['money']='100'; // 최소 10원 이상
$params['callback']='json'; // 결제 진행방식 - JSON인 경우는 내 웹사이트에서 이동하지 않고, 리턴되는 QR코드를 화면에 표기하고, Notify 로 결제 결과가 올 때까지 대기 
$params['notify']='결제 결과를 전달받을 여러분의 서버 URL';  // 결제 결과를 POST 방식으로 전달받을 URL

/**
* 
* API 문서를 보고 필요한 내용들 추가 
*/

/**
* 요청하기
*/	 
	
$url="http://wara-kr.quickget.co/pay/request.html";
$result=file_get_contents($url."?".http_build_query($params));

