<?php
    class blog extends controller {
        function show() {
            $this -> view("index", [
                "page" => "blog"
            ]);
        }
    }
?>