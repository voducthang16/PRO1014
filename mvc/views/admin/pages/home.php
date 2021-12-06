<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-rose card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">assignment</i>
                </div>
                <h4 class="card-title">Trang quản trị</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <h5>Tổng sản phẩm: <?=count($data['totalProducts'])?></h5>
                        <span class="material-icons">
                            shopping_bag
                        </span>
                    </div>
                    <div class="col-md-3 text-center">
                        <h5>Tổng người dùng: <?=($data['totalUsers'])?></h5>
                        <span class="material-icons">
                            people
                        </span>
                    </div>
                    <div class="col-md-3 text-center">
                        <h5>Tổng đơn hàng: <?=($data['totalOrders'])?></h5>
                        <span class="material-icons">
                            content_paste
                        </span>
                    </div>
                    <div class="col-md-3 text-center">
                        <h5>Tổng bình luận: <?=($data['totalComments'])?></h5>
                        <span class="material-icons">
                            chat
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="text-center">TOP 5 SẢN PHẨM BÁN CHẠY</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Hình ảnh</th>
                                    <th class="text-center">Tên sản phẩm</th>
                                    <th class="text-right">Số lượng bán</th>
                                </tr>
                            </thead>
                            <?php foreach($data['top5ProductsSale'] as $item): ?>
                                <tr>
                                    <td width="20%" class="text-center">
                                        <div class="img-container">
                                            <img src="public/upload/<?=$item['product_id']?>/<?=$item["thumbnail"]?>" alt="Product Image">
                                        </div>
                                    </td>
                                    <td width="50%" class="text-center"><?=$item["name"]?></td>
                                    <td width="30%" class="text-center"><?=$item["sum"]?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div style="position: relative;">
                            <canvas id="myChart"></canvas>
                            <h6 style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, 50%)">Tổng danh thu: <?=number_format($data['totalMoney'])?>đ</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach($data['moneyCategory'] as $item):?>
    <span style="visibility: hidden;" class="categoryName"><?=$item['name']?></span>
    <span style="visibility: hidden;" class="categoryMoney"><?=$item['price']?></span>
<?php endforeach; ?>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        let categoryName = [];
        let a = $(".categoryName").length;
        for (let i = 0; i < a; i++) {
            categoryName.push($(".categoryName").eq(i).text());
        }

        let categoryPrice = [];
        let b = $(".categoryMoney").length;
        for (let i = 0; i < b; i++) {
            categoryPrice.push(+$(".categoryMoney").eq(i).text());
        }
        console.log(categoryPrice)
        console.log(categoryName)
        function randomNum() {
            return Math.floor(Math.random() * 256);
        }

        function randomRGB() {
            let red = randomNum();
            let green = randomNum();
            let blue = randomNum();
            return [red,green,blue];
        }

        let rgbValues = randomRGB();

        let colorArray = [];

        for (let i = 0; i < categoryName.length; i++) {
            colorArray.push(`rgb(${rgbValues[0]},${rgbValues[1]},${rgbValues[2]})`);
            rgbValues = randomRGB();
        }

        const data = {
            labels: categoryName,
            datasets: [{
                label: 'My First Dataset',
                data: categoryPrice,
                backgroundColor: colorArray,
                hoverOffset: 4
            }]
        };
        const config = {
            type: 'doughnut',
            data: data,
        };
        let myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    })
</script>