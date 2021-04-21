<?php

namespace Adideas\RelationFinder;

trait RelationsFinder
{
    public static function relations() {
        return new ParserModel(new static());
    }
}
