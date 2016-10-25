<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Requests\RedirectRequestRequest;
use Net_DNS2_Resolver;
use SimpleDomainRedir\Domain\SearchRedirect;


/**
 * Description of RedirController
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class RequestController extends Controller {
    
    public function redirect(RedirectRequestRequest $request, SearchRedirect $searchRedirect) {
        
        $redirect = $searchRedirect->search($request->domain());
        
        return ($redirect != null)? redirect(dd($redirect)) : 'The cliente code field is required.';
    }
}
