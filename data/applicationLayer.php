<?php
	header('Accept: application/json');
	header('Content-type: application/json');
    
    require_once __DIR__ . '/dataLayer.php';

    $action = $_POST["action"];

    switch($action)
    {
        case "login":
            loginFunction();
            break;
        case "clearSession":
            clearSession();
            break;
        case "cookies":
            cookies();
            break;
        case "session":
            session();
            break;
        case "tablesTaken":
            tablesTakenFunction();
            break;
        case "tablesAvailable":
            tablesAvailableFunction();
            break;
        case "updateTable":
            updateTableFunction();
            break;
        case "pendingOrders":
            pendingOrdersFunction();
            break;
        case "deleteOrder":
            deleteOrderFunction();
            break;
        case "createCookieTableId":
            createCookieTableId();
            break;
        case "tableOrders":
            tableOrdersFunction();
            break;
        case "addOrder":
            addOrderFunction();
            break;
        case "checkTableId":
            checkTableId();
            break;
        case "plates":
            platesFunction();
            break;
        case "searchResults":
            searchResultsFunction();
            break;
        case "searchResultsW":
            searchResultsWFunction();
            break;
        case "products":
            productsFunction();
            break;
        case "productss":
            productssFunction();
            break;
        case "addStock":
            addStockFunction();
            break;
        case "productsAvailable":
            productsAvailableFunction();
            break;
        case "productssAvailable":
            productssAvailableFunction();
            break;
        case "getCheck":
            getCheckFunction();
            break;
        case "payCheck":
            payCheckFunction();
            break;
        case "outOfStockSoon":
            outOfStockSoonFunction();
            break;
        case "expired":
            expiredFunction();
            break;
        case "outOfStock":
            outOfStockFunction();
            break;
        case "sessionKitchen":
            sessionKitchen();
            break;
        case "sessionRestaurant":
            sessionRestaurant();
            break;
        case "sessionWarehouse":
            sessionWarehouse();
            break;
    }

    function loginFunction()
    {
        //Receives data from URL
        $username = $_POST["username"];  
        $password = $_POST["password"];
        
        $response = login($username, $password);
        
        if($response["status"] == "success")
        {
            //Start session
            startSession($response["Valor_Acceso"]);
            //Creates a cookie
            startCookie($username);
            //Return response to JS
            echo json_encode($response);
        }
        else
           errorHandling($response["status"]); 
    }

    function tablesTakenFunction()
    {
        $response = tablesTaken();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
           errorHandling($response["status"]);
    }

    function tablesAvailableFunction()
    {
        $response = tablesAvailable();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
           errorHandling($response["status"]);
    }

    function updateTableFunction()
    {
        //Receives data from URL
        $idTable = $_POST["idTable"];  
        $people = $_POST["people"];
        $tableName = $_POST["tableName"];
        
        //Data from cookie
        $idWaiter = $_COOKIE["username"];
        
        $response = updateTable($idTable, $people, $tableName, $idWaiter);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function pendingOrdersFunction()
    {
        $response = pendingOrders();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
           errorHandling($response["status"]); 
    }

    function deleteOrderFunction()
    {
        //Receives data from URL
        $idOrden = $_POST["idOrden"];
        
        $response = deleteOrder($idOrden);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
           errorHandling($response["status"]); 
    }

    function tableOrdersFunction()
    {
        $response = tableOrders();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function addOrderFunction()
    {
        $plate = $_POST["plate"];
        $response = addOrder($plate);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function platesFunction()
    {
        $response = plates();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function productsFunction()
    {
        $response = products();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function productssFunction()
    {
        $response = productss();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function searchResultsFunction()
    {
        $searchValue = $_POST["searchValue"];
        
        $response = searchResults($searchValue);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function searchResultsWFunction()
    {
        $searchValue = $_POST["searchValue"];
        
        $response = searchResultsW($searchValue);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function addStockFunction()
    {
        $productName = $_POST["productName"];
        $quantity = $_POST["quantity"];
        $response = addStock($productName, $quantity);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function productsAvailableFunction()
    {
        $response = productsAvailable();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function productssAvailableFunction()
    {
        $response = productssAvailable();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function getCheckFunction()
    {
        $idTable = $_POST["idTable"];
        $payment = $_POST["payment"];
        
        $response = getCheck($idTable, $payment);
        
        if($response["status"] == "success")
        {
            setcookie("idCuenta", $response["idCuenta"], time() + 3600, "/", "", 0);
            setcookie("orderTableId", $idTable, time() + 3600, "/", "", 0);
            echo json_encode($response);
        }
        else
            errorHandling($response["status"]);
    }

    function payCheckFunction()
    {
        $idTable = $_POST["idTable"];
        
        $response = payCheck($idTable);
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function outOfStockSoonFunction()
    {
        $response = outOfStockSoon();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function outOfStockFunction()
    {
        $response = outOfStock();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function expiredFunction()
    {
        $response = expired();
        
        if($response["status"] == "success")
            echo json_encode($response);
        else
            errorHandling($response["status"]);
    }

    function startSession($data)
    {
        //Guardar Sesion
        session_start();
        $_SESSION["Valor_Acceso"] = $data;
    }

    function startCookie($data)
    {
        $remember = $_POST["remember"];
        
        //Guardar Cookie
        if($remember == "true")
            setcookie("username", $data, time() + 3600, "/", "", 0);
    }

    function cookies()
    {
        if(isset($_COOKIE["username"]))
        {
            $response = array("username" => $_COOKIE["username"]);
            echo json_encode($response);
        }
        else
            errorHandling("500");
    }

    function session()
    {
        session_start();
        if(isset($_SESSION["Valor_Acceso"]))
        {
            $response = array("Valor_Acceso" => $_SESSION["Valor_Acceso"]);
            echo json_encode($response);
        }
        else
        {
            errorHandling("401");
            exit();
        }
    }

    function sessionKitchen()
    {
        session_start();
        if($_SESSION["Valor_Acceso"] == 3)
        {
            $response = array("Valor_Acceso" => $_SESSION["Valor_Acceso"]);
            echo json_encode($response);
        }
        else
        {
            errorHandling("401");
            exit();
        }
    }
    
    function sessionRestaurant()
    {
        session_start();
        if($_SESSION["Valor_Acceso"] == 1)
        {
            $response = array("Valor_Acceso" => $_SESSION["Valor_Acceso"]);
            echo json_encode($response);
        }
        else
        {
            errorHandling("401");
            exit();
        }
    }

    function sessionWarehouse()
    {
        session_start();
        if($_SESSION["Valor_Acceso"] == 2)
        {
            $response = array("Valor_Acceso" => $_SESSION["Valor_Acceso"]);
            echo json_encode($response);
        }
        else
        {
            errorHandling("401");
            exit();
        }
    }

    function createCookieTableId()
    {
        $TableId = $_POST["tableId"];
        
        setcookie("orderTableId", $TableId, time() + 3600, "/", "", 0);
    }

    function checkTableId()
    {
        if(isset($_COOKIE["orderTableId"]))
        {
            $response = array("tableId" => $_COOKIE["orderTableId"]);
            echo json_encode($response);
        }
        else
        {
            errorHandling("406");
        }
    }

    function clearSession()
    {
        session_start();
        if(isset($_SESSION["Valor_Acceso"]))
        {
            unset($_SESSION["Valor_Acceso"]);
            session_destroy();
            echo json_encode(array("Message" => "Your session has ended successfully."));
        }
        else
        {
            errorHandling("401");
        }
    }

    function errorHandling($errorStatus)
    {
        switch($errorStatus)
        {
            case "401":
                header('HTTP/1.1 401 Session not valid.');
                die("Your session is not valid. You will be redirected to index.");
                break;
            case "404":
                header('HTTP/1.1 404 Data was not found');
                die("Seems like there is nothing here.");
                break;
            case "406":
                header("HTTP/1.1 406 There was a problem");
                die("A problem with the Database has occured. Please contact your admin.");
                break;
            case "500":
                header("HTTP/1.1 500 Bad Connection to the Database:(");
                die("Unexpected error on the network. Try again later.");
                break;
        }
    }

?>