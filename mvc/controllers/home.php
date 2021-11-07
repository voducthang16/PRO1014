<?php
    class home extends controller {
        function show() {
            $this -> view("index", [
                "page" => "home"
            ]);
        }
    }
?>