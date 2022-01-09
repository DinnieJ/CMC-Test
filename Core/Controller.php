<?php

namespace Datnn\Core;

abstract class Controller {
    public function __invoke() {
        $fns = \get_class_methods($this);
        $do_method_funcs = array_map(function($fn) {
            return strtoupper(substr($fn, 2));

        }, array_filter($fns, function($fn) {
            return strpos($fn, 'do') === 0;
        }));
        
        $methods = $_SERVER['REQUEST_METHOD'];

        if(in_array($methods, $do_method_funcs)) {
            $this->{"do$methods"}();
        } else {
            echo JsonResponse::getResponse(405, "Method not found");
        }
    }

}