<?php
$ownURL = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"];

$html_before = <<< EOM
<!DOCTYPE html>
<html lang="ja">
<head>
  <title>画像を透明にするやつ - mizle.net</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="eai04191" />
  <style type="text/css">
    .sugoi {
      font-weight: bold;
    }
    .dark {
    }
    .light {
      opacity: 0.5;
    }
    .red {
      color: red;
    }
  </style>
</head>
<body>
<a href="https://github.com/eai04191/alpha_image"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/52760788cde945287fbb584134c4cbc2bc36f904/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f77686974655f6666666666662e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png"></a>
  <h1>画像を透過するやつ</h1>

  <section>
    <h1>使い方</h1>
    <p>{$ownURL}?src=<span class="sugoi">加工元画像URL</span>&opacity=<span class="sugoi">透明度</span></p>
    <h2>透明度について</h2>
    <p><span class="light">薄い</span> <span class="sugoi">0.0~1.0</span> <span class="dark">濃い</span></p>
  </section>
  
  <section>
    <h1>エラー</h1>
    <ul class="red"">

EOM;

$html_after = <<< EOM
    </ul>
  </section>
  <footer>
    <a href="http://mizle.net/">mizle.net</a> eai04191
  </footer>
</body>
</html>
EOM;

/* パラメーターがあるか確認　*/
if (!isset($_GET['src'])) {
    $error[] = ("srcが指定されていません。");
}
if (!isset($_GET['opacity'])) {
    $error[] = ("opacityが指定されていません。");
} elseif (!is_numeric($_GET['opacity'])) {
    $error[] = ("opacityが数字ではありません。");
}

/* error表示　*/
if (isset($error)) {
    /* パラメーターに問題ある場合の処理　*/
    echo $html_before;
    foreach ($error as $hoge){
      echo ("      <li>".$hoge."</li>\n");
    }
    echo $html_after;
}  else {
  
/* パラメーターが問題ない場合の処理　*/
  /* 画像の読み込み */
  $image = new Imagick($_GET['src']); //インスタンスを作る
  $image->setImageOpacity ($_GET['opacity']); //透過

  /* 画像を出力 */
  header("Content-Type: image/png");
  echo $image;

  $image->clear();

}
?>

