# MySQL 指令

### pdo_connect.php

```
<?php
$servername =;
$username =;
$password =;
$dbname =;

try{
    $db_host= new PDO(
        "mysql:host={$servername}; dbname={$dbname};charset=utf8",
        $username, $password
    );
}catch (PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}
echo "資料庫連結成功";

// $db_host=null;
?>
```

### db_connect.php

```
$servername =;
$username =;
$password =;
$dbname =;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// 檢查連線
if ($conn->connect_error) {
      die("連線失敗: " . $conn->connect_error);
}
// echo "連線成功";
```

### 建立資料表

```
$sql = "CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    phone VARCHAR(30),
    email VARCHAR(30)
    )";

//檢查資料表是否新創建成功
if ($conn->query($sql) === TRUE) {
    echo "資料表 users 建立完成";
} else {
    echo "建立資料表錯誤: " . $conn->error;
}

$conn->close();
```

### 刪除欄位之索引

```
$sql="ALTER TABLE users DROP INDEX account";

if ($conn->query($sql) === TRUE) {
    echo "資料表 users 修改完成";
} else {
    echo "修改資料表錯誤: " . $conn->error;
}

$conn->close();
```

### 刪除欄位

```
$sql="ALTER TABLE users DROP COLUMN age";

if ($conn->query($sql) === TRUE) {
    echo "資料表 users 修改完成";
} else {
    echo "修改資料表錯誤: " . $conn->error;
}

$conn->close();
```

### 新增欄位

```
$sql="ALTER TABLE users ADD COLUMN age INT(3)";

if ($conn->query($sql) === TRUE) {
    echo "資料表 users 修改完成";
} else {
    echo "修改資料表錯誤: " . $conn->error;
}

$conn->close();
```

### 修改欄位名稱

```
//修改資料表欄位名稱，把userName改成name
$sql="ALTER TABLE users CHANGE COLUMN userName name VARCHAR(30)";

if ($conn->query($sql) === TRUE) {
    echo "資料表 users 修改完成";
} else {
    echo "修改資料表錯誤: " . $conn->error;
}

$conn->close();
```

### 新增欄位內容

```
<?php
require_once("../PDO_connect.php");

$sql = "INSERT INTO users (name, phone, email, account, create_time, valid) VALUES (?,?,?,?,?,?)";
$stmt = $db_host->prepare($sql);

$name = "Kelly";
$phone = "0912222222";
$email = "kelly@test.com";
$account = "kelly";
$create_time = date('Y-m-d H:i:s');
$valid = 1;

try {
    $stmt->execute([$name, $phone, $email, $account, $create_time, $valid]);
    echo "新資料已建立";
} catch (PDOException $e) {
    echo "資料庫連結失敗<br>";
    echo "Eroor: " . $e->getMessage() . "<br>";
    exit;
}

```

```
<?php
//檢查是否連線資料庫
require_once "../db_connect.php";

//檢查是否帶入資料
if(isset($_POST["fruit"])){
    $fruit=$_POST["fruit"];
}else{
    echo "沒有帶資料";
    exit;
}


$fruit=$_POST["fruit"];
$intro=$_POST["intro"];

//新增欄位之內容
$sql="INSERT INTO fruit (name , intro)
    VALUES ('$fruit', '$intro')";

if ($conn->query($sql) === TRUE) {
    echo "新增資料完成";
} else {
    echo "新增資料錯誤: " . $conn->error;
}

$conn->close();

header('location: create-fruit.php');


?>
```

### 修改欄位內容

```
<?php
require_once("../PDO_connect.php");
$sql="UPDATE users SET name=?, email=? WHERE id= ?";
$stmt=$db_host->prepare($sql);

$name="Adam";
$email="adam@test.com";
$id=10;


try{
    $stmt->execute([$name, $email, $id]);
    echo "資料修改完成";

}catch(PDOException $e){
    echo "資料庫修改失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

$db_host=null;
?>
```

```
<?php
require_once "../db_connect.php";

$id=$_POST["id"];
$phone=$_POST["phone"];
$name=$_POST["name"];
$email=$_POST["email"];


$sql="UPDATE users SET phone='$phone', name='$name', email='$email' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "修改資料完成";

} else {
    echo "修改資料錯誤: " . $conn->error;
}

// header('location: user-list.php');
header('location: user.php?id='.$id);
?>
```

### 取得產品及其分類

```
$sql = "SELECT product.*, category.name AS category_name FROM product
    JOIN category ON product.category = category.id
     ORDER BY product.name ASC LIMIT $start_item, $per_page";
$result = $conn->query($sql);  //只抓單頁的資料
//首先，SELECT資料表product的全部資料，
// 並且將資料表category的name更改名稱AS為category_name(因為兩資料表的name有重複)，
// FROM資料表product，
// 接著，JOIN資料表category，ON在資料表product的category等於category的id條件下。
```

```
$sqlTotal = "SELECT * FROM product";
$resultTotal = $conn->query($sqlTotal);  //抓所有頁數的資料
$total = $resultTotal->num_rows;   //共有幾筆
$pages = CEIL($total / $per_page);  //共有幾頁
```

```
$sqlCategory = "SELECT * FROM category";
$resultCategory = $conn->query($sqlCategory);
$category = array();
while ($rowCategory = $resultCategory->fetch_assoc()) {  //把資料存取成關聯式陣列。
    $category[$rowCategory["id"]] = $rowCategory["name"];
}
// $category=array(
//     "1"=>"men",
//     "2"=>"women"
// );
```

### PDO prepared statement

寫法一：

```
<?php
require_once("../PDO_connect.php");

$id=$_GET["id"];
$sql="SELECT * FROM users WHERE id = ?";
$stmt=$db_host->prepare($sql);
$stmt->execute([$id]);  //使用非關聯式陣列的方式

try{
    while($row=$stmt->fetch()){
        echo $row["id"].". ".$row["name"].": ".$row["email"];
        echo "<br>";
    }

}catch(PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}


$db_host=null;
?>
```

寫法二：

```
<?php
require_once("../PDO_connect.php");

$stmt=$db_host->prepare("SELECT * FROM users WHERE account = :account");
$account="jack";
try{
    $stmt->execute(array(":account"=>$account));
    while($row=$stmt->fetch()){
        print_r($row);
        echo "<br>";
    }

}catch(PDOException $e){
    echo "資料庫連結失敗<br>";
    echo "Error: ".$e->getMessage(). "<br>";
    exit;
}

?>
```

### rowCount

> 使用 rowCount 可以知道共有多少筆資料。

```
$stmt = $db_host->prepare("SELECT * FROM users");
$stmt->execute();
echo $stmt->rowCount();
```

### PDO fetch

- fetch

```
$stmt->execute();
    while($row=$stmt->fetch()){
        echo "<a href='user.php?id=".$row["id"]."'>".$row["id"].": ".$row["name"]."</a>";
        echo "<br>";
    }
```

- fetchALL PDO::FETCH_ASSOC

```
$stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  //用關聯式陣列key對value的方式把資料撈出來
    foreach($rows as $row){
        // var_dump($row);
        echo "<a href='user.php?id=".$row["id"]."'>".$row["id"].": ".$row["name"]."</a>";
        echo "<br>";
    }
```

- fetchALL PDO::FETCH_NUM

```
$stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_NUM);
    foreach($rows as $row){
        var_dump($row);
        // echo "<a href='user.php?id=".$row[0]."'>".$row[1].": ".$row[2]."</a>";
        echo "<br>";
    }
```

- fetchALL PDO::FETCH_BOTH

```
$stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_BOTH);
    foreach($rows as $row){
        var_dump($row);
        // echo "<a href='user.php?id=".$row[0]."'>".$row[1].": ".$row[2]."</a>";
        echo "<br>";
    }
```
