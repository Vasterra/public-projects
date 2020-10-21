<?php

namespace App\Http\Controllers;

use App\Consist;
use App\CookProduct;
use App\Orders\OrderClass;
use App\Product;
use App\Products\Products;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public $date1;
    public $date2;
    public $date3;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->date1=date(DATE_ATOM, strtotime('monday last week +9 hour'));
        $this->date2=date(DATE_ATOM, strtotime('monday this week +9 hour'));
        $this->date3=date(DATE_ATOM, strtotime('monday next week +9 hour'));
        ini_set('max_execution_time', 180);
    }

    /**
     * Делаем запрос проверяет продукты и выводим актуальные продукты
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= new Products();
        $array1=$products->getAllProductsFirst();
        $array2=$products->getAllProductsNext(end($array1)->id);
        $i=0;
        $productsArray= array_merge($array1,$array2);
        foreach ($productsArray as $product)
        {
            $array1=array('id' => $product->id);
            $array2=array('name' => $product->title);
            Product::updateOrCreate($array1, $array2);
            $i++;
        }
        return view('products', ['products' => Products::getProductsList()]);
    }

    /**
     * @param $id
     * @param $idconsist
     * @return mixed
     */
    public function addConsists($id, $idconsist, $quantity)
    {
        return Consist::updateOrInsert(['id_product' => $id, 'id_consists' => $idconsist], ['quantity' => $quantity]);
    }

    /**
     * @param $id
     * @param $idconsist
     * @return mixed
     */
    public function deleteConsist($id, $idconsist)
    {
        return Consist::where('id_product', $id)->where('id_consists', $idconsist)->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Products::getProduct($id);
        return view("product", ["product" => $product[0], 'products' => Product::all()->sortBy("name")->toArray()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Product::where('id', $id)->update(['iscomplect' => 0]);
        return redirect('/products');
    }

    /**
     * Вывод продуктов для готовки
     * можно было обойтись и без промежуточной таблицы
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allProductsToCooking()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrders()->orders;
        $this->cookingList($CurrentOrder);
        $date="All Active Orders";
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'all']);
    }

    /**
     * то же самое  только другой временной отрезок
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allProductsToCookingCurrent()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date1, $this->date2)->orders;
        $this->cookingList($CurrentOrder);
        $date=date("d.m.Y", strtotime($this->date1))." - ".date("d.m.Y", strtotime($this->date2));
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'current']);
    }

    /**
     * то же самое  только другой временной отрезок
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allProductsToCookingNext()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date2, $this->date3)->orders;
        $this->cookingList($CurrentOrder);
        $date=date("d.m.Y", strtotime($this->date2))." - ".date("d.m.Y", strtotime($this->date3));
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'next']);
    }


    /**
     * сортируем список
     * @param $CurrentOrder
     */
    public function cookingList($CurrentOrder)
    {
        $productsArray=array();
        foreach($CurrentOrder as $Order) {
            foreach ($Order->line_items as $product) {
                array_push($productsArray, ['product_id' => $product->product_id, 'title' => $product->title, 'quantity' => $product->quantity]);
            }
        }

        foreach ($productsArray as $product)
        {
            $condition=1;

            $arrayConsist=Consist::where('id_product', $product['product_id'])->get()->toArray();

            foreach (CookProduct::all() as $sort)
            {
                if($sort->id_product==$product['product_id']) {
                    $condition=0;
                    $x=$sort->quantity+$product['quantity'];
                    CookProduct::where('id_product', $sort->id_product)->update(['quantity' => $x]);
                }
            }
            if ($condition>0) {
                CookProduct::insert(
                    ['id_product' => $product['product_id'], 'name' => $product['title'], 'quantity' => $product['quantity']]
                );
            }
        }

    }

    /**
     * то же самое с декомпозицией
     **/
    public function allProductsToCookingWithDecomposition()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrders()->orders;
        $this->cookingListWithDecomposition($CurrentOrder);
        $date="All Active Orders";
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'alldecomposition']);
    }

    /**
     * то же самое с декомпозицией
     **/
    public function allProductsToCookingCurrentWithDecomposition()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date1, $this->date2)->orders;
        $this->cookingListWithDecomposition($CurrentOrder);
        $date=date("d.m.Y", strtotime($this->date1))." - ".date("d.m.Y", strtotime($this->date2));
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'currentdecomposition']);
    }

    /**
     * то же самое с декомпозицией
     **/
    public function allProductsToCookingNextWithDecomposition()
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        $CurrentOrder=$order->getAllOpenOrdersByDate($this->date2, $this->date3)->orders;
        $this->cookingListWithDecomposition($CurrentOrder);
        $date=date("d.m.Y", strtotime($this->date2))." - ".date("d.m.Y", strtotime($this->date3));
        return view("cook", ['Orders' => CookProduct::all()->toArray(), 'DateOrder' => $date, 'list' => 'nextdecomposition']);
    }

    /**
     * Сортировка с декомпозицией
     * @param $CurrentOrder
     */
    public function cookingListWithDecomposition($CurrentOrder)
    {
        $productsArray=array();
        foreach($CurrentOrder as $Order) {
            foreach ($Order->line_items as $product) {
                array_push($productsArray, ['product_id' => $product->product_id, 'title' => $product->title, 'quantity' => $product->quantity]);
            }
        }

        foreach ($productsArray as $product)
        {
            $condition=1;
            $arrayConsist=Consist::where('id_product', $product['product_id'])->get()->toArray();
            if ($arrayConsist) {
                foreach ($arrayConsist as $consist)
                {
                    $x=$product['quantity']*$consist["quantity"];
                    $arrayCook=CookProduct::where('id_product',$consist["id_consists"])->get()->toArray();
                    if($arrayCook) {
                        $x+=$arrayCook[0]["quantity"];
                        CookProduct::where('id_product',$consist["id_consists"])->update(['quantity' => $x]);
                    }
                    else {
                        $prod=Product::where('id', $consist["id_consists"])->get()->toArray()[0];
                        CookProduct::insert(['id_product' => $consist["id_consists"], 'name' => $prod['name'], 'quantity' => $x]);
                    }
                }
                $condition=0;
                continue;
            }


            foreach (CookProduct::all() as $sort)
            {
                if($sort->id_product==$product['product_id']) {
                    $condition=0;
                    $x=$sort->quantity+$product['quantity'];
                    CookProduct::where('id_product', $sort->id_product)->update(['quantity' => $x]);
                }
            }
            if ($condition>0) {
                CookProduct::insert(
                    ['id_product' => $product['product_id'], 'name' => $product['title'], 'quantity' => $product['quantity']]
                );
            }
        }

    }

    /**
     * pdf creator
     * @param $list
     * @return mixed
     */
    public function pdfList($list)
    {
        CookProduct::where('id', '>', 0)->delete();
        $order=new OrderClass();
        switch ($list)
        {
            case "all":
                $CurrentOrder=$order->getAllOpenOrders()->orders;
                $this->cookingList($CurrentOrder);
                $date="All Active Orders";
                break;
            case "current":
                $CurrentOrder=$order->getAllOpenOrdersByDate($this->date1, $this->date2)->orders;
                $this->cookingList($CurrentOrder);
                $date=date("d.m.Y", strtotime($this->date1))." - ".date("d.m.Y", strtotime($this->date2));
                break;
            case "next":
                $CurrentOrder=$order->getAllOpenOrdersByDate($this->date2, $this->date3)->orders;
                $this->cookingList($CurrentOrder);
                $date=date("d.m.Y", strtotime($this->date2))." - ".date("d.m.Y", strtotime($this->date3));
                break;
            case "alldecomposition":
                $CurrentOrder=$order->getAllOpenOrders()->orders;
                $this->cookingListWithDecomposition($CurrentOrder);
                $date="All Active Orders";
                break;
            case "currentdecomposition":
                $CurrentOrder=$order->getAllOpenOrdersByDate($this->date1, $this->date2)->orders;
                $this->cookingListWithDecomposition($CurrentOrder);
                $date=date("d.m.Y", strtotime($this->date1))." - ".date("d.m.Y", strtotime($this->date2));
                break;
            case "nextdecomposition":
                $CurrentOrder=$order->getAllOpenOrdersByDate($this->date2, $this->date3)->orders;
                $this->cookingListWithDecomposition($CurrentOrder);
                $date=date("d.m.Y", strtotime($this->date2))." - ".date("d.m.Y", strtotime($this->date3));
                break;
        }
        $data = [
            'data' => CookProduct::all()->toArray(),
            'DateOrder' => $date,
        ];

        $pdf = PDF::loadView('pdflistcook', $data);
        return $pdf->download("list.pdf");
    }

}
