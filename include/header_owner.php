<!DOCTYPE html>
<html class="h-100" lang="ja">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    
    <?php if(isset($addhead)) echo $addhead ?>
    
</head>
<body class="d-flex flex-column h-100">

    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/dashboard.php">FC共闘 [管理サイト]</a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#headerNav" aria-controls="headerNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="navbar-collapse collapse" id="headerNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard.php">ダッシュボード</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="event.php">イベント作成</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="event_list.php">イベント一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="owner_reg.php">スタッフ登録</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="owner_logout.php">ログアウト</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- /.navbar-collapse --> 
    </header>