<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;

/**
 * Description of DadosRedirecionar
 *
 * @author José Nicodemos Maia Neto<jose at nicomaia.com.br>
 */
class RedirectRequestRequest extends FormRequest {
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
        return [];
    }

    public function domain() {
        
//        return 'laraveldoctrine.org';
        return 'cash4lol.com';
//        return $this->server("HTTP_HOST");
    }

}
