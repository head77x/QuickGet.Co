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


/**
* 여기서부터는 위의 요청에 따른 리턴값 예제
*/

JSON 방식으로 리턴됨
{
	"code": 0,
	"quickid": 346,
	"message": "https:\/\/epay.miguyouxi.com\/jump-init.do?cmd=quick&country=kr&id=MzQ2",
	"qrcode": "http:\/\/wara-kr.quickget.co\/uploadfile\/qrcode\/3139ed4b18377b36bcf1857bb8255489_logo.png",
	"token": "1645r0c"
}

/**
* 여기서부터는 최종 사용자가 결제를 완료하면, 결제 결과를 전달받는 여러분의 서버 URL에서 받는 내용
*/

echo $_POST['code'];	// 성공 실패 여부
echo $_POST['trade_sn'];	// 영수증 번호
echo $_POST['appid'];	// 상점 appid
echo $_POST['custom_trade_sn'];	// 주문서 번호
echo $_POST['money'];	// 실제 결제 금액
echo $_POST['status'];	// 결제 결과 메세지
echo $_POST['paytime'];	// 결제 완료 시간
