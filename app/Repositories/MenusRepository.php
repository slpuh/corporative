<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Corp\Repositories;

use Corp\Menu;

class MenusRepository extends Repository {
    
    public function __construct(Menu $menu) {
        $this->model = $menu;
    }
}
