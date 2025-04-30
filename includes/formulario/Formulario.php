<?php

/**
 * Clase base para la generación de formularios.
 */
abstract class Formulario
{
    /**
     * @var string Identificador único utilizado para "id" de la etiqueta <form>.
     */
    protected $formId;

    /**
     * @var string Método HTTP utilizado para enviar el formulario.
     */
    protected $method;

    /**
     * @var string URL asociada al atributo "action" de la etiqueta <form>.
     */
    protected $action;

    /**
     * @var string Valor del atributo "class" de la etiqueta <form>.
     */
    protected $classAtt;

    /**
     * @var string Valor del parámetro enctype del formulario.
     */
    protected $enctype;

    /**
     * Crea un nuevo formulario.
     *
     * @param string $formId Identificador único del formulario.
     * @param array $opciones Array de opciones para el formulario:
     *  - action: URL asociada al atributo "action" (por defecto, la URL actual).
     *  - method: Método HTTP (por defecto, 'POST').
     *  - class: Clase CSS para el formulario.
     *  - enctype: Tipo de codificación del formulario.
     */
    public function __construct($formId, $opciones = array())
    {
        $this->formId = $formId;

        $opcionesPorDefecto = $this->initialize(); // Inicializar opciones por defecto
        $opciones = array_merge($opcionesPorDefecto, $opciones);

        $this->action = $opciones['action'];
        $this->method = $opciones['method'];
        $this->classAtt = $opciones['class'];
        $this->enctype = $opciones['enctype'];
    }

    private function initialize(){
        $opcionesPorDefecto = array(
            'action' => htmlspecialchars($_SERVER['REQUEST_URI']),
            'method' => 'POST',
            'class' => null,
            'enctype' => null
        );
        return $opcionesPorDefecto;
    }

    /**
     * Genera el HTML necesario para los campos del formulario.
     *
     * Este método debe ser implementado por las clases hijas.
     *
     * @return string HTML de los campos del formulario.
     */
    abstract protected function generaCamposFormulario();

    /**
     * Genera el HTML del formulario.
     *
     * @return string HTML del formulario.
     */
    public function generaFormulario()
    {
        $htmlCamposFormularios = $this->generaCamposFormulario();

        $classAtt = $this->classAtt != null ? "class=\"{$this->classAtt}\"" : '';
        $enctypeAtt = $this->enctype != null ? "enctype=\"{$this->enctype}\"" : '';

        $htmlForm = <<<EOS
        <form method="{$this->method}" action="{$this->action}" id="{$this->formId}" {$classAtt} {$enctypeAtt}>
            $htmlCamposFormularios
        </form>
        EOS;

        return $htmlForm;
    }
}