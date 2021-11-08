<?php
    class pagenotfound extends controller {
        function show() {
            $this -> view("index", [
                "page" => "pagenotfound"
            ]);
        }
    }
?>