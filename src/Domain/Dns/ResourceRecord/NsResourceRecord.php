<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns\ResourceRecord;

/**
 * Description of NsResourceRecord
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class NsResourceRecord extends ResourceRecord {
    
    /**
     *
     * @var string
     */
    private $nsdName;
    
    public function __construct($name, $type, $class, $ttl, $nsdName) {
        
        parent::__construct($name, $type, $class, $ttl);
        $this->nsdName = $nsdName;
    }
    
    public function nsdName() {
        
        return $this->nsdName;
    }
}
