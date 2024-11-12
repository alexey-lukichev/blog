<?php 

namespace Entities;

abstract class User
{
    protected $id, $name, $role;
    public abstract function getTextsToEdit();
}
