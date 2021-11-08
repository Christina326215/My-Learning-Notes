<?php

// 模組裡的實作
// 分為沒有要開放
// 與需要開放 -> 介面

// 封裝：把某個實作細節給某個實作細節給封裝起來，使用的人可以完全不用知道怎麼做，但使用的人需要知道介面有哪些參數。

class Person
{
    private $firstName; // 物件中的屬性名稱:名
    private $middleName; // 物件中的屬性名稱:中間名
    private $lastName;  // 物件中的屬性名稱:姓
    // 把變數函式名稱鎖定在範疇底下

    public function setName($lastName, $firstName)  // 物件中的方法
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getName()  // 物件中的方法
    {
        echo $this->lastName . " " .  $this->firstName . "<br>";
    }

    public function setPassportName($lastName, $middleName, $firstName)  // 物件中的方法
    {
        $this->firstName = $firstName;
        $this->middleName = $middleName;
        $this->lastName = $lastName;
    }

    public function getPassportName()  // 物件中的方法
    {
        echo $this->lastName . ", " . $this->middleName . "-" .  $this->firstName . "<br>";
    }
}

$person = new Person;

$person->setName("Lin", "Tina"); // 給予值
$person->getName(); // 輸出結果為： Lin Tina

$person->setPassportName("Wang", "Xiao", "Ming"); // 給予值
$person->getPassportName(); // 輸出結果為： Wang, Xiao-Ming
