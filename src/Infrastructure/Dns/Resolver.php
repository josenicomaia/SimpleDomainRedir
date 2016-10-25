<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Infrastructure\Dns;

use Net_DNS2_Exception;
use Net_DNS2_Lookups;
use Net_DNS2_Resolver;
use Net_DNS2_RR_A;
use Net_DNS2_RR_NS;
use Net_DNS2_RR_TXT;
use SimpleDomainRedir\Domain\Dns\DomainNotFound;
use SimpleDomainRedir\Domain\Dns\Resolver as ResolverContract;
use SimpleDomainRedir\Domain\Dns\ResourceRecord\AResourceRecord;
use SimpleDomainRedir\Domain\Dns\ResourceRecord\NsResourceRecord;
use SimpleDomainRedir\Domain\Dns\ResourceRecord\TxtResourceRecord;

/**
 * Description of Resolver
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class Resolver extends ResolverContract {
    
    private $resolver;
    
    public function __construct(array $dnsServers = []) {
        
        $this->resolver = new Net_DNS2_Resolver(['nameservers' => $dnsServers]);
    }
    
    public function query($domain, $type = 'A', $class = 'IN') {
        
        try {
            
            $result = $this->resolver->query($domain, $type, $class);

            return $this->convertAnswer($result->answer);
        } catch (Net_DNS2_Exception $ex) {
            
            if($ex->getCode() == Net_DNS2_Lookups::E_DNS_NXDOMAIN) {
                
                throw new DomainNotFound();
            }
            
            throw $ex;
        }
    }
    
    private function convertAnswer(array $answer = []) {
        
        $convertedAnswer = [];
        
        foreach($answer as $rr) {
            
            if($rr instanceof Net_DNS2_RR_NS) {
                
                $convertedAnswer[] = $this->convertAnswerFromNs($rr);
            } else if($rr instanceof Net_DNS2_RR_TXT) {
                
                $convertedAnswer[] = $this->convertAnswerFromTxt($rr);
            } else if($rr instanceof Net_DNS2_RR_A) {
            
                $convertedAnswer[] = $this->convertAnswerFromA($rr);
            }
        }
        
        return $convertedAnswer;
    }
    
    private function convertAnswerFromNs(Net_DNS2_RR_NS $rr) {
        
        return new NsResourceRecord(
                $rr->name,
                $rr->type,
                $rr->class,
                $rr->ttl,
                $rr->nsdname);
    }
    
    private function convertAnswerFromTxt(Net_DNS2_RR_TXT $rr) {
        
        return new TxtResourceRecord(
                $rr->text, 
                $rr->name, 
                $rr->type, 
                $rr->class, 
                $rr->ttl);
    }
    
    private function convertAnswerFromA(Net_DNS2_RR_A $rr) {
        
        return new AResourceRecord(
                $rr->address, 
                $rr->name, 
                $rr->type, 
                $rr->class, 
                $rr->ttl);
    }

}
