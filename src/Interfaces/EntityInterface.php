<?php

namespace App\Interfaces;

use App\Entity\EntityBase;

interface EntityInterface {

    // Method for persist information of Entity
    function save(array $data) ;
    // Method for update information of Entity
    function update(EntityBase $entity, array $data) ;

}