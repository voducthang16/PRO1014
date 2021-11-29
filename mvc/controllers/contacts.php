<?php
    class contacts extends controller {
        function show() {
            $this -> view("index", [
                "page" => "contacts"
            ]);
        }
    }
?>