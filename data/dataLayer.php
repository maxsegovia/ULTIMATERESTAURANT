<?php
    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                      Function: connectionDB                                  //
    //                      Description: Opens a connection with DB.                //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
    function connectionDB()
    {
        $servername = "localhost";
        $username = "root";
        $password = "12345";
        $dbname = "restaurante";

        //Stablish the connection with DB.
        $connection = new mysqli($servername, $username, $password, $dbname);

        //If connection was not successfull, return no connection, meaning there was an error.
        if($connection -> connect_error)
        {
            return null;
        }
        else
        {
            return $connection;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                      Function: Login                                         //
    //                      Description: Attempts login in App.                     //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
    function login($username, $password)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish query
            $sql = "SELECT Nombre, Valor_Acceso
                    FROM empleados 
                    WHERE Id_Empleado = '$username' AND Contrasena = '$password'";

            //Execute query
            $result = $connection-> query($sql);

            //If query returns an element
            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    //Build a response
                    $response = array("status" => "success", "Nombre" => $row["Nombre"], "Valor_Acceso" => $row["Valor_Acceso"]);
                    
                }
                $connection -> close();
                return $response;
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        else
        {
            return $response = array("status" => "500");
        }
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                  Function: tablesTaken                                       //
    //                  Description: Reads all the tables that are taken,           //
    //                  according to DB.                                            //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function tablesTaken()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish query
            $sql = "SELECT No_Mesa, Nombre, Cantidad_Gente, id_empleado 
                    FROM mesa 
                    WHERE Ocupada = 1";
            
            //Execute query
            $result = $connection-> query($sql);

            //If query returns an element
            if($result -> num_rows > 0)
            {
                //Then for each row
                while($row = $result -> fetch_assoc())
                {
                    //Build a response
                    $response[] = array("status" => "success",
                                        "No_Mesa" => $row["No_Mesa"],
                                        "Nombre" => $row["Nombre"],
                                        "Cantidad_Gente" => $row["Cantidad_Gente"],
                                        "id_empleado" => $row["id_empleado"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                 Function: tablesAvailable                                    //
    //                 Description: Reads all the tables that are available,        //
    //                 according to DB.                                             //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function tablesAvailable()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish query
            $sql = "SELECT No_Mesa 
                    FROM mesa 
                    WHERE Ocupada = 0";
            
            //Execute query
            $result = $connection-> query($sql);

            //If query returns an element
            if($result -> num_rows > 0)
            {
                //Then for each row
                while($row = $result -> fetch_assoc())
                {
                    //Build a response
                    $response[] = array("status" => "success", "No_Mesa" => $row["No_Mesa"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                 Function: updateTable                                        //
    //                 Description: Fills the table with client, and waiter info.   //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function updateTable($idTable, $people, $tableName, $idWaiter)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish and Execute query.
            mysqli_query($connection , "UPDATE mesa SET Ocupada = 1, id_empleado = '$idWaiter', Cantidad_Gente = '$people', Nombre = '$tableName' WHERE No_Mesa = '$idTable' AND Ocupada != 1");

            //If query returns an element
            if(mysqli_affected_rows($connection) > 0)
            {   
                //For every table filled, there has to be a bill account, and food orders.
                mysqli_query($connection , "INSERT INTO cuenta(Fecha, Monto, No_Mesa) VALUES (CURDATE(), 0, '".$idTable."');");
                if(mysqli_affected_rows($connection) > 0)
                {
                    mysqli_query($connection , "INSERT INTO mesa_orden (No_Mesa, Id_Cuenta) VALUES ('".$idTable."', (SELECT Id_Cuenta FROM cuenta ORDER BY Id_Cuenta DESC LIMIT 1));");
                    if(mysqli_affected_rows($connection) > 0)
                    {
                        //Build a response
                        $response[] = array("status" => "success",
                                            "Message" => "Table was successfully added.");
                        
                        //Then return the response
                        $connection -> close();
                        echo json_encode($response);
                    }
                    else
                    {
                        $connection -> close();
                        return $response = array("status" => "406");
                    }
                }
                else
                {
                    $connection -> close();
                    return $response = array("status" => "406");
                }
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //                 Function: pendingOrders                                      //
    //                 Description: Read all the pending Orders according to DB.    //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function pendingOrders()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish query.
            $sql = "SELECT P.Nombre, P.imgSrc, L.No_Mesa, O.Id_Orden FROM lista_orden L, platillo P, orden O WHERE P.Id_platillo = L.Id_Platillo AND L.Id_Orden = O.Id_Orden AND O.Completada = 0";
        
            //Execute query
            $result = $connection-> query($sql);

            //If query returns an element
            if($result -> num_rows > 0)
            {
                //Then for each row
                while($row = $result -> fetch_assoc())
                {
                    //Build a response
                    $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"], 
                                        "idOrden" => $row["Id_Orden"], 
                                        "No_Mesa" => $row["No_Mesa"],
                                        "imgSrc" => $row["imgSrc"]);
                }
                //Then return the response
                $connection -> close();
                echo json_encode($response);
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: deleteOrder                                              //
    //           Description: When an order is completed, we delete it from DB.     //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function deleteOrder($idOrden)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            //Stablish & Execute query
            mysqli_query($connection, "UPDATE orden SET Completada = 1 WHERE Id_Orden = '$idOrden';");
            
            //If query returns an element
            if(mysqli_affected_rows($connection) > 0)
            {
                //Build a response
                $response = array("Message" => "Order was successfully done.");

                $connection -> close();
                //Then return the response
                echo json_encode($response);
            }
            
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: tableOrders                                              //
    //           Description: Show orders of each table.                            //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function tableOrders()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            if(isset($_COOKIE["orderTableId"]))
            {
                //Stablish query
                $sql = "SELECT P.Nombre, P.imgSrc, L.No_Mesa, O.Id_Orden FROM lista_orden L, platillo P, orden O WHERE P.Id_platillo = L.Id_Platillo AND L.Id_Orden = O.Id_Orden AND O.Completada = 0 AND L.No_Mesa = '".$_COOKIE['orderTableId']."'";

                //Execute query
                $result = $connection-> query($sql);

                //If query returns an element
                if($result -> num_rows > 0)
                {
                    while($row = $result -> fetch_assoc())
                    {
                        //Build a response
                        $response[] = array("status" => "success",
                                            "Nombre" => $row["Nombre"],
                                            "orderId" => $row["Id_Orden"],
                                            "imgSrc" => $row["imgSrc"]);
                    }

                    $connection -> close();
                    echo json_encode($response);
                }

                else
                {
                    $connection -> close();
                    return $response = array("status" => "404");
                }
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: addOrder                                                 //
    //           Description: Add respective order to certain table.                //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function addOrder($plate)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            if(isset($_COOKIE["orderTableId"]))
            {   $sql = "SELECT * FROM platillo WHERE Nombre = '$plate'";
             
                $result = $connection-> query($sql);
                
                if($result -> num_rows > 0)
                {
                    //Stablish & Execute query
                    mysqli_query($connection, "INSERT INTO orden(Completada) VALUES (0)");

                    //If query returns an element
                    if(mysqli_affected_rows($connection) > 0)
                    {
                        mysqli_query($connection, "INSERT INTO mesa_orden(Id_Orden, No_Mesa, Id_Cuenta) VALUES ((SELECT Id_Orden FROM orden ORDER BY Id_Orden DESC LIMIT 1) , '".$_COOKIE["orderTableId"]."', (SELECT Id_Cuenta FROM cuenta WHERE No_Mesa = '".$_COOKIE["orderTableId"]."' ORDER BY Id_Cuenta DESC LIMIT 1));");
                        mysqli_query($connection, "INSERT INTO lista_orden(Id_Platillo, Id_Bebida, Id_Orden, No_Mesa) VALUES ((SELECT Id_Platillo FROM platillo WHERE Nombre ='$plate' ),'', (SELECT Id_Orden FROM orden ORDER BY Id_Orden DESC LIMIT 1), '".$_COOKIE["orderTableId"]."' );");
                        mysqli_query($connection, "UPDATE cuenta SET Monto = Monto + (SELECT Precio FROM platillo WHERE Nombre ='".$plate."') WHERE Id_Cuenta = (SELECT Id_Cuenta FROM mesa_orden WHERE No_Mesa = '".$_COOKIE["orderTableId"]."' AND Id_Orden = (SELECT Id_Orden FROM mesa_orden WHERE No_Mesa = '".$_COOKIE["orderTableId"]."' ORDER BY Id_Orden DESC LIMIT 1))");

                        //Build a response
                        $response[] = array("status" => "success",
                                            "orderTableId" => $_COOKIE["orderTableId"],
                                            "plate" => $plate);

                        $connection -> close();
                        echo json_encode($response);
                    }

                    else
                    {
                        $connection -> close();
                        return $response = array("status" => "406");
                    }
                }
                else
                {
                    $connection -> close();
                    return $response = array("status" => "404");
                }
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: plates                                                   //
    //           Description: Reads all plates available in DB.                     //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function plates()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            if(isset($_COOKIE["orderTableId"]))
            {   
                $sql = "SELECT Nombre FROM platillo";
             
                $result = $connection-> query($sql);
                
                if($result -> num_rows > 0)
                {
                    while($row = $result -> fetch_assoc())
                    {
                        $response[] = array("status" => "success",
                                            "Nombre" => $row["Nombre"]);
                    }
                    $connection -> close();
                    echo json_encode($response);
                }
                else
                {
                    $connection -> close();
                    return $response = array("status" => "404");
                }
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: searchResults                                            //
    //           Description: Reads result from query.                              //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function searchResults($searchValue)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {  
            $sql = "SELECT Nombre, Cantidad FROM productos_restaurante WHERE Nombre = '$searchValue'";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    if($row["Cantidad"] > 0)
                    {
                        $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"],
                                        "Cantidad" => $row["Cantidad"]);
                    }
                    else
                    {
                        $response[] = array("status" => "success",
                                        "Nombre" => $row["Cantidad"],
                                        "Cantidad" => "No hay suficiente stock.");
                    }
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: products                                                 //
    //           Description: Reads all products available in DB.                   //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function products()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre FROM productos_restaurante";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: productss                                                //
    //           Description: Reads all products available in DB.                   //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function productss()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre FROM productos";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: addStock                                                 //
    //           Description: Add Stock to certain product.                         //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function addStock($productName, $quantity)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            mysqli_query($connection, "UPDATE productos 
                                    SET Cantidad = Cantidad - '$quantity' 
                                    WHERE Nombre = '$productName' AND Cantidad > '$quantity'");
            
            //If query returns an element
            if(mysqli_affected_rows($connection) > 0)
            {
                mysqli_query($connection, "UPDATE productos_restaurante SET Cantidad = Cantidad + '$quantity' WHERE Nombre = '$productName'");
                
                $response[] = array("status" => "success");
                
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: productsAvailable                                        //
    //           Description: Reads all products available in DB.                   //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function productsAvailable()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre, Cantidad FROM productos_restaurante WHERE Cantidad > 0";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"],
                                        "Cantidad" => $row["Cantidad"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: productssAvailable                                       //
    //           Description: Reads all products available in DB.                   //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function productssAvailable()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre, Cantidad FROM productos WHERE Cantidad > 0";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"],
                                        "Cantidad" => $row["Cantidad"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: getCheck                                                 //
    //           Description: Reads all plates from table in DB.                    //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function getCheck($idTable, $payment)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {   
            mysqli_query($connection, "UPDATE cuenta SET Forma_Pa = '$payment' WHERE No_Mesa = '$idTable'");
            
            //If query returns an element
            if(mysqli_affected_rows($connection) > 0)
            {
                $sql = "SELECT Monto, Fecha, Forma_Pa, Id_Cuenta FROM cuenta WHERE No_Mesa = '$idTable'";
                
                $result1 = $connection-> query($sql);

                if($result1 -> num_rows > 0)
                {
                    while($row1 = $result1 -> fetch_assoc())
                    {
                        
                        $response[] = array("status" => "success", 
                                                    "monto" => $row1["Monto"], 
                                                    "fecha" => $row1["Fecha"],
                                                    "formaPago" => $row1["Forma_Pa"],
                                                    "idCuenta" => $row1["Id_Cuenta"]);
                        
                        $sql = "SELECT P.Nombre, P.Precio FROM platillo P, lista_orden L WHERE P.Id_Platillo = L.Id_Platillo AND L.No_Mesa = '$idTable'";
                        
                        $result2 = $connection-> query($sql);
                        
                        if($result2 -> num_rows > 0)
                        {
                            
                            while($row2 = $result2 -> fetch_assoc())
                            {
                                $response["articles"]["nombre"][] = $row2["Nombre"];
                                $response["articles"]["precio"][] =$row2["Precio"];
                                
                            }
                            $connection -> close();
                            echo json_encode($response);
                        }
                        else
                        {
                            $connection -> close();
                            return $response = array("status" => "406");
                        }
                    }
                }
                else
                {
                    $connection -> close();
                    return $response = array("status" => "406");
                }
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "406");
            }
        }
        
        else
        {
            $connection -> close();
            return $response = array("status" => "500");
        }
        
    }


    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: payCheck                                                 //
    //           Description: Pays check                                            //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function payCheck()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            if(isset($_COOKIE["orderTableId"]) && isset($_COOKIE["idCuenta"]))
            {
                mysqli_query($connection, "DELETE FROM cuenta WHERE Id_Cuenta = '".$_COOKIE["idCuenta"]."';");
                mysqli_query($connection, "UPDATE mesa SET Ocupada = 0 WHERE No_Mesa = (SELECT No_Mesa FROM mesa_orden WHERE Id_Cuenta = '".$_COOKIE["idCuenta"]."');");
                mysqli_query($connection, "DELETE FROM lista_orden WHERE No_Mesa = '".$_COOKIE["orderTableId"]."';");
                mysqli_query($connection, "DELETE FROM mesa_orden WHERE No_Mesa = '".$_COOKIE["orderTableId"]."';");

                $result = $connection-> query($sql);

                if($result -> num_rows > 0)
                {
                    while($row = $result -> fetch_assoc())
                    {
                        $response[] = array("status" => "success");
                    }
                    $connection -> close();
                    echo json_encode($response);
                }
                else
                {
                    $connection -> close();
                    return $response = array("status" => "404");
                }
            }
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: outOfStockSoon                                           //
    //           Description: Checks products that are about to be out of stock.    //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function outOfStockSoon()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre, Cantidad FROM productos WHERE  Cantidad < 50 AND Cantidad > 0";
            
            $result = $connection-> query($sql);
            
            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                       "nombre" => $row["Nombre"],
                                       "cantidad" => $row["Cantidad"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
            
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: expired                                                  //
    //           Description: Checks expired products.                              //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function expired()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre, Fecha_Caducidad, Fecha_Ingreso FROM productos";
            
            $result = $connection-> query($sql);
            
            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $expiracyDate =  date('Y-m-d', strtotime($row["Fecha_Caducidad"]));
                    
                    if($expiracy_date < date('Y-m-d', strtotime('+7 days')))
                    {
                        if($expiracy_date <= date('Y-m-d'))
                        {
                            $nombre = $row["Nombre"];
                            $sql = "UPDATE productos SET Cantidad = 0 WHERE Nombre = '$nombre'";
                        }
                        else
                        {
                            $response[] = array("status" => "success",
                                       "nombre" => $row["Nombre"],
                                       "fechaIngreso" => $row["Fecha_Ingreso"],
                                       "fechaExpiracion" => $expiracyDate,);
                        }
                    }
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
            
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: outOfStock                                               //
    //           Description: Checks out of stock products.                         //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function outOfStock()
    {
        $connection = connectionDB();
        
        if($connection != null)
        {
            $sql = "SELECT Nombre, Cantidad FROM productos WHERE Cantidad <= 0";
            
            $result = $connection-> query($sql);
            
            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    $response[] = array("status" => "success",
                                       "nombre" => $row["Nombre"],
                                       "cantidad" => $row["Cantidad"]);
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
            
        }
        
        else
        {
            return $response = array("status" => "500");
        }
        
    }

    //////////////////////////////////////////////////////////////////////////////////
    //                                                                              //          
    //           Function: searchResultsW                                           //
    //           Description: Reads result from query.                              //
    //                                                                              //
    //////////////////////////////////////////////////////////////////////////////////
	function searchResultsW($searchValue)
    {
        $connection = connectionDB();
        
        if($connection != null)
        {  
            $sql = "SELECT Nombre, Cantidad FROM productos WHERE Nombre = '$searchValue'";

            $result = $connection-> query($sql);

            if($result -> num_rows > 0)
            {
                while($row = $result -> fetch_assoc())
                {
                    if($row["Cantidad"] > 0)
                    {
                        $response[] = array("status" => "success",
                                        "Nombre" => $row["Nombre"],
                                        "Cantidad" => $row["Cantidad"]);
                    }
                    else
                    {
                        $response[] = array("status" => "success",
                                        "Nombre" => $row["Cantidad"],
                                        "Cantidad" => "No hay suficiente stock.");
                    }
                }
                $connection -> close();
                echo json_encode($response);
            }
            else
            {
                $connection -> close();
                return $response = array("status" => "404");
            }
        }
        else
        {
            return $response = array("status" => "500");
        }
        
    }
?>