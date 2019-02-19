<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Corp\Repositories;
use Corp\Slider;

class SlidersRepository  extends Repository 
{
    
   public function __construct(Slider $slider) {
        $this->model = $slider;
    }
}
