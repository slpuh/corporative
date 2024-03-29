<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Corp\Repositories;

use Corp\Portfolio;

class PortfoliosRepository extends Repository {

    public function __construct(Portfolio $portfolio) {
        $this->model = $portfolio;
    }

    public function one($alias, $attr = []) {
        $portfolio = parent::one($alias,$attr);

        if ($portfolio && $portfolio->img) {
            $portfolio->img = json_decode($portfolio->img);
        }

        return $portfolio;
    }

}
