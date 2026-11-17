-- Preserve the unit price paid for each marketplace purchase.
-- Existing rows are backfilled with the current product price because the
-- previous schema did not store historical prices.
ALTER TABLE compras
    ADD COLUMN precio_unitario DECIMAL(10,2) NULL AFTER cantidad;

UPDATE compras c
JOIN productos p
    ON p.idProducto = c.producto_id
   AND p.tenant_id = c.tenant_id
SET c.precio_unitario = p.valorProducto;

ALTER TABLE compras
    MODIFY precio_unitario DECIMAL(10,2) NOT NULL;
