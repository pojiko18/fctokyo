<?php
//共通に使う関数を記述

//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


//DB接続関数
function dbcon(){

  try {
    //Password:MAMP='root',XAMPP=''
    // $pdo = new PDO("mysql:dbname=pojico18_php02;charset=utf8;host=mysql2017.db.sakura.ne.jp","pojico18","pojiko18-php02");
    $pdo = new PDO('mysql:dbname=gs_fctokyo;charset=utf8;host=localhost','root','root'); // ココはコピペでＯＫ
    return $pdo;

  } catch (PDOException $e) {
    exit('DBConnectionError:'.$e->getMessage()); //exitは処理を止める
  }
}

//ログイン認証チェック関数
function loginCheck(){
  if( !isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    echo  "LOGIN Error!";
    exit();
  }else{
    session_regenerate_id(true);
    $_SESSION["chk_ssid"] = session_id();
  }  
}

//SQLエラー関数：sql_error($stmt) $stmは第一引数

function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]); //2番目だけが読める英語になっている
    }


//リダイレクト関数: redirect($file_name)
function redirect($filename){
        
        header("Location: $filename");
        exit();
    }


//fileUpload("送信名","アップロード先フォルダ");
function fileUpload($fname,$path){
    if (isset($_FILES[$fname] ) && $_FILES[$fname]["error"] ==0 ) {
        //ファイル名取得
        $file_name = $_FILES[$fname]["name"];
        //一時保存場所取得
        $tmp_path  = $_FILES[$fname]["tmp_name"];
        //拡張子取得
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        //ユニークファイル名作成
        $file_name = date("YmdHis").md5(session_id()) . "." . $extension;
        // FileUpload [--Start--]
        $file_dir_path = $path.$file_name;
        if ( is_uploaded_file( $tmp_path ) ) {
            if ( move_uploaded_file( $tmp_path, $file_dir_path ) ) {
                chmod( $file_dir_path, 0644 );
                return $file_name; //成功時：ファイル名を返す
            } else {
                // return "noimg.png"; //失敗時：ファイル移動に失敗
              return 1;
            }
        }
    }else{
        //  return "noimg.png"; //失敗時：ファイル取得エラー
      return 2;
    }
}


// 生年月日作成
function birthdayLoop($start, $end, $selection=''){
    // echo '<option value="">--</option>';
    for($i=$start; $i<=$end; $i++){
        $i = sprintf('%02d', $i);
        $selected = $i==$selection?'selected':'';
        echo 
        "<option value=\"{$i}\" $selected>{$i}</option>";
    }
}

?>




