<?php

namespace Datnn\Core\Validator;

abstract class Validator implements IValidatorRules
{
    private $data;

    private $rules;


    public function __construct($data)
    {
        $this->data = $data;
        $this->rules = $this->rules();
    }

    protected abstract function rules();

    protected abstract function responsesError();

    public function validate()
    {
        $errors = [];
        foreach ($this->rules as $key => $rule) {
            $value = isset($this->data[$key]) ? $this->data[$key] : null;
            $rule = explode('|', $rule);
            foreach ($rule as $r) {
                $r = explode(':', $r);
                $method = $r[0];
                $params = isset($r[1]) ? explode(',', $r[1]) : [];
                if (!$this->$method($value, $params)) {
                    $this->responsesError();
                    exit();
                }
            }
        }
        return true;
    }

    public function number($val)
    {
        if(!$val) return true;
        return is_numeric($val);
    }

    public function length($val, $params) {
        if(!$val) return true;
        return strlen($val) == $params[0];
    }

    public function required($val)
    {
        return isset($val) && !empty($val) && !is_null($val);
    }

    public function max($val, $max_val)
    {
        if(!$val) return true;
        if (is_numeric($val)) {
            return $val <= $max_val[0];
        } else {
            return strlen($val) <= $max_val[0];
        }
    }

    public function min($val, $min_val)
    {
        if(!$val) return true;
        if (is_numeric($val)) {
            return $val >= $min_val[0];
        } else {
            return strlen($val) >= $min_val[0];
        }
    }

    public function datetimesql($val)
    {
        if(!$val) return true;
        return preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}|^\d{4}-\d{2}-\d{2}$/', $val);
    }
}
