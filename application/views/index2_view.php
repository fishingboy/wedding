<!--
    不要偷看原始碼啦，資料填好了沒？
-->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>文彬＆昱伊婚禮邀請</title>
    <meta name="viewport" content="width=device-width, initial-scale=2, shrink-to-fit=no">
    <!-- css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/bootstrap-grid.css" />
    <link rel="stylesheet" href="/css/style.css" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Allura" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,600,600i" rel="stylesheet">

    <!-- script -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var photos = <?= json_encode($photos) ?>;
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="http://underscorejs.org/underscore-min.js"></script>
    <script src="/js/wedding.js?<?= time() ?>"></script>
</head>
<body>
<header class="full-header-fixed">
    <div class="container both-sides-containter">
        <div class="left-wrp"><i class="logo"></i></div>
        <div class="right-wrp">
            <a href="javascript:;" class="header-menu"></a>
            <ul id="menu-items" class="menu-items-hidden">
                <li><a href="javascript:wedding.scroll('#date');">結婚日期</a></li>
                <li><a href="javascript:wedding.scroll('#photo');">婚紗搶先看</a></li>
                <li><a href="javascript:wedding.scroll('#form');">出席回覆</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="wrapper">
    <!-- banner -->
    <section class="full-banner-container">
        <div class="overlay-bg"></div>
        <div class="banner-words-block container ">
            <h2 class="lg-title">Leo & Evonne</h2>
            <h2 class="sm-title">We are Getting Married June 03, 2018</h2>
        </div>
    </section>

    <!-- Date and Location -->
    <section id='date' class="container white-bg-container">
        <h5 class="title">結婚日期</h5>
        <div class="text-content">
            <p class="date-text">2018/06/03 (日) 午宴</p>
            <p class="location-text">北都大飯店<br>基隆市中正區信二路319號</p>
            <a class="red-btn" href="javascript:wedding.scroll('#form');">出席回覆</a>
        </div>
    </section>

    <!--  Google Map  -->
    <section id="maps" class="white-bg-container">
        <div class="gmap-content">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d57794.05985416207!2d121.74550300000001!3d25.131338!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x15b579de5d61989b!2z5YyX6YO95aSn6aOv5bqX!5e0!3m2!1szh-TW!2sus!4v1510629984471" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </section>

    <!--  婚紗搶先看  -->
    <section id="photo" class="white-bg-container">
        <h5 class="title">婚紗搶先看</h5>
        <div class="photo-content">
            <?php foreach($photos as $i => $photo) :?>
                <?php if ($i >= 8) break; ?>
                <div class="photo">
                    <img class="<?= $photo['type'] ?>" src="<?= $photo['file'] ?>" alt="" photo-sn="<?= $i ?>">
                    <div class="image-overlay" photo-sn="<?= $i ?>"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Invite From -->
    <section id='form' class="white-bg-container photo-bg-container">
        <div class="form-block">
            <h5 class="title">出席回覆</h5>
            <div class="form-content">
                <div class="form-item">
                    <p class="form-title">請問您的大名：</p>
                    <input id='fm_name' type="text" placeholder="輸入姓名">
                </div>
                <div class="form-item">
                    <p class="form-title">與新人的關係：</p>
                    <select id='fm_group_id'>
                        <option>-</option>
                    </select>
                </div>
                <div class="form-item">
                    <p class="form-title">共幾個人出席 (包含自己)：</p>
                    <input id='fm_peoples' type="number" placeholder="請填入數字" min="1">
                </div>
                <div class="form-item">
                    <p class="form-title">共幾位吃素：</p>
                    <input id='fm_vegan_peoples' type="number" placeholder="請填入數字" min="0" value="0">
                </div>
                <div class="form-item">
                    <p class="form-title">您的聯絡電話：</p>
                    <input id='fm_phone' type="tel" placeholder="請填入電話">
                </div>
                <div class="form-item">
                    <p class="form-title">喜帖寄送地址：</p>
                    <div class="both-sides-containter">
                        <input id='fm_postal_code' class="address_sm" type="number" placeholder="郵遞區號">
                        <a class="address-btn" href="https://www.post.gov.tw/post/internet/Postal/index.jsp?ID=208" target="_blank">查詢郵遞區號</a>
                        <br>
                        <input id='fm_address' class="right-wrp address_lg" type="text" placeholder="詳細地址">
                    </div>
                </div>
                <div class="form-item">
                    <p class="form-title">有沒有什麼想說的話：</p>
                    <textarea id="fm_say" rows="3"></textarea>
                </div>
                <a class="red-btn submit-btn"  href="javascript:wedding.createGuest();">送出</a>
            </div>
        </div>
    </section>
</div>

<!-- 相片全螢幕檢視 -->
<div class="photo-overlay">
    <div id="overlay-close" class="icon photo-overlay-close"></div>
    <div id="overlay-prev" class="icon photo-overlay-prev"></div>
    <div id="overlay-next" class="icon photo-overlay-next"></div>
    <div id="full-photo"></div>
</div>

</body>
</html>
<!--
畫面設計 : Evonne
程式實作 : Leo
-->