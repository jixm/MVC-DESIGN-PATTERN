<?php
function print_dot(){
    echo ".";
}
 
class Timer{
    protected  $pEventBase;
    protected $pEvent;
    public $nInterval = 1;
    public function __construct(){
        $this->pEventBase = event_base_new();
    }
    public function addEvent($p_pFunc, $p_mxArgs = null){
        $this->pEvent = event_new();
        event_set($this->pEvent, 0, EV_TIMEOUT, $p_pFunc, $p_mxArgs);
        event_base_set($this->pEvent, $this->pEventBase);
    }
    public function loop(){
        event_add($this->pEvent, $this->nInterval*1000000);
        event_base_loop($this->pEventBase);
    }
}
 
$pTimer = new Timer();
$pTimer->addEvent("print_dot");
while(1){
    $pTimer->loop();
}
