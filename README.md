# QuickGet.Co
퀵겟 QR 페이먼트 게이트

## API 설명서
아래 내용을 적용하시려면, 쇼핑몰과 연결하는 자바스크립트 또는 PHP 언어 등에 대한 기본적인 지식이 필요합니다.
### 1. QR 코드 요청 HTTP GET
인자명|필요여부|기본값|설명
----|----|----|----
appid|필요|없음|상점 appid(와라페이 앱 등에서 확인 가능)
money|옵션|없음|결제 받을 금액 입력. 비워두면, 고객이 직접 결제금액 입력하여 결제가능합니다. 주의 : 입력시 반드시 10원 이상 단위여야 합니다.
callback|필요|html|[json]과[html]중 하나 입력. callback=json 으로 입력하면, 생성되는 QR로 결제를 받는 경우 이에 대한 결과를 Notify URL( 3번의 내용 )로 JSON 형식으로 전달받으며, callback=html 으로 입력하면, 결제 화면으로 바로 이동하여, 결제까지 완료 한 후, 아래에 설정하는 Return URL( 4번의 내용)로 결과를 전달받습니다 둘이 분리된 가장 큰 이유는, json 방식은 귀사의 웹사이트에 특정한 위치에 iframe 등으로 QR을 표기하여, 이에 대한 결제를 받은 후 처리하기 위함이며, html 방식은 총액만 지정해서 결제가 완료될때까지 모두 퀵겟에게 맡긴 후, 최종 결제에 대한 처리만을 손쉽게 하는 경우에 사용하기 위함입니다.
forever|옵션|0|해당 QR코드에 결제 제약시간/횟수가 있는지 여부입니다. forever=1 로 설정하시면, 영구적으로 동일한 QR 코드로 결제받아, 새로운 큐알코드를 생성하지 않습니다. 보안을 위해서 forever=0 을 추천드립니다. payment	옵션	warapay	사용자가 결제시 사용하기를 희망하는 결제방식을 지정가능합니다. 현재는 비워두시면, 와라페이/알리페이/위챗페이를 이용해서 고객이 결제할 수 있습니다.
custom_trade_sn|옵션|없음|해당 주문을 구분할 수 있는 직접 생성하시는 구분코드입니다. 즉, 많은 판매 제품중에서 어떤 제품을 구매했는지 구분하거나, 정확히 어떤 고객이 주문했는지 구분하기 위해서, 귀사의 시스템에서 스스로 생성한 '주문서 번호' 입니다. 이는 Return URL 에서 결제 결과를 전달 받으신 후, 직접 결제 결과를 확인하실때 스스로 비교하시기 위해서 정하신 코드이며, 중복되지 않는 유일한 코드여야 합니다. notify	옵션	없음	결제 결과를 통보받을 귀사의 서버 URL입니다. 귀사의 서버는 이 통보를 받은 후, 전달받은 영수번호를 검사하셔서, 실제 결제가 완료되었는지 체크하시면 됩니다.
return|옵션|없음|callback=html 으로 셋팅한 경우, 결제가 완료된 후 결제 결과가 전달될 URL 입니다.
qrsizetype|옵션|mp|생성될 QR코드의 크기타입으로 mp와 pp 중 지정 가능합니다.
qrsize|옵션|10|위의 qrsizetype을 mp로 지정했다면, 1.00 ~ 50.00의 크기 설정 가능하고, pp로 지정했다면 1~1000 로 지정가능 합니다. 참고로 1mp는 45px 입니다.
qrimagetype|옵션|png|이미지 포맷 지정이 가능하며 png 와 jpg 중 선택 가능합니다.
custom|옵션|0|금액|입력 단위로, 만약 0이외의 값을 입력했다면, money 값이 0인것처럼, 고객이 결제금액을 입력하는 방식이 됩니다. 즉, 100, 500, 1000 등으로 결제 금액 단위를 설정 가능하며, 예를들어 500으로 입력했다면, 고객은 500원 단위로 결제금액을 입력해서 결제 가능합니다. 이 기능은 보통 자동판매기 등에서 500원 코인이나, 1000원 지폐를 여러장 결제 받는 등의 용도로 사용됩니다.

#### 인자 전달 방식 : GET 방식
#### 요청 URL : http://wara-kr.quickget.co/pay/request.html
#### 예> http://wara-kr.quickget.co/pay/request.html?appid=86572812&money=100&callback=html&return=www.yourserverurl.com/yourprocess.php

### 2. 위의 GET 호출에 대한 결과값 반환(callback=html 인 경우는 바로 결제화면이 열리므로 해당없음)
JSON 리턴 code 값 : 0이면 성공, 1이면 실패 
JSON 리턴 message 값 : 성공시, QR 코드에 대한 정보. 실패시 실패 관련 메세지 
JSON 리턴 qrcode 값 : QR코드용 주소 - 이 주소를 이용하여 직접 QR코드를 생성하여, 자신의 웹사이트에 표시

성공시 예: {"code":0,"message":"https://epay.miguyouxi.com/*****","qrcode":"http://wara-kr.netmego.com/*****"}
		
실패시 예: {"code":1,"message":"appid_error"}

### 3. 결제 결과가 자신의 Notify URL 서버로 전달됨 ( POST 방식 : callback=json 으로 요청한 경우 )
인자명|설명
----|----
code|성공 실패 여부 : 0이면 성공, 1이면 실패
trade_sn|영수증 번호 : 이 코드를 이용해서, 하단의 영수증 검증을 완료하여 실제 결제가 완료되었는지 체크 가능
appid|상점 appid : 결제 받은 상점이 자신이 맞는지 확인시 사용
custom_trade_sn|주문서 번호 : 귀사에서 중복되지 않은 독립된 코드로, 주문을 식별하기 위해, QR생성시 전달한 코드. 이를 통해서 귀사가 요청해서 생성한 QR코드가 맞는지 체크 가능
money|실제 결제 금액 : QR 생성시 금액을 지정한 경우, 해당 금액이 맞는지 체크. 맞는 경우, 또는 유저가 직접 입력한 금액이라면, 자체 조건에 따라 처리. 쇼핑몰 등의 정해진 금액을 결제하는 경우는, 요청 금액과 비교하면 되며, 자동판매기 등의 경우, 사용자가 입력한 금액만큼의 처리를 하면 됨.
status|결제 결과 상태메세지 : SUCCESS 인 경우만 성공한 경우이며, 그 이외에는 관련 에러메세지 등
paytime|결제 완료된 시간 : time 관련 서버측의 결제완료 시간

### 4. 결제 결과가 자신의 Return URL 서버로 전달됨 ( HTML GET 방식 : callback=html 로 요청한 경우 )
인자명|설명
----|----
trade_sn|영수증 번호 : 이 코드를 이용해서, 하단의 영수증 검증을 완료하여 실제 결제가 완료되었는지 체크 가능
appid|상점 appid : 결제 받은 상점이 자신이 맞는지 확인시 사용
custom_trade_sn|주문서 번호 : 귀사에서 중복되지 않은 독립된 코드로, 주문을 식별하기 위해, QR생성시 전달한 코드. 이를 통해서 귀사가 요청해서 생성한 QR코드가 맞는지 체크 가능
money|실제 결제 금액 : QR 생성시 금액을 지정한 경우, 해당 금액이 맞는지 체크. 맞는 경우, 또는 유저가 직접 입력한 금액이라면, 자체 조건에 따라 처리. 쇼핑몰 등의 정해진 금액을 결제하는 경우는, 요청 금액과 비교하면 되며, 자동판매기 등의 경우, 사용자가 입력한 금액만큼의 처리를 하면 됨.
status|결제 결과 상태메세지 : SUCCESS 인 경우만 성공한 경우이며, 그 이외에는 관련 에러메세지 등
paytime|결제 완료된 시간 : time 관련 서버측의 결제완료 시간

### 5. 전달된 영수증 번호를 검증하기
인자명|설명
----|----
appid|상점 appid : 주문했던 동일한 상점 appid
trade_sn|전달받은 영수증번호 : 결제 완료후 통보받은 영수증 번호를 전달하여, 최종적으로 결제가 완료된것이 맞는지 확인

#### * 인자 전달 방식 : GET 방식 
#### * 요청 URL:http://wara-kr.quickget.co/pay/tradeQuery.html
#### 요청 예: http://wara-kr.quickget.co/pay/tradeQuery.html?appid=yourid&trade_sn=received_trade_sn

### 6. 위의 GET 호출에 대한 결과값 반환
#### JSON 리턴 code 값 : 0이면 성공, 1이면 실패 
#### JSON 리턴 message 값 : 실패시 실패 관련 메세지