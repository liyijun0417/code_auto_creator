<?php

namespace Mcit;

class Idcard
{

    private $idNum;

    public function __construct($idNum)
    {
        $this->idNum = (string)$idNum;
    }

    public function isIdNum()
    {
        $idNum = $this->idNum;
        if (strlen($idNum) == 18) {
            return $this->idcardCheckSum18($idNum);
        }  else {
            return false;
        }
    }

    // 计算身份证校验码，根据国家标准GB 11643-1999
    private function idcardVerifyNumber($idcardBase)
    {
        if (strlen($idcardBase) != 17) {
            return false;
        }
        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;
        for ($i = 0; $i < strlen($idcardBase); $i++) {
            $checksum += substr($idcardBase, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        return $verify_number;
    }

    // 18位身份证校验码有效性检查
    private function idcardCheckSum18($idcard='')
    {
        if(empty($idcard)){
            $idcard=$this->idNum;
        }
        if (strlen($idcard) != 18) {
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if ($this->idcardVerifyNumber($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
            return false;
        } else {
            return $this->idcardinfo($idcard);
        }
    }

    private function idcardinfo()
    {
        $idcard = $this->idNum;
        // $idcarddata['arrd_p'] = substr($idcard, 0, 2);
        // $idcarddata['arrd_s'] = substr($idcard, 2, 2);
        // $idcarddata['arrd_x'] = substr($idcard, 4, 2);
        $idcarddata['addr']   = substr($idcard, 0, 6);
        $idcarddata['bd']     = substr($idcard, 6, 8);

        if (substr($idcard, 16, 1) % 2 == 0) {
            $idcarddata['sex'] = 2;
        } else {
            $idcarddata['sex'] = 1;
        }

        $idcarddata['code']   = $idcard;
		return $idcarddata;
    }
}