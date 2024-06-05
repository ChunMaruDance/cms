<?php
namespace controllers;

use core\Controller;
use core\Template;
use core\Core;

//models
use models\Accessory;
use models\AccessoryCategories;
use models\Categories;
use models\Orders;
use models\OrderItems;

//validators
use utils\OrderValidator;

class ProductsController extends Controller{

    public function actionAccessory($params){

        $id = $params[0];
        $accessory = Accessory::findById($id);
        $accessory->category = AccessoryCategories::getCategoryByAccessoryId($id);
        $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   

        return $this->render(null,['accessory'=>$accessory]);
    }

    public function actionIndex($params){
       return $this->render();
    }

    public function actionAddToBasket($params){

        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['accessory_id'])) {
          
            $accessoryId = $data['accessory_id'];
           
            $session = Core::get()->session;
            $basket = $session->get('basket', []);

            if (!isset($basket[$accessoryId])) {
                $basket[$accessoryId] = 1;
            } else {
                $basket[$accessoryId]++;
            }

            $session->set('basket', $basket);
            echo json_encode(["accessories" => $basket, "cartItemCount" => array_sum($basket)]);
        } else {
            echo json_encode(["error" => "No search query provided"]);
        }
        exit;

    }

    public function actionRemoveFromBasket(){
        $data = json_decode(file_get_contents('php://input'), true);
    
        if (isset($data['accessory_id'])) {
          
            $accessoryId = $data['accessory_id'];
           
            $session = Core::get()->session;
            $basket = $session->get('basket', []);
    
            if (isset($basket[$accessoryId])) {
                if ($basket[$accessoryId] > 0) {
                    $basket[$accessoryId]--;
                }
                if ($basket[$accessoryId] == 0) {
                    unset($basket[$accessoryId]);
                }
            }
    
            $session->set('basket', $basket);
            echo json_encode(["accessories" => $basket, "cartItemCount" => array_sum($basket)]);
        } else {
            echo json_encode(["error" => "No accessory id provided"]);
        }
        exit;
    }

    public function actionView($params){

        if(empty($params)){
            return $this->redirect('/');
        }

        $cateogry = $params[0];
        $categoryObj = Categories::findIdByTitle($cateogry);
        
        if($categoryObj == null){
            return $this->redirect('/');
        }
       
        $accessories = AccessoryCategories::getAccessoriesByCategoryId($categoryObj[0]->id);
        foreach ($accessories as $accessory) {
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);   
         }
      
        return $this->render(null,['accessories'=> $accessories,'category'=>$cateogry,'description'=>$categoryObj[0]->description]);
    }
    public function actionSearchAccessory() {
        
        $data = json_decode(file_get_contents('php://input'), true);
        $searchQuery = $data['search_query'] ?? null;
        $category = $data['category'];
        $minPrice = $data['priceMin'] ?? null; 
        $maxPrice = $data['priceMax'] ?? null; 
        $accessories = AccessoryCategories::searchByCategoryAndTitle($category, $searchQuery, $minPrice, $maxPrice);
    
        foreach ($accessories as $accessory) {
            $accessory->image = 'data:image/png;base64,' . base64_encode($accessory->image);
        }
    
        echo json_encode(["accessories" => $accessories]);
        exit;
    }


    public function actionOrder($params){
        
        $basket = Core::get()->session->get('basket', []);
        $accessoriesAndCount =  [];
        $session = Core::get()->session;


        if(!empty($params)){
            $accessoryId = $params[0];
            $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
            if ($accessory) {
                
               
                $basket = $session->get('basket', []);
    
                if (!isset($basket[$accessoryId])) {
                    $basket[$accessoryId] = 1;
                    $session->set('basket', $basket);
                } 
                $session->set('orderOnly', $accessoryId);

                $accessoriesAndCount[] = [
                    'accessory' => $accessory,
                    'count' => $basket[$accessoryId],
                ];
               

            }
        } else {

            if(!empty($basket)){
                foreach ($basket as $accessoryId => $count) {

                    $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
                    if ($accessory) {
                        $accessoriesAndCount[] = [
                            'accessory' => $accessory,
                            'count' => $count
                        ];
                    }
                    
                    if ($session->get('orderOnly')) {
                        $session->remove('orderOnly');
                    }

    
                } 
            } 

          
        }
      
        return $this->render(null,['accesories'=> $accessoriesAndCount]);
    }

    public function actionOrdersView()
    {    
        $this->checkIsUserLoggin();

        $orders = Orders::getAll();
        $ordersWithItems = [];
    
        foreach ($orders as $order) {

            if(!$order->canceled){
                $orderItems = OrderItems::findByOrderId($order->id);
                $itemsWithAccessories = [];
        
                foreach ($orderItems as $orderItem) {
                    $accessoryId = $orderItem->accessory_id;
                    $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
                    if ($accessory) {
                        $itemsWithAccessories[] = [
                            'orderItem' => $orderItem,
                            'accessory' => $accessory
                        ];
                    }
                }
        
                $ordersWithItems[] = [
                    'order' => $order,
                    'items' => $itemsWithAccessories
                ];      
            }else{
                $ordersWithItems[] = [
                    'order' => $order,
                    'items' => []
                ];    
            }
          
        }
    
        return $this->render(null, [
            'ordersWithItems' => $ordersWithItems
        ]);
    }


    public function actionUpdateOrderStatus(){
        if($this->isPost){
            $data = json_decode(file_get_contents('php://input'), true);
            
            $order_id = $data['order_id'];
            $order_status = $data['status'];
    
            $orderStd = Orders::findById($order_id);
            
            if($orderStd){
                $order = new Orders();
                foreach ($orderStd as $key => $value) {
                    $order->$key = $value;
                }           
                //update
                $order->finished = $order_status;
                $order->update();
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false]);
        }
        exit;
        
    }

    public function actionSearchOrders(){

        $data = json_decode(file_get_contents('php://input'), true);
        $searchQuery = $data['search_query'];
     
        $orders = Orders::searchByOrderNumber($searchQuery);
        $ordersWithItems = [];

        foreach ($orders as $order) {
            $orderItems = OrderItems::findByOrderId($order->id);
            $itemsWithAccessories = [];
    
            foreach ($orderItems as $orderItem) {
                $accessoryId = $orderItem->accessory_id;
                $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
                if ($accessory) {
                    $itemsWithAccessories[] = [
                        'orderItem' => $orderItem,
                        'accessory' => $accessory
                    ];
                }
            }

        }
        $ordersWithItems[] = [
            'order' => $order,
            'items' => $itemsWithAccessories
        ];

        echo json_encode(["orders" => $ordersWithItems]);
        exit;
    }

    public function actionOrderConfirm()
    {
        $session =  Core::get()->session;
        if($this->isPost){
   
            $email = $this->post->email;
            $name = $this->post->name;
            $phone = $this->post->phone;
            $payment_method = $this->post->payment_method;
            $post_office = $this->post->post_office;

            $orderNumber = $session->get('orderNumber');
            $totalAmount = $session->get('totalAmount');

           
            $errors = OrderValidator::validate($email,$name,$phone,$payment_method,$post_office);
            if(!empty($errors)){
                $this->setErrorMessage(implode('<br>', $errors));
            
            }else{
                
                $order = new Orders();
             
                $order->order_number = $orderNumber;
                $order->user_email = $email;
                $order->user_name = $name;
                $order->user_phone = $phone;
                $order->payment_method = $payment_method;
                $order->post_office = $post_office;
                $order->total_amount = $totalAmount;
                $order->created_at = date('Y-m-d H:i:s');
                $order->save();
             
               
                if ($orderOnlyId) {
                    $items = [$orderOnlyId => $session->get('basket', [])[$orderOnlyId]];
                    $session->remove('orderOnly');
                } else {
                    $items = $session->get('basket', []);
                }

                $orderId = Orders::getOrderIdByOrderNumber($order->order_number);
            
                foreach ($items as $accessoryId => $count) {
                    $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
                    if ($accessory) {
                        $orderItem = new OrderItems();
                        $orderItem->order_id = $orderId;
                        $orderItem->accessory_id = $accessory->id;
                        $orderItem->quantity = $count;
                        $orderItem->price = $accessory->price;
                        $orderItem->save();
                    }
                }
    
                $session->remove('orderNumber');
                $session->remove('totalAmount');
                $session->remove('basket');

                return $this->redirect('/');
            }

        }elseif($this->isGet){

            $orderNumber = uniqid('order_');
        
            $totalAmount = $this->calculateTotalAmount($session); 
            
            $session->set('orderNumber',$orderNumber);
            $session->set('totalAmount',$totalAmount);

        }

        return $this->render(null, [
            'orderNumber' => $orderNumber,
            'totalAmount' => $totalAmount
        ]);
       
       
    }

    private function calculateTotalAmount($session)
    {
        $basket = $session->get('basket', []);
        $totalAmount = 0; 
        $orderOnlyId = $session->get('orderOnly');

        if ($orderOnlyId) {
            $accessory = Accessory::findByIdWithEncodeImage($orderOnlyId);
            if ($accessory) {
                $totalAmount = $accessory->price * $basket[$orderOnlyId];
            }
        }else {
        
            foreach ($basket as $accessoryId => $count) {
            $accessory = Accessory::findByIdWithEncodeImage($accessoryId);
            if ($accessory)$totalAmount += $accessory->price * $count;  
            }

        }
         return $totalAmount;
    }


}

?>