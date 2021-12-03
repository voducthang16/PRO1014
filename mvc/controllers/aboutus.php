<?php
    class aboutus extends controller {
        function show() {
            $this -> view("index", [
                "page" => "aboutus"
            ]);
        }
    }
?>