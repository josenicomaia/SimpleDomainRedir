<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns\ResourceRecord;

/**
 * Description of TxtResourceRecord
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class TxtResourceRecord extends ResourceRecord {
    
    /**
     *
     * @var string[]
     */
    private $text;
    
    public function __construct($text, $name, $type, $class, $ttl) {
        
        parent::__construct($name, $type, $class, $ttl);
        $this->text = $text;
    }
    
    public function text() {
        
        return $this->text;
    }
}
