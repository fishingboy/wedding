<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<link rel="stylesheet" href="/third-party/bootstrap/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="/third-party/bootstrap/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<style>
    .base {min-width: 800px;}
    .td-text {width:200px;}
</style>
</head>
<body>
    <div class="base">
        <h1>賓客資料</h1>
        <div>
            總填寫人數: <?= $statistic['total']['total'] ?>,
            男方填寫人數: <?= $statistic['total']['man'] ?>,
            女方填寫人數: <?= $statistic['total']['women'] ?>
        </div>
        <div>
            總出席人數: <?= $statistic['peoples']['total'] ?>,
            男方出席人數: <?= $statistic['peoples']['man'] ?>,
            女方出席人數: <?= $statistic['peoples']['women'] ?>
        </div>
        <div>
            總吃素人數: <?= $statistic['vegan_peoples']['total'] ?>,
            男方吃素人數: <?= $statistic['vegan_peoples']['man'] ?>,
            女方吃素人數: <?= $statistic['vegan_peoples']['women'] ?>
        </div>
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>姓名</th>
                <th>關係</th>
                <th>電話</th>
                <th>地址</th>
                <th>出席/吃素</th>
                <th>想說的話</th>
            </tr>
            <?php foreach ($guests as $i => $guest): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $guest['name'] ?></td>
                    <td><?= $guest['group_name'] ?></td>
                    <td><?= $guest['phone'] ?></td>
                    <td class="td-text"><?= $guest['postal_code'] . " " . $guest['address'] ?></td>
                    <td><?= $guest['peoples'] ?>/<?= $guest['vegan_peoples'] ?></td>
                    <td class="td-text"><?= $guest['say'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>