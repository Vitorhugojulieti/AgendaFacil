<?php

namespace app\interfaces;

interface ControllerInterface
{
    public function index(array $args);
    public function edit(array $args);
    public function show(array $args);
    public function update(array $args);
    public function store(array $args);
    public function destroy(array $args);
}

?>