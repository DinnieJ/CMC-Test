<?php

namespace Datnn\Core\Validator;

interface IValidatorRules
{
    public function required($val);
    public function max($val, $params);
    public function min($val, $params);
    public function length($val, $params);
    public function number($val);
    public function datetimesql($val);
}
