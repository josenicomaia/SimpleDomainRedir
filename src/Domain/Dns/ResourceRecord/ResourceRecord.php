<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns\ResourceRecord;

/**
 * Description of ResourceRecord
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class ResourceRecord {
    
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var string
     */
    private $type;
    
    /**
     *
     * @var string
     */
    private $class;
    
    /**
     *
     * @var string
     */
    private $ttl;
    
    public function __construct($name, $type, $class, $ttl) {
        
        $this->name = $name;
        $this->type = $type;
        $this->class = $class;
        $this->ttl = $ttl;
    }
    
    public function name() {
        
        return $this->name;
    }
    
    public function type() {
        
        return $this->type;
    }
    
    public function clazz() {
        
        return $this->class;
    }
    
    public function ttl() {
        
        return $this->ttl;
    }
}
