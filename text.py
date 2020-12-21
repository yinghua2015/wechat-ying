#!/usr/bin/env python3
# -*- coding: utf-8 -*-
import sys,os
import random
import time
import json
if __name__ == '__main__':
    # curPath = os.path.abspath(os.path.dirname(__file__))
    # print(curPath)
    # rootPath = os.path.split(curPath)[0]
    # print(rootPath)
    # print(sys.path)
    # print (sys.path.append(rootPath))
    # a = 1.98321243E9
    a = 1083689
    time_now = int(time.time())
    rr_list = dict()
    for x in range(0,100000):
        ls = list()
        for i in range(0, 1):
            time_local = time.localtime(time_now)
            dt = time.strftime("%Y-%m-%d", time_local)
            time_now += 24 * 3600
            aa = {
                "id":"WB000000011998-12",
                "indexVal": a + int(random.randint(100000, 1000000)),
                "indexid": "WB00000001",
                "unitcd": "02044",
                "ctycd": "ABW",
                "periodcd": "Y",
                "datasrccd": "WB01",
                "stDt": "2018-01-25 08:00:00",
                "endDt": "2018-01-31 08:00:00",
                "dataDt": dt
            }
            ls.append(aa)
        #key = "GM%08d"%(x+60000)
        key = "CM0%07d"%(x+200000)
        #key = "IE0%06d"%(x+1000000)
        rr_list[key] = ls
        # rr_list.append({key:ls})
    print(json.dumps(rr_list))

    # WB01222152
    # WB00000552
    # WB00000001
    # WB01000096
    # WB00100096
    # WB00000001
    # 世界经济
    # CM00000001
    # CM00103000

    # CM00509001
    # CM00616871
    # 行业经济
    # IE00000001
    # IE00012000
    # IE01614774
    # 海关
    # CT00000001
    # CT00040266

    # 营商评级
    # BR00000001
    # BR00000001
    # BR00063092

    # eiu经济数据
    # EI00000001,EI00111262
    # EI00000001
    # 全球宏观
    # GM00000001，GM00321554,GM00000001


