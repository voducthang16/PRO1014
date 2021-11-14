<?php
    class cartModels extends database {
        function getCart($id_member) {
            $query = 'SELECT .cart_temporary.quantity, products_type.id, products_type.product_id, products_type.price_sale, products.name, products.slug, products.thumbnail FROM cart_temporary
            INNER JOIN products_type ON cart_temporary.product_type_id = products_type.id
            INNER JOIN products ON products_type.product_id = products.id
            WHERE member_id = ?';

            // INNER JOIN products_type_attributes ON cart_temporary.product_type_id =
            // products_type_attributes.product_type_id
            // products_attributes.value
            // INNER JOIN products_attributes ON products_type_attributes.attributes_id = 
            // products_attributes.id
            
            $stmt = $this->connect->prepare($query);
            $stmt->execute([$id_member]);
            return $stmt;
        }
        function get_type_id($id_product,$color,$size) {
            $query = "SELECT product_type_id FROM products_type_attributes INNER JOIN products_type ON product_type_id = products_type.id INNER JOIN products ON products_type.product_id = products.id WHERE products.id = ? AND attributes_id IN (?,?) GROUP BY product_type_id HAVING COUNT(1) = 2";
            $result = $this->connect->prepare($query);
            $result->execute([$id_product,$color, $size]);
            return $result->FetchAll();
        }
        function getProfile($username) {
            $qr = "SELECT id FROM members WHERE username = ?";
            $result = $this->connect->prepare($qr);
            $result->execute([$username]);
            return $result->fetchAll();
        }
        function insertCart($id_member,$id_type) {
            $qr = "INSERT INTO `cart_temporary`(`member_id`, `product_type_id`, `quantity`) VALUES ('$id_member','$id_type','1')";
            $result = $this->connect->prepare($qr);
            $kq = false;
                if ($result->execute()){
                    $kq = true;
                    return $kq;
                }
            return json_encode($kq);
        }
    }
?>