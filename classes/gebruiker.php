<?php

/* 
 * Copyright (C) 2017 Rick Huijzer
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class gebruiker {
    
    private $gebruikersNaam;
    private $accountNr;
    private $isAdmin;
    private $lijnNr;
    
    public function __construct($gebruikersNaam, $accountNr, $isAdmin, $lijnNr) {
        $this->gebruikersNaam = $gebruikersNaam;
        $this->accountNr = $accountNr;
        $this->isAdmin = $isAdmin;
        $this->lijnNr = $lijnNr;
    }
    
    public function getGebruikersnaam(){
        return $this->gebruikersNaam;
    }
    
    public function getAccountNr(){
        return $this->accountNr;
    }
    
    public function getAdmin(){
        if($this->isAdmin == 1){
            return TRUE;
    } else {
        return FALSE;
    }
    }
}
