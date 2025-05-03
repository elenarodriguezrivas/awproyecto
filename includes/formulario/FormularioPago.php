<?php
require_once __DIR__.'/Formulario.php';
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../Cesta/sa/obtenerCestaSA.php';

class FormularioPagoCesta extends Formulario
{
    private $productos;
    private $precioTotal;

    public function __construct($userId)
    {
        parent::__construct('formPagoCesta', [
            'action' => '', // URL de procesamiento (ej: 'procesar_pago_cesta.php')
            'method' => 'POST',
            'class' => 'form-pago',
        ]);

        // Obtener la cesta del usuario
        $cestaSA = new obtenerCestaSA();
        $cesta = $cestaSA->obtenerCesta($userId);

        if ($cesta) {
            $this->productos = $cesta->getProductosCesta();
            $this->precioTotal = array_reduce(
                $this->productos,
                function ($total, $producto) {
                    return $total + $producto->getPrecio();
                },
                0
            );
        } else {
            $this->productos = [];
            $this->precioTotal = 0;
        }
    }

    protected function generaCamposFormulario()
    {
        // Mostrar resumen de productos
        $htmlProductos = '';
        foreach ($this->productos as $producto) {
            $nombre = $producto->getNombreProducto();
            $precio = $producto->getPrecio();
            $htmlProductos .= "<p><strong>{$nombre}</strong>: {$precio} €</p>";
        }

        $html = <<<EOF
        <div class="form-group">
            <h2>Resumen de la Cesta</h2>
            {$htmlProductos}
            <p><strong>Total a pagar:</strong> {$this->precioTotal} €</p>
        </div>
        <div class="form-group">
            <label for="tarjeta">Número de Tarjeta:</label>
            <input id="tarjeta" type="text" name="tarjeta" placeholder="1234 5678 9012 3456" required class="form-control">
        </div>
        <div class="form-group">
            <label for="caducidad">Fecha de Caducidad (MM/AA):</label>
            <input id="caducidad" type="text" name="caducidad" placeholder="MM/AA" required class="form-control">
        </div>
        <div class="form-group">
            <label for="cvv">CVV:</label>
            <input id="cvv" type="text" name="cvv" placeholder="123" required class="form-control">
        </div>
        <div class="form-group">
            <label for="titular">Nombre del Titular:</label>
            <input id="titular" type="text" name="titular" placeholder="Nombre como aparece en la tarjeta" required class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-pago">Pagar Ahora</button>
            <a href="cesta_pantalla.php" class="btn btn-secondary">Cancelar</a>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // Validación básica
        $tarjeta = trim($datos['tarjeta'] ?? '');
        $caducidad = trim($datos['caducidad'] ?? '');
        $cvv = trim($datos['cvv'] ?? '');

        if (empty($tarjeta) || empty($caducidad) || empty($cvv)) {
            return "Error: Todos los campos son obligatorios.";
        }

        // Simular éxito de pago (en producción, aquí se integraría con RedSys/Stripe/etc.)
        return "¡Pago exitoso! Se ha cobrado {$this->precioTotal} € por los productos de la cesta.";
    }
}