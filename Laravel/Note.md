# Laravel 初學筆記

學習來源：第 12 屆 iThome 鐵人賽 為你自己學 Laravel（影片組）系列
https://itw01.com/84UDAE9.html

#### 建立新專案

```
laravel new my-blog
```

#### 啟動後端

```
php artisan serve
```

#### 建立新 Controller

```
php artisan make:controller WelcomeController
```

```
php artisan make:controller PostsController --resource

=>建立function
index() 列表
create() 新增表單
store() 表單送出後，將create()送過來
show($id) (index列表的)單筆頁面
edit($id) (index列表的)單筆頁面
update(Request $request, $id) 編輯頁面送出後，會到這裡
destroy($id) 把某筆頁面刪掉
```

#### 建立新 Migration

> Migration 是資料表的歷史成長紀錄

```
php artisan make:migration create_posts_table --create="posts"

touch database/exemple-app.mysql

php artisan migrate

// create_posts_table為要製作的class檔案名
// --create="posts"的posts為資料表名稱
```

```
php artisan make:migration aabb --table="posts"

php artisan make:migration add_subtitle_to_posts
```

#### 檢查 Migration

```
php artisan migrate
```

#### Migration 倒退

```
php artisan migrate:rollback
```

#### Model

> Model 不等於資料庫，而是廣義的資料抽象概念。
> Model = 依照 Active Record 模式設計的產物
> ![](https://i.imgur.com/g2RnOxj.png)

#### Active Record

https://zh.wikipedia.org/wiki/Active_Record

> 把從資料表的一筆資料“欄位”包裝成一個物件，並可以在物件上增加額外的“商業邏輯”“基本操作”，讓資料的存取更便利。
> ![](https://i.imgur.com/9Ok4EfG.png)

#### Eloquent ORM

https://zh.wikipedia.org/wiki/%E5%AF%B9%E8%B1%A1%E5%85%B3%E7%B3%BB%E6%98%A0%E5%B0%84

> ORM = Object Relational Mapping
> 簡化資料庫操作語法

#### 新增 Model

```
php artisan make:model Post
// model名稱通常用大寫單數(駝峰式寫法)，例如： Post
// 對應到的table通常使用小寫複數(加底線)，例如： posts

php artisan make:model Post --migration
php artisan migrate
// 同時建立Model及Migration
```

#### 操作 Model

```
php artisan tinker
```

- 新增及查詢資料

```
// 取得Model為Book的所有資料
Book::all()

// 取得Model為Book的資料筆數
Book::count()

// 取得Model為Book的第一筆資料
Book::first()

// 也可以將第一筆資料給定變數
// 新增資料
$b1 = Book::first()

// 尋找id=1的資料
Book::find(1)
Book::findOrFail(100)

// 查詢price=100的資料，形成陣列資料，方便之後使用foreach
Book::where("price",100)->get()

// 搜尋關鍵字
Book::where("title","like","為你自己學%")->get()
// id反向排序
Book::where("title","like","為你自己學%")->orderBy('id','desc')->get()

// 計算price欄位的總額或平均
Book::sum('price')
Book::avg('price')
Book::max('price')
Book::min('price')

// 建立一個物件，變數為$b
$b = new Book

$b->title = "為你自己學Laravel"
$b->description = "很厲害"
$b->price = 100

// 儲存資料
$b->save();

$b
// App\Models\Book {#4467
// title: "為你自己學Laravel",
// description: "很厲害",
// price: 100,
// updated_at: "2021-10-31 14:05:33",
// created_at: "2021-10-31 14:05:33",
// id: 1,
// }
```

```
$data = ["title"=>"為你自己學Python", "description"=>"也很棒", "price"=>200]

Book::create($data)
// Illuminate\Database\Eloquent\MassAssignmentException with message 'Add [title] to fillable property to allow mass assignment on [App\Models\Book].'

// 若使用整筆陣列大量輸入進Model，Laravel會自動擋下阻止，避免可能有惡意操作的發生。
```

// 解決方法：
到 Model 為 Book 的檔案中，使用 protected $fillable 開放寫入權限欄位範圍
![](https://i.imgur.com/SziD7AX.png)

- 修改資料

```
$b1 = Book::first()
$b1->available = true
$b1->save()
// 修改資料也可以寫成
$b2 = Book::find(2)
$b2->update(['available'=>true])

// 查詢符合條件的資料並更新資料
Book::where('available',true)->update(['available'=>false])
```

- 刪除資料

```
$data = ["title"=>"為你自己學Git", "price"=>50, "description"=>"很好用"]
Book::create($data)
Book::count()  // 得到共三筆資料
$b3 = Book::find(3)  // 先找到要刪除的那筆資料
$b3->delete()
// 刪除資料也可以直接使用destroy()
Book::destroy(4)
```

```
// soft delete
// 1. 新增 deleted_at 欄位
php artisan make:migration add_deleted_at_to_books

// 2. 如下圖，到migration執行softDeletes()及dropSoftDeletes()
$table->softDeletes();
$table->dropSoftDeletes();

// 3. 進行 migrate
php artisan migrate

// 4. 到 Model 加入 use SoftDeletes;

// 5. 再到 php srtisan tinker，找到想刪除的資料
$b1 = Book::first()

// 6. 刪除
$b1->delete()

// 7. 刪除後資料仍然會存在，只是deleted_at這個欄位有刪除當下的時間，而不再是null了(可以保存刪除的資料，不是真的被刪掉)

```

![](https://i.imgur.com/iz44f1O.png)

![](https://i.imgur.com/lZBH5mV.png)

```
Book::count()
// 2
```

![](https://i.imgur.com/gJCiuai.png)

```
// 尋找被刪除的id=1的資料
Book::withTrashed()->find(1)
```

#### Model 關聯性

- 一對一
  > 假設一家書店只賣一本書 ->hasOne

```
// 1. 建立Model與Migration
php artisan make:model Store --migration

// 2. 再到migration裡新增欄位
$table->string('title');  // 新增書店名欄位
php artisan migrate

// 3. 利用Model，去告訴Store會對應到一個Book(一家書店會有一本書)
// 進到app/Models/Store.php
class Store extends Model
{
    use HasFactory;

    public function book()
    {
        return $this->hasOne('App\Models\Book');
    }

    protected $fillable = ['title'];
}

// 4. 輸入Store欄位內容：店名title
php artisan tinker
$s1 = Store::create(['title'=>'一元商店'])

// 5. Book新增欄位store_id，對應Store
// 新增migration
php artisan make:migration add_store_id_to_books
// 新增欄位
$table->integer('store_id')->nullable()
php artisan migrate

// 6. 儲存一對一關係
php artisan tinker
$s1 = Store::first()
$b1 = Book::first()
$s1->book()->save($b1)

// 7. 從特定一間書店找到特定一本書的書名
$s = Store::first()
$s->book
$s->book->title

// 8. 建立反向關係，書對應到書店
$bx = Book::first()
// 進到app/Models/Book.php
class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'available'
    ];

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }
}

// 9. 找到特定一本書的書店的書店名稱
php artisan tinker
$by = Book::first()
$by->store
$by->store->title
```

> 例如：
> Store
> ->hasOne
> Book
> ->store_id

- 一對多
  > 假設一家書店有多本書 ->hasMany

```
// 1. 進到app/Models/Store.php設定Store->hasMany()->books
public function books()
    {
        return $this->hasMany('App\Models\Book');
    }

// 2. 從1號店找到多本書
php artisan tinker
$s1 = Store::first()
Book::create(['title'=>'為你自己學MySQL', 'description'=>'good', 'price'=>80])
$b6 = Book::find(6)
$s1->books()->save($b6)
$s1->books
```

- 多對多
  > 例如:
  > Book
  > ->hasMany authors
  > Author
  > ->hasMany books
  > table author_book
  > -book_id
  > -author_id
  > 多對多的關係需要開第三方表格
  > ![](https://i.imgur.com/7e4LtRu.png)

```
// 1. 建立Migration，作者Author
php artisan make:model Author --migration

// 2. 到migration建立欄位name
$table->string('name');

// 3. 再到app/Models/Author.php，作者擁有很多書
protected $fillable = ['name'];
public function books()
    {
        return $this->belongsToMany('App\Models\Book');
    }

// 4. 再到app/Models/Book.php，書是被很多作者寫出來的
public function authors()
    {
        return $this->belongsToMany('App\Models\Author');
    }

// 5. 建立第三方表格
php artisan make:migration create_author_book

// 6. 新增第三方表格欄位
$table->integer('book_id')->nullable();
$table->integer('author_id')->nullable();
php artisan migrate

// 7. 製作第三方表格關聯
php artisan tinker
$b1 = Book::first()
$b6 = Book::find(6)
$a1 = Author::create(['name'=>'王小明'])
$b1->authors()->save($a1)
$b6->authors()->save($a1)
$a1->books()->save($b6)
// 找到一號作者有哪些書
$a = Author::first()
$a->books
// 使用迴圈把同一坐著的書名印出來
foreach($a->books as book){
    echo $book->title . "<br>";
}
```

#### 檢查路由

```
php artisan route:list
```

#### Http 動詞

- get: 取得
- post: 新增
- put: 修改
- patch: 修改
- delete: 刪除
- any: 任何
- match: 符合

```
// 待修正
Route::match(["get","post"], uri: "/about", function(){})
```

```
Route::get('/', function () {
    return view('welcome');
});
```

```
Route::get('/cats/{id}/{name}', function ($id, $name) {
    return "我是第" . $id . "號的貓:" . $name;
});
```

#### 透過 Route 到某個 Controller(WelcomeController)執行某個函式(about)

```
Route::get('/about', 'WelcomeController@about');
```

- BaseController 繼承給 Controller 再繼承給我們新建立的 WelcomeController

```
Route::get('/user', [UserController::class, 'index']);
```

```
Route::get('/about', [\App\Http\Controllers\WelcomeController::class, 'about']);
```

```
// 本路由取名為posts，使用PostsController這個controller。
Route::resource('posts', \App\Http\Controllers\PostsController::class)->only(['index', 'show']);

Route::resource('posts', \App\Http\Controllers\PostsController::class)->except(['index', 'show']);

Route::resource('posts.comments', \App\Http\Controllers\PostsController::class)->shallow();
// 路徑：/posts/2/comments/3 -> 第2篇文章的第3則評論
```

#### 透過 Controller 帶變數及其值給 View

```
WelcomeController.php
class WelcomeController extends Controller
{
    public function about()
    {
        $name = 'Christina';
        return view('pages/about', ['name' => $name]);
    }
}
```

```
about.blade.php
<!-- 自class WelcomeController 的方法 about -->
{{ $name }}

// 輸出：Christina
```

## Routing

- 於 routes 資料夾 -> 處理路由
  > The routes/web.php file defines routes that are for your web interface. These routes are assigned the web middleware group, which provides features like session state and CSRF protection. The routes in routes/api.php are stateless and are assigned the api middleware group.

routes/web.php 處理 web 介面中間件之路由，而 routes/api.php 則處理和 api 相關的中間件。

### 資料與工廠模式

#### 建立 Factory

```
// 1. 建立Book工廠
php artisan make:factory BookFactory --model=Book

// 2. 再到database/factories/BookFactory.php的function definition()建立假資料
public function definition()
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->text,
            'price' => $this->faker->numberBetween(10, 300)
        ];
    }

// 3. Book這個Model利用factory建立假資料
php artisan tinker
Book::factory()->make()
// 製作三筆假資料
Book::factory()->count(3)->make()
// 製作假資料並存入資料庫
Book::factory()->create()
// 製作title欄位以外的假資料，而title自訂
Book::factory()->make(['title'=>'為你自己學PHP'])

// 4. 建立Store工廠
php artisan make:factory StoreFactory --model=Store

// 5. 再到database/factories/StoreFactory.php的function definition()建立假資料
public function definition()
    {
        return [
            'title' => $this->faker->name
        ];
    }

// 6. Store這個Model利用factory建立假資料
php artisan tinker
Store::factory()->make()
// 新增一家書店，加上他有三本書(建立一對多的假資料)
Store::factory()->has(Book::factory()->count(3))->create()
Store::factory()->hasBooks(3)->create()
// 新增一本書，並對應到一家書店(有一本書，是屬於某家書店)
Book::factory()->for(Store::factory())->create(['title'=>'為你自己學Java'])
Book::factory()->forStore()->create(['title'=>'為你自己學Javascript'])
```

#### seed data 種子資料或初始數據

```
// 預設seeder
php artisan db:seed
// 預設跟store有關seeder
php artisan make:seeder StoreSeeder

// database/seeders/StoreSeeder.php 利用工廠模式製作種子資料
public function run()
    {
        Store::factory()->count(3)->create();
    }

// 開始建立Store種子資料
php artisan db:seed --class=StoreSeeder
```
