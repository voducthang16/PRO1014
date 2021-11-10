<?php
    class account extends controller {

        function show() {
            $this -> view("index", [
                "page" => "account"
            ]);
        }
    }
?>