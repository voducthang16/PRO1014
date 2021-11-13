<?php
    class cart extends controller {
        function show() {
            $this -> view("index", [
                "page" => "cart",
            ]);
        }
    }
?>