<?php

require '../app/Models/Product.php';
require '../app/Models/Category.php';
require '../app/Models/Manufacturer.php';

class ProductController extends Controller
{
    public function Create() {
        if(isset($_SESSION[APP_SESSION]) && $_SESSION[APP_SESSION]['role_id'] == 1) {
            $errors = [];
            $product = new Product();
            $category = new Category(); $categories = $category->Select()->Get();
            $manufacturer = new Manufacturer(); $manufacturers = $manufacturer->Select()->Get(); // print_r($manufacturers);
            if(isset($_POST['create'])) {
                if(empty($_POST['category'])) {
                    $errors[] = "Kategorie darf nicht leer sein";
                }

                if(empty($_POST['producer'])) {
                    $errors[] = "Hersteller darf nicht leer sein";
                }

                if(count($errors) == 0) {
                    $product->product_title = $_POST['title'];
                    $product->product_description = $_POST['description'];
                    $product->created_at = date("Y-m-d H:i:s");
                    $product->short_description = $_POST['short_description'];
                    $product->fk_category_id = $_POST['category'];
                    $product->fk_manufacturer_id = $_POST['producer'];
                    $product->fk_status_id = 2;
                    $product->quantity = $_POST['amount'];
                    $product->price = $_POST['price'];
                    $product->keywords = $_POST['keywords'];
                    $product->save();
                    Helper::Redirect("Home", "Index");
                }
            }
            $this->View(['title' => 'Produkt erstellen', 'categories' => $categories, 'manufacturers' => $manufacturers, 'errors' => $errors], 1);
        }
    }

    public function Search() {
        $product = new Product();
        // Sort filter
        // By Category
        // Price range
        if(isset($_GET['search'])) {
            $sort = ['ASC' => 'product_title'];
            if(isset($_GET['sort'])) {
                switch($_GET['sort']) {
                    case 'asc_title':
                        $sort = ['ASC' => 'product_title'];
                        break;
                    case 'desc_title':
                        $sort = ['DESC' => 'product_title'];
                        break;
                    case 'asc_price':
                        $sort = ['ASC' => 'price'];
                        break;
                    case 'desc_price':
                        $sort = ['DESC' => 'price'];
                        break;
                }
            }
            // $products = $product->Select()->OrderBy($sort)->Get();

            // if(!empty($_POST['sort'])) {
                $products = $product->Select()->WhereLike(['product_title' => $_GET['search']])->_OrLike(['keywords' => $_GET['search']])->OrderBy($sort)->Get();
                // $this->View(['title' => 'Suchen', 'products' => $products]);
            // }
        } else {
            $products = [];
        }
        $this->View(['title' => 'Suchen', 'products' => $products], 1);
    }

    public function Details($id = null) {
        $product =  new Product();
        print_r($product->Select()->Where(['product_id' => $id])->GetSingle());
    }
}