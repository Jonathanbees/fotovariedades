# Fotovariedades
Fotovariedades es una empresa distribuidora de papelería, la cual se planteaba la necesidad de tener un sistema de inventario lo suficientemente robusto para llevar el registro de cada producto, tener disponibilidad para hacer CRUD de cada producto,
listar cada producto según categorías, búsquedas, **gráficas** aludiendo a reportes dignos para tomar decisiones dentro de la empresa, y por último, tener posibilidad de generación de facturas cuando se compran o venden productos, generando confiabilidad en los reportes y cantidades.

## MVC en fotovariedades
El modelo vista controlador es una manera más organizada de estructurar el código para una página desde el backend,
El controlador se definirá por una parte, el cual dispondrá de las funciones que prefiera para mostrarle al usuario las funciones propias de esa rama específica,
entonces, el controlador dispondrá de métodos, los cuales harán estas acciones (por ejemplo: operaciones CRUD), 
ahí es donde entra el modelo, que recibe estas acciones, y hace las consultas necesarias dentro de esa rama (modelo del controlador),
por último, cuando se hace la validación desde la BD, se le manda una respuesta que la vista podrá interpretar y mostrar de forma exitosa
