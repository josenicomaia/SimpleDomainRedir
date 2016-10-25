<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SimpleDomainRedir\Infrastructure\Dns;

use SimpleDomainRedir\Domain\Dns\ResolverFactory as ResolverFactoryContract;

/**
 * Description of ResolverFactory
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class ResolverFactory implements ResolverFactoryContract {
    
    public function make(array $dnsServers = []) {
        
        return new Resolver($dnsServers);
    }

}
