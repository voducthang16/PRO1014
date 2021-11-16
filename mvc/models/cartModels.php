<?php
    class cartModels extends database {
        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetch()['id'];
        }

        function getCart($id_member) {
            $query = 'SELECT cart_temporary.product_type_id, cart_temporary.id, cart_temporary.quantity, products_type.id, products_type.product_id, products_type.price_sale, products.name, products.slug, products.thumbnail 
            FROM cart_temporary
            INNER JOIN products_type ON cart_temporary.product_type_id = products_type.id
            INNER JOIN products ON products_type.product_id = products.id
            WHERE member_id = ? ORDER BY cart_temporary.id DESC';

            // INNER JOIN products_type_attributes ON cart_temporary.product_type_id =
            // products_type_attributes.product_type_id
            // products_attributes.value
            // INNER JOIN products_attributes ON products_type_attributes.attributes_id = 
            // products_attributes.id
            
            $stmt = $this->connect->prepare($query);
            $stmt->execute([$id_member]);
            return $stmt;
        }

        function getAttributes($id, $attribute) {
            $query = "SELECT products_attributes.value FROM products_attributes INNER JOIN products_type_attributes ON products_attributes.id = products_type_attributes.attributes_id WHERE products_type_attributes.product_type_id = $id AND products_attributes.name LIKE '%$attribute%'";
            $result = $this->connect->prepare($query);
            $result->execute();
            return $result->fetch();
        }

        function get_type_id($id_product,$color,$size) {
            $query = "SELECT product_type_id FROM products_type_attributes 
            INNER JOIN products_type ON product_type_id = products_type.id 
            INNER JOIN products ON products_type.product_id = products.id 
            WHERE products.id = ? AND attributes_id IN (?,?) 
            GROUP BY product_type_id HAVING COUNT(1) = 2";
            $result = $this->connect->prepare($query);
            $result->execute([$id_product,$color, $size]);
            return $result->fetch()['product_type_id'];
        }

        function check_type_id($id_member,$id_type){
            $qr = "SELECT * FROM `cart_temporary` WHERE member_id = ? and product_type_id = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$id_member,$id_type]);
            return $result;
        }

        function updateQtt($qtt,$id_member,$id_type){
            $qr = "UPDATE `cart_temporary` SET quantity = ? WHERE member_id = ? and product_type_id = ?";
            $result = $this->connect->prepare($qr);
            $kq = false;
                if ($result->execute([$qtt,$id_member,$id_type])){
                    $kq = true;
                    return json_encode($kq);
                }
            return json_encode($kq);
        }

        function insertCart($id_member,$id_type) {
            $qr = "INSERT INTO `cart_temporary`(`member_id`, `product_type_id`, `quantity`) VALUES ('$id_member','$id_type','1')";
            $result = $this->connect->prepare($qr);
            $kq = false;
                if ($result->execute()){
                    $kq = true;
                    return json_encode($kq);
                }
            return json_encode($kq);
        }

        function deleteCart($id_member,$id_type){
            $qr = "DELETE FROM `cart_temporary` WHERE member_id=? and product_type_id=?";
            $result = $this->connect->prepare($qr);
            $kq = false;
                if($result->execute([$id_member,$id_type])){
                    $kq = true;
                    return json_encode($kq);
                }
            return json_encode($kq);
        }

        function getTotal($id_member){
            $qr = "SELECT * FROM `cart_temporary` WHERE member_id = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$id_member]);
            return $result->fetchAll();
        }
    }
?>