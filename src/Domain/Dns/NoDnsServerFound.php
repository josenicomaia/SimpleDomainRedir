<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Domain\Dns;

use Exception;

/**
 * Description of NoDnsServerFound
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class NoDnsServerFound extends Exception {
    
    public function __construct($message = "", $code = 0, Exception $previous = null) {
        
        parent::__construct($message, $code, $previous);
    }
}
