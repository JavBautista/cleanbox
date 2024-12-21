INSERT INTO cleanbox.products (
    id,
    category_id,
    subcategory_id,
    active,
    `key`,
    key_alt,
    name,
    description,
    factor,
    cost,
    cost_avg,
    margin_1,
    margin_2,
    margin_3,
    margin_4,
    price_1,
    price_2,
    price_3,
    price_4
)
SELECT
    a.art_id,
    c.dep_id,
    a.cat_id,
    a.status,
    a.clave,
    a.claveAlterna,
    a.descripcion,
    a.descripcion,
    a.factor,
    CAST(a.precioCompra AS DECIMAL(8,4)),
    CAST(a.preCompraProm AS DECIMAL(8,4)),
    CAST(a.margen1 AS DECIMAL(8,2)),
    CAST(a.margen2 AS DECIMAL(8,2)),
    CAST(a.margen3 AS DECIMAL(8,2)),
    CAST(a.margen4 AS DECIMAL(8,2)),
    CAST(a.precio1 AS DECIMAL(8,2)),
    CAST(a.precio2 AS DECIMAL(8,2)),
    CAST(a.precio3 AS DECIMAL(8,2)),
    CAST(a.precio4 AS DECIMAL(8,2))
FROM sicar.articulo a
LEFT JOIN sicar.categoria c ON c.cat_id = a.cat_id;

--
INSERT INTO cleanbox.images (id,image)
SELECT img_id, imagen
FROM sicar.imagen

--

INSERT INTO cleanbox.product_images (product_id,image_id, selected)
SELECT art_id, img_id, seleccionada
FROM sicar.articuloimagen

--

INSERT INTO cleanbox.clients (id, active, name, company, email, phone, movil, address, zip_code, number_out, number_int, district, city, state, rfc, curp, detail)
SELECT cli_id, status, representante, nombre, mail, telefono, celular, domicilio, codigoPostal, noExt, noInt, colonia,ciudad, estado, rfc, curp, comentario
FROM sicar.cliente
