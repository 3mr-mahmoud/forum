<?php

function create($class , $attributes = [], $times = null) {
    return factory($class, $times)->create($attributes);
}

function make($class , $attributes = []) {
    return factory($class)->make($attributes);
}