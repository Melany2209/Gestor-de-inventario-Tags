CREATE DATABASE `gestor_entradas_salidas`;
USE `gestor_entradas_salidas`;

CREATE TABLE `usuarios` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `usuario` varchar(15) DEFAULT NULL,
  `clave` varchar(100) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
);

INSERT INTO `usuarios` (`usuario`, `clave`) VALUES
('admin', '25d55ad283aa400af464c76d713c07ad');


CREATE TABLE `categorias` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `categoria` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
);

CREATE TABLE `sub_categorias` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `sub_categoria` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1
);

CREATE TABLE `productos`(
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `producto` varchar(250) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_modificacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `stock_minimo` double DEFAULT NULL,
  `tipo_de_unidad` varchar(100) DEFAULT NULL,
  `id_sub_categoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
);

ALTER TABLE productos 
ADD CONSTRAINT fk_id_sub_categoria_1
FOREIGN KEY (id_sub_categoria) 
REFERENCES sub_categorias(id);

ALTER TABLE productos 
ADD CONSTRAINT fk_id_categoria_1
FOREIGN KEY (id_categoria) 
REFERENCES categorias(id);


CREATE TABLE `categoria_sub_categoria` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `id_sub_categoria` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1
);

ALTER TABLE categoria_sub_categoria 
ADD CONSTRAINT fk_id_sub_categoria_2
FOREIGN KEY (id_sub_categoria) 
REFERENCES sub_categorias(id);

ALTER TABLE categoria_sub_categoria 
ADD CONSTRAINT fk_id_categoria_2
FOREIGN KEY (id_categoria) 
REFERENCES categorias(id);


CREATE TABLE entradasalidaTotal (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_entrada` TIMESTAMP NULL,
  `fecha_salida` TIMESTAMP NULL,
  `status` TINYINT(4) DEFAULT 1,
  `id_producto` INT(11) NOT NULL
);

ALTER TABLE entradasalidaTotal
ADD CONSTRAINT fk_id_producto_2
FOREIGN KEY (id_producto) 
REFERENCES productos(id);


CREATE TABLE movimientos (
  `id` INT(11) PRIMARY KEY AUTO_INCREMENT,
  `entradas` double DEFAULT 0,
  `salidas` double DEFAULT 0,
  `stock_actual` double DEFAULT NULL,
  `fecha_entrada` TIMESTAMP NULL,
  `fecha_salida` TIMESTAMP NULL,
  `status` TINYINT(4) DEFAULT 1,
  `id_producto` INT(11) NOT NULL
);

ALTER TABLE movimientos
ADD CONSTRAINT fk_id_producto_3
FOREIGN KEY (id_producto) 
REFERENCES productos(id);





/*
CREATE TABLE `colores` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `descripcion` varchar(255),
  `status` tinyint(4) DEFAULT 0
);

INSERT INTO `colores` (`descripcion`) VALUES
('rojo'),
('naranja'),
('amarillo'),
('verde-lima'),
('verde-neon'),
('verde-aqua'),
('verde-pastel'),
('verde-esmeralda'),
('aqua-brillante'),
('cian'),
('azul-claro'),
('azul'),
('azul-profundo'),
('azul-marino'),
('violeta'),
('purpura'),
('purpura-oscuro'),
('magenta'),
('rosa'),
('rosa-fucsia'),
('rosa-fuerte'),
('rosa-pastel'),
('rosa-vivo');
*/