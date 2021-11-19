<?php
    class checkoutModels extends database {
        function getMemberId($username) {
            $query = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

        function countProductsMember($id) {
            $query = "SELECT COUNT(*) as 'count' FROM `cart_temporary` WHERE member_id = ?";
            $result = $this->connect->prepare($query);
            $result->execute([$id]);
            return $result->fetch()['count'];
        }
    }
?>