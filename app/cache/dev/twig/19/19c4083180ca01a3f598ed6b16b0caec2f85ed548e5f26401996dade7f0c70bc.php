<?php

/* :Frontend:index.html.twig */
class __TwigTemplate_b22f411255c2ae19c56aa2af0a633394fdb7f1b9e187645b9f58bf93e9395393 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate(":Frontend:layout.html.twig", ":Frontend:index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return ":Frontend:layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_f32f75d9154320515643326affce0d6e8ba3e24764177d304f160ea05a4bdad5 = $this->env->getExtension("native_profiler");
        $__internal_f32f75d9154320515643326affce0d6e8ba3e24764177d304f160ea05a4bdad5->enter($__internal_f32f75d9154320515643326affce0d6e8ba3e24764177d304f160ea05a4bdad5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Frontend:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_f32f75d9154320515643326affce0d6e8ba3e24764177d304f160ea05a4bdad5->leave($__internal_f32f75d9154320515643326affce0d6e8ba3e24764177d304f160ea05a4bdad5_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_cc52a31f27b7c5e2f2d9ef5a9ec1dfe277eca736799615de8c96df6f71183831 = $this->env->getExtension("native_profiler");
        $__internal_cc52a31f27b7c5e2f2d9ef5a9ec1dfe277eca736799615de8c96df6f71183831->enter($__internal_cc52a31f27b7c5e2f2d9ef5a9ec1dfe277eca736799615de8c96df6f71183831_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <h1><span>Welcome to</span> Prossimo <small>Fronend may be here</small></h1>
";
        
        $__internal_cc52a31f27b7c5e2f2d9ef5a9ec1dfe277eca736799615de8c96df6f71183831->leave($__internal_cc52a31f27b7c5e2f2d9ef5a9ec1dfe277eca736799615de8c96df6f71183831_prof);

    }

    public function getTemplateName()
    {
        return ":Frontend:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 4,  34 => 3,  11 => 1,);
    }
}
/* {% extends ':Frontend:layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <h1><span>Welcome to</span> Prossimo <small>Fronend may be here</small></h1>*/
/* {% endblock %}*/
/* */
