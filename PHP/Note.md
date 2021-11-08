# PHP

### 變數範圍

> 有一個變數型態為靜態變數，使用 static 關鍵字來宣告，靜態變數會一直存在，直到程式結束。例如用在一個函式可能會重複被叫用，而想在每次叫用時使用同一個變數，就可以使用靜態變數。

```
<?php
$a = 99; //全域變數
function show()
{
    $b = 10; // 區域變數
    static $c = 1; // 區域變數+靜態變數

    // echo "a is $a \n";  //無法取用！
    echo "b is $b, \n";
    echo "c is $c, \n";
    $b += 1;
    $c += 1;
}

show();
show();

// 輸出：
// b is 10, c is 1, b is 10, c is 2,
```

### 取得全域變數的方法

> 當宣告全域變數時，會存在 $GLOBALS 的陣列裡，之後要取用可以透過 key 對 value 的方式取得

```
<?php
$a = 2;
function show()
{
    echo $GLOBALS['a'];
}
show();
// 輸出： 2
```

### 常數

> 常數是一個內定數值不因程式而改變的儲存空間
>
> 1. 沒有使用範圍的問題
> 2. 定義後不可更改
> 3. 不可重複定義
> 4. 只可使用標量資料類型
>    變數需要以「$」開頭，但常數不用（也不允許）以「$」開頭

### 單引號標示「’」

> - 使用單引號時，將變數辨認為字串。

```
<?php
$foo = 'This is a string.';

echo 'foo is $foo.</br>';  // foo is $foo.
echo 'Hello World!.</br>'; // Hello World!.
echo 'You deleted C:\*.*?'; // You deleted C:\*.*?
```

### 雙引號標示「“」

> - 使用雙引號時，將變數辨認為變數。

```
<?php
$foo = "This is a string.";

echo "foo is $foo.</br>";  // foo is This is a string..
echo "Hello World!.</br>"; // Hello World!.
echo "You deleted C:\*.*?"; // You deleted C:\*.*?
```

### 檢查字串

```
echo strlen("Hello World!");  //字串長度12
echo str_word_count("Hello Kitty"); //字串字數2

echo substr("Samatha", 1) . "</br>"; // amatha
echo substr("Samatha", -2) . "</br>"; // ha
echo substr("Samatha", -3, 1) . "</br>"; // t

echo strstr("john@test.com", "@"); // @test.com
echo strstr("john@test.com", "@", true); // john

echo strpos("Hello World!", "World"); // 6
```

```
<?php

$string = "Hello John,
How are you?";
$token = strtok($string, " \n");  //以空格作字串拆解

while ($token !== false) {
    echo "$token</br>";
    $token = strtok(" \n");
}

// 輸出：
// Hello
// John,
// How
// are
// you?

echo str_replace("world", "kitty", "Hello world!"); //字串取代
// 輸出：
// Hello kitty!
```

### 依字串分割字串，並轉為陣列。

```
$string =  "Hello John, how are you?";
$stringArr = explode(" ", $string);
print_r($stringArr);

// Array ( [0] => Hello [1] => John, [2] => how [3] => are [4] => you? )
```

### AND 和 && 的分別

> AND 和 && 都是「邏輯與」，兩者唯一的分別是運行的優先次序（Operator Precedence）不同。「&&」的優先次序比「=」高，而「=」的優先次序比「AND」高。
> 如果需要使用「AND」來提高代碼的可續性，請使用括號——「(」和「)」來處理。

### OR 和 || 的分別

> OR 和 || 都是「邏輯或」，兩者唯一的分別是運行的優先次序（Operator Precedence）不同。「||」的優先次序比「=」高，而「=」的優先次序比「OR」高。
> 如果需要使用「OR」來提高代碼的可續性，請使用括號——「(」和「)」來處理。

```
$bear = false;
$panda = true;

$koala = $panda AND $bear;
$firefox = $panda && $bear;

$teddy = $bear OR $panda;
$freddy = $bear || $panda;

echo '$koala = ' . (int) $koala . '<br />'; // 1 (true)
echo '$firefox = ' . (int) $firefox . '<br />'; // 0 (false)
echo '$teddy = ' . (int) $teddy . '<br />'; // 0 (false)
echo '$freddy = ' . (int) $freddy . '<br />'; // 1 (true)
```

#### 參考運算子「&」：用來取得變數的記憶體位置，而不是變數的值，所以若針對該位置做任何動作，都會影響到被參考的變數內容。

```
$a = 5;
$b = &$a;

echo $a; // 5
echo $b; // 5

$a = 0;

echo $a; // 0
echo $b; // 0
```

### 三元運算子

> (條件式)?(成立執行):(不成立執行);

- 若使用者沒有輸入資料(變數為空值時)，可預設 10 筆交易紀錄的設計，等於使用 empty($limit)判斷變數是否為空值的功能。

```
$limit = null;
echo $limit ?: 10;   // 10
```

- null 合併運算子「??」：等於使用 isset()檢查變數是否存在的功能，若為 null 或沒有事先設定變數，就會給予預設值。

```
$name = $girlfriend ?? '沒有這個人';
echo $name;   // 沒有這個人
```

### Switch

```
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo '查詢清單';
        break;
    case 'POST':
        echo '新增資料';
        break;
    case 'PATCH':
    case 'PUT':
        echo '更新資料';
        break;
    case 'DELETE':
        echo '刪除資料';
        break;
    default:
        echo '無法處理您的請求';
        break;
}
```

### 迴圈 Loop

- for

```
for ($i = 0; $i < 10; $i++) {
    echo $i . "<br>";
}
```

- while

```
$i = 0;
while ($i < 10) {
    echo $i . '<br>';
    $i++;
}
```

- do...while

```
$i = 0;
do {
    echo $i . '<br>';
    $i++;
} while ($i < 10);
```

- foreach

```
$data = ['小白', '小黑', '小紅', '小黃', '小綠'];
foreach ($data as $item) {
    echo $item . '<br>';
}
```

### Function

```
function sum($x, $y)
{
    $total = $x + $y;
    return $total;
}
$a = 2;
$b = 3;
$sumValue = sum($a, $b);
echo $sumValue; // 5
$total = sum(5, 5);
echo $total; // 10
```

## 物件導向設計

### 類別 Class

- 類別由許多成員變數及函數組成，類別命名方式使用大寫字首，函數在類別中稱為類別的方法，變數則為類別的屬性。
- 使用自身的屬性需要加 $this 關鍵字。
  > 如下範例，定義一個類別後，使用 new 產生類別的物件，可以指定 $myDog 這隻狗的年齡(基本特性)設定 1，表示出生一年。最後一行 $myDog 物件呼叫類別的方法，把年齡顯示出來，呈現『我的年齡 1 歲』。

```
class Dog
{
    public $age;  // 屬性

    public function sayAge()  // 方法
    {
        echo "我的年齡{$this->age}歲";
    }
}
$myDog = new Dog();  // 透過class來建立新物件
$myDog->age = 1;
$myDog->sayAge();
// 我的年齡1歲
```

- **construct 建構子 與 **destruct 解構子

```
class Dog
{
    public $age; // 屬性

    public function __construct($age)
    {
        echo "汪汪汪，我誕生了！<br/>";
        $this->age = $age;
        // 前者是類別自身屬性，後者是建立物件時傳入的值。
    }

    public function sayAge()
    {
        echo "我的年齡 {$this->age} 歲";
    }

    public function __destruct()
    {
        echo "<br/>PHP程式執行結束Dog Class關閉";
    }
}

$myDog = new Dog(1);
$myDog->sayAge();

// 輸出：
// 汪汪汪，我誕生了！
// 我的年齡 1 歲
// PHP程式執行結束Dog Class關閉
```

### 繼承 Extends

> 建立一個大範圍的統稱，使用繼承的方式來繼承兩個類別的關係，如下範例 Dog、Cat 兩個類別都使用 extends 關鍵字繼承 Animals 的類別。

```
// 動物類別
class Animal
{
    public $age;

    public function sayAge()
    {
        echo "我的年齡 {$this->age} 歲";
    }
}

class Dog extends Animal
{
};

class Cat extends Animal
{
};

$myDog = new Dog();
$myDog->age = 1;
$myDog->sayAge();
// 我的年齡 1 歲

$myCat = new Cat();
$myCat->age = 2;
$myCat->sayAge();
// 我的年齡 2 歲
```

### 封裝 Encapsulation

> 封裝的作用是把類別的細節隱藏起來，讓類別更安全，可以減少一些耦合性(耦合的意思是互相干擾糾纏不清)。

##### public：可以在任何地方存取。

##### protected：可以在自身類別與子類別中存取。

##### private：只能在自身類別存取。

```
class Animal
{
    public $name;
    protected $age;
    private $weight;

    public function __construct($name, $age, $weight)
    {
        $this->name = $name;
        $this->age = $age;
        $this->weight = $weight;
    }

    public function animalShowdata()
    {
        echo "暱稱： $this->name <br>";
        echo "年齡： $this->age <br>";
        echo "體重： $this->weight <br>";
    }
}

class Dog extends Animal
{
    public function dogShowData()
    {
        echo "暱稱： $this->name <br>";
        echo "年齡： $this->age <br>";
        echo "體重： $this->weight <br>";
    }
}

$myDog = new Dog('多多', 3, '3KG');

// 1. 測試自身類別讀取屬性
$myDog->animalShowData();
// 暱稱： 多多
// 年齡： 3
// 體重： 3KG
// (皆正常顯示Animal屬性)

// 2. 測試物件可讀取的屬性
echo $myDog->name;  // 正常讀取：多多(public)
echo $myDog->age;  // 無法讀取 (protected)
echo $myDog->weight; // 無法讀取(private)

// 3. 測試子類別可以讀取的屬性
$myDog->dogShowData();   // 只能讀取public、protected
```

```
<?php
/**
 * Define MyClass
 */
class MyClass
{
    public $public = 'Public';
    protected $protected = 'Protected';
    private $private = 'Private';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj = new MyClass();
echo $obj->public;  // 這行能被正常執行
echo $obj->protected;  // 這行會產生一個致命錯誤
echo $obj->private;  // 這行也會產生一個致命錯誤
$obj->printHello();  // 輸出 Public、Protected 和 Private

/**
 * Define MyClass2
 */
class MyClass2 extends MyClass
{
    // 可以對 public 和 protected 進行重定義，但 private 而不能
    protected $protected = 'Protected2';

    function printHello()
    {
        echo $this->public;
        echo $this->protected;
        echo $this->private;
    }
}

$obj2 = new MyClass2();
echo $obj2->public;  // 這行能被正常執行
echo $obj2->private;  // 未定義 private
echo $obj2->protected;  // 這行會產生一個致命錯誤
$obj2->printHello();  // 輸出 Public、Protected2 和 Undefined
```

```
<?php
/**
 * Define MyClass
 */
class MyClass
{
    // 宣告一個公有的建構函式
    public function __construct() { }

    // 宣告一個公有的方法
    public function MyPublic() { }

    // 宣告一個受保護的方法
    protected function MyProtected() { }

    // 宣告一個私有的方法
    private function MyPrivate() { }

    // 此方法為公有
    function Foo()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate();
    }
}

$myclass = new MyClass;
$myclass->MyPublic();  // 這行能被正常執行
$myclass->MyProtected();  // 這行會產生一個致命錯誤
$myclass->MyPrivate();  // 這行會產生一個致命錯誤
$myclass->Foo();  // 公有，受保護，私有都可以執行

/**
 * Define MyClass2
 */
class MyClass2 extends MyClass
{
    // 此方法為公有
    function Foo2()
    {
        $this->MyPublic();
        $this->MyProtected();
        $this->MyPrivate();  // 這行會產生一個致命錯誤
    }
}

$myclass2 = new MyClass2;
$myclass2->MyPublic();  // 這行能被正常執行
$myclass2->Foo2();  // 公有的和受保護的都可執行，但私有的不行

class Bar
{
    public function test()
    {
        $this->testPrivate();
        $this->testPublic();
    }

    public function testPublic()
    {
        echo "Bar::testPublic\n";
    }

    private function testPrivate()
    {
        echo "Bar::testPrivate\n";
    }
}

class Foo extends Bar
{
    public function testPublic()
    {
        echo "Foo::testPublic\n";
    }

    private function testPrivate()
    {
        echo "Foo::testPrivate\n";
    }
}

$myFoo = new foo();
$myFoo->test();  // Bar::testPrivate
                 // Foo::testPublic
```

```
https://ithelp.ithome.com.tw/articles/10207680
<?php
class MyClass
{
    public $prop1 = "I'm a class property!";

    public function __construct()          //物件被建立時呼叫訊息。
    {
        echo 'The class "' . __CLASS__ . '" was initiated!<br />';
    }

    public function __destruct()           //物件被結束時呼叫訊息。
    {
        echo 'The class "' . __CLASS__ . '" was destroyed.<br />';
    }

    public function __toString()           //將物件轉換為字串。
    {
        echo "Using the toString method: ";
        return $this->getProperty();
    }

    public function setProperty($newval)
    {
        $this->prop1 = $newval;
    }

    protected function getProperty()
    {
        return $this->prop1 . "<br />";
    }
}

class MyNewClass extends MyClass
{
    public function __construct()
    {
        echo 'A new constructor in "'. __CLASS__ . '".<br />';
    }

    public function newMethod()           //在新類別裡宣告一個屬性與方法。
    {
        echo 'From a new method in "' . __CLASS__ . '".<br />';
    }

    public function getProperty()         //使用`public`從父類別繼承`getProperty()`。
    {
        return $this->prop1 . "<br />";
    }
}

$obj = new MyNewClass;                    //建立`MyNewClass`的新物件。

echo $obj->getProperty();                 //呼叫繼承父類別的`getProperty()`。

// A new constructor in "MyNewClass".
// I'm a class property!
// The class "MyClass" was destroyed.
```

### 介面 Interface

> 使用介面（interface），可以指定某個類別必須實現哪些方法，但不需要定義這些方法的具體內容。

```
interface Age
{
    public function getAge();
}

interface Foot
{
    public function run();
    public function walk();
}

class Dog implements Age, Foot
{
    public $age;

    public function getAge()
    {
        return $this->age * 7 . '<br>';
    }

    public function run()
    {
        return '我用四隻腳跑步' . '<br>';
    }

    public function walk()
    {
        return '我用四隻腳走路' . '<br>';
    }
}

$dog = new Dog();
$dog->age = 1;
echo $dog->getAge(); // 7
echo $dog->run(); // 我用四隻腳跑步
echo $dog->walk(); // 我用四隻腳走路
```

```
https://iter01.com/453960.html
<?php

// 宣告一個'iTemplate'介面
interface iTemplate
{
    public function setVariable($name, $var);
    public function getHtml($template);
}

// 實現介面
class Template implements iTemplate
{
    private $vars = array();

    public function setVariable($name, $var)
    {
        $this->vars[$name] = $var;
    }

    public function getHtml($template)
    {
        foreach($this->vars as $name => $value) {
            $template = str_replace('{' . $name . '}', $value, $template);
        }

        return $template;
    }
}
```

### 命名空間 namespace

> 一個檔案一個類別為原則，介面也是一樣，撰寫命名空間時以根目錄 MyProject 作為虛擬路徑的開始，根目錄通常是專案的名稱，在專案中預計使用 Interfaces 資料夾儲存所有介面的檔案，如下範例將 Age 介面獨立出來取名為 Age.php，並放在 Interfaces 資料夾，檔案一開始要撰寫的就是宣告命名空間。

```
namespace MyProject\Interfaces;

interface Age
{
    // 程式內容
}
```

#### 使用檔案

> 要在其他檔案呼叫上面命名空間的介面，使用 use 關鍵字。

```
namespace MyProject;

use MyProject\InterFaces\Age; //使用use引用Age介面

class Dog implements Age
{
    // 程式內容
}
```

> 有了命名空間方便我們可以載入各式各樣套件，假設我們專案當中有 Dog 類別，如果有其他套件有撰寫到相同名稱 Dog 類別就會發生衝突，命名空間可以解決這樣的問題，若同時仔入專案中可以使用 as 關鍵字來設定別名。

```
use MyProject\Dog;
use YourProject\Dog as YourProjectDog;

$myDog = new Dog();
$yourDog = new YourProjectDog();
```

#### PHP Class 基本物件導向概念

https://iter01.com/453960.html

```
<?php
class Site
{
    /* 成員變數 */
    var $url;
    var $title;

    /* 成員函式 */
    function setUrl($par)
    {
        $this->url = $par;
    }

    function getUrl()
    {
        echo $this->url . "</br>";
    }

    function setTitle($par)
    {
        $this->title = $par;
    }

    function getTitle()
    {
        echo $this->title . "</br>";
    }
}

$learnku = new Site;
$laravel = new Site;
$google = new Site;

// 呼叫成員函式，設定標題和URL
$learnku->setTitle("黑客學習社群");
$laravel->setTitle("PHP-Web 開源框架");
$google->setTitle("Google 搜尋");

$learnku->setUrl('www.learnku.com');
$laravel->setUrl('www.laravel.com');
$google->setUrl('www.google.com');

// 呼叫成員函式，獲取標題和URL
$learnku->getTitle();
$laravel->getTitle();
$google->getTitle();

$learnku->getUrl();
$laravel->getUrl();
$google->getUrl();

// 輸出結果：
// 黑客學習社群
// PHP-Web 開源框架
// Google 搜尋
// www.learnku.com
// www.laravel.com
// www.google.com
```

### PHP 建構函式 \_\_construct()

https://iter01.com/453960.html

> 主要用來在建立物件時初始化物件， 即為物件成員變數賦初始值，在建立物件的語句中與 new 運算子一起使用。

```
<?php
class Site
{
    /* 成員變數 */
    var $url;
    var $title;

    function __construct($par1, $par2)
    {
        $this->url = $par1;
        $this->title = $par2;
    }

    function getUrl()
    {
        echo $this->url . "</br>";
    }

    function getTitle()
    {
        echo $this->title . "</br>";
    }
}

$learnku = new Site('www.learnku.com', '黑客學習社群');
$laravel = new Site('www.laravel.com', 'PHP-Web 開源框架');
$google = new Site('www.google.com', 'Google 搜尋');

// 呼叫成員函式，獲取標題和URL
$learnku->getTitle();
$laravel->getTitle();
$google->getTitle();

$learnku->getUrl();
$laravel->getUrl();
$google->getUrl();

// 輸出結果：
// 黑客學習社群
// PHP-Web 開源框架
// Google 搜尋
// www.learnku.com
// www.laravel.com
// www.google.com
```

### PHP 解構函式 \_\_destruct()

https://iter01.com/453960.html

> 當物件結束其生命週期時（例如物件所在的函式已呼叫完畢），系統自動執行解構函式。

```
<?php
class MyDestructableClass
{
    function __construct()
    {
        print "建構函式\n";
        $this->name = "MyDestructableClass";
    }

    function __destruct()
    {
        print "銷毀 " . $this->name . "\n";
    }
}

$obj = new MyDestructableClass();

// 輸出：
// 建構函式
// 銷毀 MyDestructableClass
```

### 常數 Const

```
<?php
class MyClass
{
    const constant = '常量值';

    function showConstant()
    {
        echo  "我在showConstant方法中：" . self::constant .  "<br>";
    }
}

echo "我在物件之外呼叫class：" . MyClass::constant . "<br>";

$classname = "MyClass";
echo "我在物件之外使用變數呼叫class：" . $classname::constant . "<br>"; // 自 5.3.0 起

$class = new MyClass();
$class->showConstant();

echo "new MyClass():" . $class::constant . "<br>"; // 自 PHP 5.3.0 起

// 輸出結果：
// 我在物件之外：常量值
// 使用變數呼叫class：常量值
// 我在showConstant方法中：常量值
// new MyClass():常量值
```

### PHP 的物件 4 種定義變數可用範圍

定義方法使用範圍由大到小

static(靜態變數) > public(公有變數) > protected > private(私有變數)

static(靜態變數):
使用時不需要特別建立物件，就可以直接使用；
例如：類別名稱::$static 變數;

- 如果在變數前面加上關鍵字 static，則為靜態變數，靜態變數會一直存在，直到程式結束。例如用在一個函式可能會重複被叫用，而想在每次叫用時使用同一個變數，就可以使用靜態變數。

- 靜態變數有一些特性：

1. 靜態變數的指派必須要直接給一個定值，不可以是運算、變數、函式結果和建立物件等來源。
2. 重複的宣告靜態變數時，以最後一次宣告的值為初始值。

```
<?php
function sum() {
   static $a = 1;

   if ($a < 10) {
      echo $a;
      $a++;
      sum();
   }
}

sum();
?>

// 輸出結果： 123456789
```

public(公有變數):
必須建立物件後才可以使用，但是可以在類別以外的地方做使用；

例如：$變數 = new 類別(); $變數->public 變數;(不需加 $ 字號)

protected:
必須建立物件後才可以使用，不可以在類別以外的地方做使用，但是可以被繼承並在子類別使用。

private(私有變數):
必須建立物件後才可以使用，只可以在這個類別內使用且不能被繼承。

```
class Father{
    //不需建立物件可以直接使用
    static $static_value = "static";

    //需要建立物件，但是在類別以外也可以用
    public $public_value = "public";

    //只有這個類別才能使用
    private $private_value = "private";

    //只有這個類別和子類別才能使用
    protected $protected_value = "protected";

    //private 變數只能在類別內的函數使用
    function getprivate(){
        return $this->private_value;
    }
}

//*static 變數不需建立物件可以直接使用
echo Father::$static_value;

//*建立後可以直接呼叫 public 變數讓類別外的函數使用
$testFather = new Father();
echo $testFather->public_value;

//*使用protected變數的繼承特性之前，必須先建立子類別來繼承父類別
class son extends Father{
    function __construct(){
        //可直接從父類別取得變數
        echo $this->protected_value."子類別";
    }

    function testextend(){
        return  $this->protected_value."來自testextend";
    }

}

//當子物件被建立時會直接從父類別取得變數，下面是兩種不同的做法
$testSon = new son();
echo $testSon->testextend();

//*private 變數只能在類別內的函數使用，不能像 public 變數直接使用也無法被繼承
// echo $testFather->private_value; 這行會失敗
echo $testFather->getprivate();
```

### 物件導向的程式語言有三大特性，分別是：封裝、繼承和多型。

https://tw511.com/a/01/3444.html

1. 物件導向的封裝特性就是將類中的成員屬性和方法內容細節盡可能地隱藏起來，確保類外部程式碼不能隨意存取類中的內容。

2. 物件導向的繼承特性使得子類可繼承父類別中的屬性和方法，提高類程式碼的複用性。

3. 物件導向的多型特性是最常用到的一種特性。所謂多型，是指同一個東西不同形態的展示。

### 抽象 Abstract Class

> 任何一個 Class，如果它裡面至少有一個方法是被宣告為抽象的，那麼這個 Class 就必須被宣告為抽象的。
> 定義為抽象的類不能被實例化。
> 被定義為抽象的方法只是宣告瞭其呼叫方式（引數），不能定義其具體的功能實現。
> 繼承一個抽象 Class 的時候，子 Class 必須定義父 Class 中的所有抽象方法；另外，這些方法的訪問控制必須和父 Class 中一樣（或者更為寬鬆）。例如某個抽象方法被宣告為 protected，那麼子 Class 中實現的方法就應該宣告為 protected 的或者 public，而不能定義為 private。

```
<?php
abstract class AbstractClass
{
    // 強制要求子類定義這些方法
    abstract protected function getValue();
    abstract protected function prefixValue($prefix);

    // 普通方法（非抽象方法）
    public function printOut()
    {
        print $this->getValue() . "<br>";
    }
}

class ConcreteClass1 extends AbstractClass
{
    protected function getValue()
    {
        return "ConcreteClass1";
    }

    public function prefixValue($prefix)
    {
        return "{$prefix}ConcreteClass1";
    }
}

class ConcreteClass2 extends AbstractClass
{
    public function getValue()
    {
        return "ConcreteClass2";
    }

    public function prefixValue($prefix)
    {
        return "{$prefix}ConcreteClass2";
    }
}

$class1 = new ConcreteClass1;
$class1->printOut();
echo $class1->prefixValue('FOO_') . "<br>";

$class2 = new ConcreteClass2;
$class2->printOut();
echo $class2->prefixValue('FOO_') . "<br>";

// 輸出：
// ConcreteClass1
// FOO_ConcreteClass1
// ConcreteClass2
// FOO_ConcreteClass2

```

```
<?php
abstract class AbstractClass
{
    // 我們的抽象方法僅需要定義需要的引數
    abstract protected function prefixName($name);
}

class ConcreteClass extends AbstractClass
{

    // 我們的子類可以定義父類簽名中不存在的可選引數
    public function prefixName($name, $separator = ".")
    {
        if ($name == "Pacman") {
            $prefix = "Mr";
        } elseif ($name == "Pacwoman") {
            $prefix = "Mrs";
        } else {
            $prefix = "";
        }
        return "{$prefix}{$separator} {$name}";
    }
}

$class = new ConcreteClass;
echo $class->prefixName("Pacman"), "<br>";
echo $class->prefixName("Pacwoman"), "<br>";

// 輸出：
// Mr. Pacman
// Mrs. Pacwoman
```

### 靜態 Static 關鍵字

> 宣告類屬性或方法為 static(靜態)，就可以不例項化類而直接訪問。
> 靜態屬性不能通過一個類已例項化的物件來訪問（但靜態方法可以）。
> 由於靜態方法不需要通過物件即可呼叫，所以 偽變數 $this 在靜態方法中不可用。
> 靜態屬性不可以由物件通過 -> 操作符來訪問。

```
<?php
class Foo
{
    public static $my_static = 'foo';

    public function staticValue()
    {
        return self::$my_static;
    }
}

print Foo::$my_static . "<br>";
$foo = new Foo();

print $foo->staticValue() . "<br>";

// 輸出：
// foo
// foo
```

### Final 關鍵字

> 如果父類中的方法被宣告為 final，則子類無法覆蓋該方法。如果一個類被宣告為 final，則 不能被繼承。

```
<?php
class BaseClass
{
    public function test()
    {
        echo "BaseClass::test() called" . PHP_EOL;
    }

    final public function moreTesting()
    {
        echo "BaseClass::moreTesting() called"  . PHP_EOL;
    }
}

class ChildClass extends BaseClass
{
    public function moreTesting()
    {
        echo "ChildClass::moreTesting() called"  . PHP_EOL;
    }
}
// 報錯資訊 Fatal error: Cannot override final method BaseClass::moreTesting()
```

### 呼叫父類構造方法 Parent

```
<?php
class BaseClass
{
    function __construct()
    {
        print "BaseClass 類中構造方法" . "<br>";
    }
}
class SubClass extends BaseClass
{
    function __construct()
    {
        parent::__construct();  // 子類構造方法不能自動呼叫父類的構造方法
        print "SubClass 類中構造方法" . "<br>";
    }
}
class OtherSubClass extends BaseClass
{
    // 繼承 BaseClass 的構造方法
}

// 呼叫 BaseClass 構造方法
$obj = new BaseClass();

// 呼叫 BaseClass、SubClass 構造方法
$obj = new SubClass();

// 呼叫 BaseClass 構造方法
$obj = new OtherSubClass();

// 輸出：
// BaseClass 類中構造方法
// BaseClass 類中構造方法
// SubClass 類中構造方法
// BaseClass 類中構造方法
```

### Closure 閉包或匿名函式

```
<?php

$name = "Mike";

$greet = function () use ($name) {
    echo "Hello, $name!";
};
$greet();

// Hello, Mike!
```
