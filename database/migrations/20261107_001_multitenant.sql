-- One-time migration from the original BD_FERRETERIA.sql schema.
-- Back up the database and check the preflight queries below before running.
-- Do not run this on a database where tenants or tenant_id already exist.
-- Existing operational rows are assigned to the initial tenant. Customer
-- accounts (role 3) remain platform-wide; staff accounts stay tenant-scoped.

CREATE TABLE IF NOT EXISTS tenants (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL,
    documento VARCHAR(30) DEFAULT NULL,
    correo VARCHAR(150) DEFAULT NULL,
    telefono VARCHAR(30) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    logo VARCHAR(255) DEFAULT NULL,
    estado ENUM('Activo', 'Inactivo') NOT NULL DEFAULT 'Activo',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_tenants_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tenants (nombre, slug, estado)
VALUES ('Ferretería inicial', 'ferreteria-inicial', 'Activo')
ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id);
SET @legacy_tenant_id = LAST_INSERT_ID();

ALTER TABLE productos ADD COLUMN tenant_id INT NULL;
ALTER TABLE usuario
    ADD COLUMN tenant_id INT NULL,
    MODIFY claveUsuario VARCHAR(255) NOT NULL,
    MODIFY documentoUsuario VARCHAR(20) NOT NULL;
ALTER TABLE cliente ADD COLUMN tenant_id INT NULL;
ALTER TABLE proveedor ADD COLUMN tenant_id INT NULL;
ALTER TABLE ventas ADD COLUMN tenant_id INT NULL;
ALTER TABLE compras ADD COLUMN tenant_id INT NULL, ADD COLUMN checkout_id CHAR(32) NULL;
ALTER TABLE peticiones
    ADD COLUMN idPeticion INT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST,
    ADD COLUMN tenant_id INT NULL,
    MODIFY Telefono VARCHAR(20) NULL;
ALTER TABLE ventas MODIFY precio_unitario DECIMAL(10,2) DEFAULT NULL, MODIFY cantidad INT DEFAULT NULL;
ALTER TABLE pedido ADD COLUMN tenant_id INT NULL;
ALTER TABLE factura ADD COLUMN tenant_id INT NULL;
ALTER TABLE detallepedido ADD COLUMN tenant_id INT NULL;
ALTER TABLE detallefactura ADD COLUMN tenant_id INT NULL;

UPDATE usuario SET rol_idRol = 3 WHERE rol_idRol = 0;
UPDATE productos SET tenant_id = @legacy_tenant_id;
UPDATE usuario
SET tenant_id = CASE WHEN rol_idRol IN (3, 4) THEN NULL ELSE @legacy_tenant_id END;
UPDATE cliente SET tenant_id = @legacy_tenant_id;
UPDATE proveedor SET tenant_id = @legacy_tenant_id;
UPDATE ventas SET tenant_id = @legacy_tenant_id;
UPDATE compras SET tenant_id = @legacy_tenant_id;
UPDATE peticiones SET tenant_id = @legacy_tenant_id;
UPDATE pedido SET tenant_id = @legacy_tenant_id;
UPDATE factura SET tenant_id = @legacy_tenant_id;
UPDATE detallepedido SET tenant_id = @legacy_tenant_id;
UPDATE detallefactura SET tenant_id = @legacy_tenant_id;

ALTER TABLE productos MODIFY tenant_id INT NOT NULL;
ALTER TABLE cliente MODIFY tenant_id INT NOT NULL;
ALTER TABLE proveedor MODIFY tenant_id INT NOT NULL;
ALTER TABLE ventas MODIFY tenant_id INT NOT NULL;
ALTER TABLE compras MODIFY tenant_id INT NOT NULL;
ALTER TABLE pedido MODIFY tenant_id INT NOT NULL;
ALTER TABLE factura MODIFY tenant_id INT NOT NULL;
ALTER TABLE detallepedido MODIFY tenant_id INT NOT NULL;
ALTER TABLE detallefactura MODIFY tenant_id INT NOT NULL;

ALTER TABLE rol DROP FOREIGN KEY rol_ibfk_1;
INSERT INTO rol (idRol, nombreRol)
VALUES (3, 'Cliente'), (4, 'Superadmin')
ON DUPLICATE KEY UPDATE nombreRol = VALUES(nombreRol);

-- These checks must return no rows before adding the unique keys.
-- SELECT correo, COUNT(*) FROM usuario GROUP BY correo HAVING COUNT(*) > 1;
-- SELECT tenant_id, codigoProducto, COUNT(*) FROM productos GROUP BY tenant_id, codigoProducto HAVING COUNT(*) > 1;
ALTER TABLE usuario ADD UNIQUE KEY uq_usuario_correo (correo);
ALTER TABLE productos ADD UNIQUE KEY uq_productos_tenant_codigo (tenant_id, codigoProducto);
ALTER TABLE usuario ADD UNIQUE KEY uq_usuario_tenant_id (tenant_id, idUsuario);
ALTER TABLE productos ADD UNIQUE KEY uq_productos_tenant_id (tenant_id, idProducto);
ALTER TABLE cliente ADD UNIQUE KEY uq_cliente_tenant_id (tenant_id, idCliente);
ALTER TABLE pedido ADD UNIQUE KEY uq_pedido_tenant_id (tenant_id, idPedido);
ALTER TABLE factura ADD UNIQUE KEY uq_factura_tenant_id (tenant_id, idFactura);

ALTER TABLE usuario
    ADD KEY idx_usuario_tenant_rol (tenant_id, rol_idRol),
    ADD CONSTRAINT fk_usuario_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id),
    ADD CONSTRAINT fk_usuario_rol FOREIGN KEY (rol_idRol) REFERENCES rol (idRol);
ALTER TABLE productos
    ADD KEY idx_productos_tenant (tenant_id),
    ADD CONSTRAINT fk_productos_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE cliente
    ADD KEY idx_cliente_tenant (tenant_id),
    ADD CONSTRAINT fk_cliente_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE proveedor
    ADD KEY idx_proveedor_tenant (tenant_id),
    ADD CONSTRAINT fk_proveedor_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE ventas
    ADD KEY idx_ventas_tenant_fecha (tenant_id, fecha_venta),
    ADD CONSTRAINT fk_ventas_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE compras
    ADD KEY idx_compras_tenant_checkout (tenant_id, checkout_id),
    ADD CONSTRAINT fk_compras_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE peticiones
    ADD KEY idx_peticiones_tenant (tenant_id),
    ADD CONSTRAINT fk_peticiones_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE pedido
    ADD KEY idx_pedido_tenant (tenant_id),
    ADD CONSTRAINT fk_pedido_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE factura
    ADD KEY idx_factura_tenant (tenant_id),
    ADD CONSTRAINT fk_factura_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE detallepedido
    ADD KEY idx_detallepedido_tenant (tenant_id),
    ADD CONSTRAINT fk_detallepedido_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);
ALTER TABLE detallefactura
    ADD KEY idx_detallefactura_tenant (tenant_id),
    ADD CONSTRAINT fk_detallefactura_tenant FOREIGN KEY (tenant_id) REFERENCES tenants (id);

-- Composite foreign keys prevent a row from linking records across tenants.
ALTER TABLE compras
    ADD CONSTRAINT fk_compras_producto_tenant
    FOREIGN KEY (tenant_id, producto_id) REFERENCES productos (tenant_id, idProducto);
ALTER TABLE pedido
    ADD CONSTRAINT fk_pedido_cliente_tenant
    FOREIGN KEY (tenant_id, cliente_idCliente) REFERENCES cliente (tenant_id, idCliente);
ALTER TABLE factura
    ADD CONSTRAINT fk_factura_cliente_tenant
    FOREIGN KEY (tenant_id, cliente_idCliente) REFERENCES cliente (tenant_id, idCliente),
    ADD CONSTRAINT fk_factura_usuario_tenant
    FOREIGN KEY (tenant_id, usuario_idUsuario) REFERENCES usuario (tenant_id, idUsuario),
    ADD CONSTRAINT fk_factura_pedido_tenant
    FOREIGN KEY (tenant_id, pedido_idPedido) REFERENCES pedido (tenant_id, idPedido);
ALTER TABLE detallepedido
    ADD CONSTRAINT fk_detallepedido_pedido_tenant
    FOREIGN KEY (tenant_id, pedido_idPedido) REFERENCES pedido (tenant_id, idPedido),
    ADD CONSTRAINT fk_detallepedido_producto_tenant
    FOREIGN KEY (tenant_id, producto_idProducto) REFERENCES productos (tenant_id, idProducto);
ALTER TABLE detallefactura
    ADD CONSTRAINT fk_detallefactura_factura_tenant
    FOREIGN KEY (tenant_id, factura_idFactura) REFERENCES factura (tenant_id, idFactura),
    ADD CONSTRAINT fk_detallefactura_producto_tenant
    FOREIGN KEY (tenant_id, productos_idProducto) REFERENCES productos (tenant_id, idProducto);

-- Do not put an initial superadmin password in this migration. Create the
-- platform account through the approved deployment secret/bootstrap process.
