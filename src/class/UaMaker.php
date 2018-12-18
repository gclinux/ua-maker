<?php
namespace gclinux;
class UaMaker{
    private $lang_db = NULL;
    private $device_db = NULL;
    private $ua_db = NULL;
    function loadDb(){
        $path = dirname(dirname(__FILE__)) .'/db/';
        $data = file_get_contents($path.'device_db.json');
        $this->device_db = json_decode($data,true);

        $data = file_get_contents($path.'ua_db.json');
        $this->ua_db = json_decode($data,true);

        $data = file_get_contents($path.'lang.json');
        $this->lang_db = json_decode($data,true);

        //return $this;
    }
    function __construct(){
        $this->loadDb();
    }
/**
 * 生产一个UA
 * @param  string $country_code [两位国家代码]
 * @param  string $platform     [平台,ios,android,pc]
 * @return [string]               [随机生成的符合该地区和平台特征的UA]
 */
    function makeUa(string $country_code,string $platform){
        if(!in_array($platform,['pc','android','ios'])){
            throw new \Exception("Platform only can be pc,android,ios", 1);
        }
        $country_code = strtolower($country_code);
        $ua_list = $this->ua_db[$platform];
        $i = rand(0,count($ua_list)-1);
        $ua_base = $ua_list[$i];
        if(isset($this->lang_db[$country_code])){
            $lang = $this->lang_db[$country_code];
        }else{
            $lang = 'en-EN';
        }
        $ua_base = str_replace('$(LOCALE)', $lang, $ua_base);

        if($platform == 'android'){
            $i = rand(0,count($this->device_db)-1);
            $device = $this->device_db[$i];
            $ua_base = str_replace('$(MODEL)',$device[0],$ua_base);
            $ua_base = str_replace('$(VERSION)',$device[1],$ua_base);
            $ua_base = str_replace('$(BUILD)',$device[2],$ua_base);
        }
        return $ua_base; 

    }
       


}