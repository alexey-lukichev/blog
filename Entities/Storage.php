<?php 

namespace Entities;

abstract class Storage
{
    public abstract function create(TelegraphText $telegraphText);
    public abstract function read(string $slug);
    public abstract function update(string $slug, TelegraphText $telegraphText);
    public abstract function delete(string $slug);
    public abstract function list(string $slug);
}
