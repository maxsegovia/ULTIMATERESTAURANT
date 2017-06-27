-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2017 a las 13:11:12
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alertas`
--

CREATE TABLE `alertas` (
  `Id_Alerta` char(10) NOT NULL,
  `Producto_SinStock` bit(1) DEFAULT NULL,
  `Producto_ProximoCaducar` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `Id_Factura` char(10) DEFAULT NULL,
  `Id_Reporte` char(10) DEFAULT NULL,
  `Id_Alerta` char(10) DEFAULT NULL,
  `Id_Empleados` char(10) DEFAULT NULL,
  `Id_Producto` char(10) DEFAULT NULL,
  `Id_Peticiones` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bebidas`
--

CREATE TABLE `bebidas` (
  `Id_Bebida` char(10) NOT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Descripcion` text,
  `Ingredientes` text,
  `Precio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Id_Cliente` char(10) NOT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Correo` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuenta`
--

CREATE TABLE `cuenta` (
  `Id_Cuenta` int(11) NOT NULL,
  `Forma_Pa` char(30) DEFAULT NULL,
  `No_Mesa` int(11) DEFAULT NULL,
  `Monto` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cuenta`
--

INSERT INTO `cuenta` (`Id_Cuenta`, `Forma_Pa`, `No_Mesa`, `Monto`, `Fecha`) VALUES
(12, 'cash', 1, 250, '2016-11-22'),
(13, 'Efectivo', 3, 730, '2017-06-26'),
(14, 'Tarjeta', 5, 120, '2017-06-27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `Id_Empleado` char(10) NOT NULL,
  `Contrasena` char(64) DEFAULT NULL,
  `Nombre` char(50) DEFAULT NULL,
  `Correo` char(30) DEFAULT NULL,
  `Sueldo` int(11) DEFAULT NULL,
  `Puesto` char(30) DEFAULT NULL,
  `Area` char(30) DEFAULT NULL,
  `Valor_Acceso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`Id_Empleado`, `Contrasena`, `Nombre`, `Correo`, `Sueldo`, `Puesto`, `Area`, `Valor_Acceso`) VALUES
('A01011021', 'contrasena', 'Edgar Garcia', 'edgargarcia7@gmail.com', 1300, 'Chef', 'Cocina', 3),
('A01021817', '*2F063613C670A8FBD8353CCC26D8E47BC954A159', 'Maximiliano Segovia Martínez', 'maxsegovia@hotmail.com', 12000, 'Mesero', 'Restaurante', 1),
('A01022153', 'miguel890', 'Miguel Monterrubio', 'miguelmonterrubio@gmail.com', 20000, 'Capitan', 'Restaurante', 1),
('A01361235', 'holahola123', 'Lucia Garza', 'luciagarza@gmail.com', 13000, 'Gerente de piso', 'Almacen', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `Id_Factura` char(10) NOT NULL,
  `RFC` char(20) DEFAULT NULL,
  `Monto` int(11) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Correo` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lista_orden`
--

CREATE TABLE `lista_orden` (
  `Id_Platillo` char(10) DEFAULT NULL,
  `Id_Bebida` char(10) DEFAULT NULL,
  `Id_Orden` char(10) DEFAULT NULL,
  `No_Mesa` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `lista_orden`
--

INSERT INTO `lista_orden` (`Id_Platillo`, `Id_Bebida`, `Id_Orden`, `No_Mesa`) VALUES
('07', '', '1', '3'),
('03', '', '2', '3'),
('01', '', '3', '3'),
('04', '', '4', '3'),
('09', '', '5', '5'),
('10', '', '6', '5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `Id_Menu` char(10) NOT NULL,
  `Id_Platillo` char(10) DEFAULT NULL,
  `Id_Bebida` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `No_Mesa` int(11) NOT NULL,
  `Cantidad_Gente` int(11) DEFAULT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `id_empleado` char(10) DEFAULT NULL,
  `Ocupada` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`No_Mesa`, `Cantidad_Gente`, `Nombre`, `id_empleado`, `Ocupada`) VALUES
(1, NULL, NULL, NULL, 0),
(2, NULL, NULL, NULL, 0),
(3, 1, 'Max', 'A01022153', 1),
(4, NULL, NULL, NULL, 0),
(5, 3, 'Javier', 'A01022153', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa_orden`
--

CREATE TABLE `mesa_orden` (
  `Id_Orden` int(11) DEFAULT NULL,
  `No_Mesa` int(11) DEFAULT NULL,
  `Id_Cuenta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mesa_orden`
--

INSERT INTO `mesa_orden` (`Id_Orden`, `No_Mesa`, `Id_Cuenta`) VALUES
(NULL, 3, 13),
(1, 3, 13),
(2, 3, 13),
(3, 3, 13),
(4, 3, 13),
(NULL, 5, 14),
(5, 5, 14),
(6, 5, 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `Id_Orden` int(11) NOT NULL,
  `Completada` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`Id_Orden`, `Completada`) VALUES
(1, 1),
(2, 1),
(3, 0),
(4, 1),
(5, 1),
(6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peticiones`
--

CREATE TABLE `peticiones` (
  `Id_Peticion` char(10) NOT NULL,
  `Producto_Atado` char(30) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillo`
--

CREATE TABLE `platillo` (
  `Id_Platillo` char(10) NOT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Descripcion` text,
  `Ingredientes` text,
  `Precio` int(11) DEFAULT NULL,
  `Tiempo_Preparacion` time DEFAULT NULL,
  `imgSrc` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `platillo`
--

INSERT INTO `platillo` (`Id_Platillo`, `Nombre`, `Descripcion`, `Ingredientes`, `Precio`, `Tiempo_Preparacion`, `imgSrc`) VALUES
('01', 'BONELESS BUFFALO', 'Entrada', NULL, 300, NULL, 'http://www.copykat.com/wp-content/uploads/2013/02/Finished-Boneless-Buffalo-Chicken-Bites.jpg'),
('02', 'MOZARELLA STICKS', 'Entrada', NULL, 300, NULL, 'http://img.sndimg.com/food/image/upload/h_465,w_620,c_fit/v1/img/recipes/30/97/7/rCPq9e9QCuke3PYJclYM_mfood1.jpg'),
('03', 'PIZZA', 'Principal', NULL, 250, NULL, 'http://image.vanguardia.com.mx/sites/default/files/pizza-pepperoni-w857h456_0.jpg'),
('04', 'FRIED CHICKEN', 'Principal', NULL, 130, NULL, 'https://i.ytimg.com/vi/zCPSspT48zM/maxresdefault.jpg'),
('05', 'LASAGNA', 'Principal', NULL, 230, NULL, 'https://barilla.azureedge.net/~/media/images/en_us/hero-images/oven-ready-lasagna.jpg'),
('06', 'SALAD', 'Principal', NULL, 100, NULL, 'http://jetspizza.com/dbphotos/display/c161462910486f60cf38484ecf458adf/664/410'),
('07', 'LEMONADE', 'Bebida', NULL, 50, NULL, 'https://blackmoonejuice.com/wp-content/uploads/2014/06/lemonade.jpg'),
('08', 'SODA', 'Bebida', NULL, 60, NULL, 'https://files.taxfoundation.org/20170316140722/soda3.jpg'),
('09', 'WATER', 'Bebida', NULL, 40, NULL, 'https://media1.britannica.com/eb-media/02/157502-131-7C5D3A67.jpg'),
('10', 'CAKE', 'Postre', NULL, 80, NULL, 'https://d24pyncn3hxs0c.cloudfront.net/sites/default/files/styles/uc_product_full/public/Black-forest-cake-1-Kg-A.jpg?itok=IB1EbtO_'),
('11', 'FLAN', 'Postre', NULL, 75, NULL, 'https://www.meals.com/ImagesRecipes/144670lrg.jpg'),
('12', 'ICE CREAM', 'Postre', NULL, 92, NULL, 'https://www-tc.pbs.org/food/files/2012/07/History-of-Ice-Cream-1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Id_Producto` char(10) NOT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Descripcion` text,
  `Fecha_Ingreso` date DEFAULT NULL,
  `Fecha_Caducidad` date DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Producto_Disponible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_Producto`, `Nombre`, `Descripcion`, `Fecha_Ingreso`, `Fecha_Caducidad`, `Cantidad`, `Producto_Disponible`) VALUES
('05', 'Chicken', 'Meat', '2016-11-22', '2017-11-16', 10, 1),
('1', 'Milk', 'Dairy', '2016-11-21', '2016-11-27', 0, 1),
('2', 'Eggs', 'Dairy', '2016-11-21', '2017-02-16', 100, 1),
('3', 'Tomatoes', 'Vegetables', '2016-11-22', '2017-11-16', 140, 1),
('4', 'Lettuce', 'Vegetables', '2016-11-21', '2017-05-13', 60, 1),
('5', 'Red Meat', 'Meat', '2016-11-22', '2017-02-16', 30, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_restaurante`
--

CREATE TABLE `productos_restaurante` (
  `Id_ProductoRes` int(11) NOT NULL,
  `Id_Producto` char(30) DEFAULT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Producto_Disponible` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos_restaurante`
--

INSERT INTO `productos_restaurante` (`Id_ProductoRes`, `Id_Producto`, `Nombre`, `Cantidad`, `Producto_Disponible`) VALUES
(4, '1', 'Milk', 50, 0),
(5, '2', 'Eggs', 0, 0),
(6, '3', 'Tomatoes', 10, 0),
(7, '4', 'Lettuce', 40, 0),
(8, '5', 'Red Meat', 30, 0),
(9, '05', 'Chicken', 50, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `Id_Reporte` char(10) NOT NULL,
  `Producto_Disponible` bit(1) DEFAULT NULL,
  `Producto_ProximoCaducar` bit(1) DEFAULT NULL,
  `Producto_Caducado` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurante`
--

CREATE TABLE `restaurante` (
  `Id_Restaurante` char(10) NOT NULL,
  `Nombre` char(30) DEFAULT NULL,
  `Descripcion` text,
  `Fecha_Ingreso` date DEFAULT NULL,
  `Fecha_Caducidad` date DEFAULT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Id_Almacen` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alertas`
--
ALTER TABLE `alertas`
  ADD PRIMARY KEY (`Id_Alerta`);

--
-- Indices de la tabla `bebidas`
--
ALTER TABLE `bebidas`
  ADD PRIMARY KEY (`Id_Bebida`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Id_Cliente`);

--
-- Indices de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`Id_Cuenta`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`Id_Empleado`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`Id_Factura`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`Id_Menu`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`No_Mesa`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`Id_Orden`);

--
-- Indices de la tabla `peticiones`
--
ALTER TABLE `peticiones`
  ADD PRIMARY KEY (`Id_Peticion`);

--
-- Indices de la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`Id_Platillo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Id_Producto`);

--
-- Indices de la tabla `productos_restaurante`
--
ALTER TABLE `productos_restaurante`
  ADD PRIMARY KEY (`Id_ProductoRes`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`Id_Reporte`);

--
-- Indices de la tabla `restaurante`
--
ALTER TABLE `restaurante`
  ADD PRIMARY KEY (`Id_Restaurante`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `Id_Cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `No_Mesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `Id_Orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `productos_restaurante`
--
ALTER TABLE `productos_restaurante`
  MODIFY `Id_ProductoRes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
