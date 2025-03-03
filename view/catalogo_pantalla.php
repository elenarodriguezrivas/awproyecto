<?php
/*sacar las imagenes de la base de datos.*/
$tituloPagina = 'Catálogo de Productos';
$contenidoPrincipal=<<<EOS
    <section class="presentacion">
    <h2>Catalogo de Productos</h2>
            <div class="destacado">
                <ul>
                    <catalogo>
                        <p>Producto1. Impresora fotográfica Canon Selphy CP1500 Blanco</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/4e/cd/7b/8113486/1505-1.jpg" alt="producto 1" class="catalogo img">
                        <p>Producto2. Monitor LG 27UL500P-W 27'' IPS 60Hz Ultra HD Blanco</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/51/39/7f/8337745/1505-1.jpg" alt="producto 1" class="catalogo img">
                        <p>Producto3. Disco duro portátil HDD 2.5 WD My Passport 2TB Rojo</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/d3/e6/53/5498579/1505-1.jpg" alt="producto 1" class="catalogo img">
                        <p>Producto4. Combo Teclado + Ratón inalámbrico Logitech MK540 Advanced</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/6b/77/16/1472363/1505-1/tsp20180510134120/Combo-Teclado-Raton-inalambrico-Logitech-MK540-Advanced.jpg" alt="producto 1" class="catalogo img">
                        <p>Producto5. Ratón inalámbrico vertical Subblim Glide Ergo Dual con batería recargable negro</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/c4/70/8e/9334980/1505-1.jpg" alt="producto 1" class="catalogo img">
                        <p>Producto6. Teclado inalámbrico Logitech MX Keys Mini Rosa</p>
                        <img src="https://static.fnac-static.com/multimedia/Images/ES/NR/39/9b/6d/7183161/1505-1.jpg" alt="producto 1" class="catalogo img">
                    </catalogo>
                </ul>
            </div>
                            
            <p class="descripcion-breve"><em>Plataforma segura</em> que combina innovación tecnológica con responsabilidad ambiental. 
            Ofrecemos un espacio donde cada transacción contribuye a reducir residuos electrónicos mientras 
            disfrutas de experiencias de compra únicas. <strong>¡Únete a la revolución circular!</strong></p>
    </section>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';

?>