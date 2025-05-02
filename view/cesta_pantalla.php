<?php
require_once __DIR__.'/../includes/config.php';

$tituloPagina = 'Cesta de Compra';
$rutaJS = RUTA_JS . "/cestaJS.js";

$contenidoPrincipal = <<<EOS
    <div class="bloque-contenido">
        <h2 style="text-align: center">
            <strong>Mi Cesta de Compra</strong>
        </h2>
        
        <!-- Mensajes de alerta -->
        <div id="mensajes" class="mensajes-container mb-3"></div>
        
        <div class="row">
            <div class="col-md-8">
                <!-- Contenido de la cesta -->
                <div id="productos" class="mb-4">
                    <!-- Aquí se cargarán los productos dinámicamente con JavaScript -->
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Resumen de la compra -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Resumen de la compra</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5><span id="total-precio">0.00</span>€</h5>
                        </div>
                        <div class="d-grid gap-2">
                            <button id="procederPago" class="btn btn-success btn-lg">Proceder al pago</button>
                            <button onclick="vaciarCesta()" class="btn btn-outline-danger">Vaciar cesta</button>
                        </div>
                    </div>
                </div>
                
                <!-- Información adicional -->
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Información</h5>
                    </div>
                    <div class="card-body">
                        <p><i class="bi bi-info-circle"></i> Los productos se reservarán hasta completar el pago.</p>
                        <p><i class="bi bi-credit-card"></i> Aceptamos diversas formas de pago seguro.</p>
                        <p><i class="bi bi-truck"></i> Gastos de envío: 4.99€ (se añadirán en el paso siguiente)</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botón para continuar comprando -->
        <div class="text-center mt-4">
            <a href="catalogo_pantalla.php" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Continuar comprando
            </a>
        </div>
    </div>
    
    <script src="$rutaJS"></script>
EOS;

require_once __DIR__ . '/../comun/plantilla.php';
?>