<?php

/* :Admin:index.html.twig */
class __TwigTemplate_6f0fb3d749772eea732743522914dfd01d7b87390bac852f142d2405a8d9aa2a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate(":Admin:layout.html.twig", ":Admin:index.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return ":Admin:layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_9443206d00f0e86f230c992ed30880b0e460b0d16f94bec8aeeed499c97c5878 = $this->env->getExtension("native_profiler");
        $__internal_9443206d00f0e86f230c992ed30880b0e460b0d16f94bec8aeeed499c97c5878->enter($__internal_9443206d00f0e86f230c992ed30880b0e460b0d16f94bec8aeeed499c97c5878_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin:index.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_9443206d00f0e86f230c992ed30880b0e460b0d16f94bec8aeeed499c97c5878->leave($__internal_9443206d00f0e86f230c992ed30880b0e460b0d16f94bec8aeeed499c97c5878_prof);

    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        $__internal_aa2132ae7cd2097d7c419fc35af713eab060d8b5547bae731b9c97319038c4c5 = $this->env->getExtension("native_profiler");
        $__internal_aa2132ae7cd2097d7c419fc35af713eab060d8b5547bae731b9c97319038c4c5->enter($__internal_aa2132ae7cd2097d7c419fc35af713eab060d8b5547bae731b9c97319038c4c5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 4
        echo "    <div class=\"row\">
        <div class=\"col-lg-12\">
            <h1 class=\"page-header\">Prossimo <small>Administration section</small></h1>

            <p>You are in administration section of prossimo application</p>
        </div>
        <!-- /.col-lg-12 -->
    </div>

";
        
        $__internal_aa2132ae7cd2097d7c419fc35af713eab060d8b5547bae731b9c97319038c4c5->leave($__internal_aa2132ae7cd2097d7c419fc35af713eab060d8b5547bae731b9c97319038c4c5_prof);

    }

    public function getTemplateName()
    {
        return ":Admin:index.html.twig";
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
/* {% extends ':Admin:layout.html.twig' %}*/
/* */
/* {% block content %}*/
/*     <div class="row">*/
/*         <div class="col-lg-12">*/
/*             <h1 class="page-header">Prossimo <small>Administration section</small></h1>*/
/* */
/*             <p>You are in administration section of prossimo application</p>*/
/*         </div>*/
/*         <!-- /.col-lg-12 -->*/
/*     </div>*/
/* */
/* {% endblock %}*/
/* */
