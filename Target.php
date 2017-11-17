<?php

class Target {
    const TARGETTYPE_BANNER=1;
    const TARGETTYPE_MENU=2;
    
    public static function getTargets($type,$typeid='') {
        if (!empty($typeid)) {
            $where=" AND typeid=$typeid";
        } else $where='';
        $sql='SELECT targetid,type,typeid,name,site,pri,createdate,startdate,enddate,onlyreg,sex,age_from,age_to,regions,hungary,def FROM targets WHERE type='.$type.$where;
        $result=SQL::query($sql);
        $targets=$result->fetchData('targetid');
        $ret=array();
        foreach ($targets as $targetid=>$data) {
            $ret[]=new TargetItem($data);
        }
        return $ret;
    }
    
    public static function test($targetitems) {
        if (empty($targetitems)) return false;
        
        uasort($targetitems,array('Target','cmptargetitems'));
        
        $auth=ApplicationRegistry::getAuthUser();
        foreach ($targetitems as $i)
            if ($i.test($auth)) return $i;
        return false;
    }
    
    public static function cmptargetitems($a,$b) {
        $pri_a=$a->getPri();
        $pri_b=$b->getPri();
        if ($pri_a==$pri_b) return 0;
        return ($pri_a < $pri_b ? -1 :1);
    }
}

class TargetItem {
    private $data=array();
    
    public function __construct($data) {
        if (is_array($data)) $this->data=$data;
    }
    
    public function getTargetid() { return isset($this->data['targetid']) ? $this->data['targetid']: 0 ;}
    public function getType() { return isset($this->data['type']) ? $this->data['type']: 0;}
    public function getTypeid() { return isset($this->data['typeid']) ? $this->data['typeid']: 0;}
    
    public function getName() { return isset($this->data['name']) ? $this->data['name']: 0;}
    public function getSite() { return isset($this->data['site']) ? $this->data['site']: 0;}
    public function getPri() { return isset($this->data['pri']) ? $this->data['pri']: 0;}
    public function getCreateDate() { return isset($this->data['createdate']) ? $this->data['createdate']: 0;}
    public function getStartDate() { return isset($this->data['startdate']) ? $this->data['startdate']: 0;}
    public function getEndDate() { return isset($this->data['enddate']) ? $this->data['enddate']: 0;}
    
    public function getOnlyreg() { return isset($this->data['onlyreg']) ? $this->data['onlyreg']: 0;}
    public function getSex() { return isset($this->data['sex']) ? $this->data['sex']: 0;}
    public function getAgeFrom() { return isset($this->data['agefrom']) ? $this->data['agefrom']: 0;}
    public function getAgeTo() { return isset($this->data['ageto']) ? $this->data['ageto']: 100;}
    public function getRegions() { return isset($this->data['regions']) ? $this->data['regions']: '';}
    public function getHungary() { return isset($this->data['hungary']) ? $this->data['hungary']: 0;}
    public function getDef() { return isset($this->data['def']) ? $this->data['def']: '';}
    
    public function test($authuser) {
        
    }
    
}
