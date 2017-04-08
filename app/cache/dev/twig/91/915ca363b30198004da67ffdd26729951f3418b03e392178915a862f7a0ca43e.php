<?php

/* :Frontend:layout.html.twig */
class __TwigTemplate_373f951a3aac6e9a12b5c551dbf28a77662c29043fffcf9ef98ed82eead16ab3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", ":Frontend:layout.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_e9b47ebbe36137c93e1ff5c3e9c2c316cdca7a01730f1b748431e8e32e32c1c5 = $this->env->getExtension("native_profiler");
        $__internal_e9b47ebbe36137c93e1ff5c3e9c2c316cdca7a01730f1b748431e8e32e32c1c5->enter($__internal_e9b47ebbe36137c93e1ff5c3e9c2c316cdca7a01730f1b748431e8e32e32c1c5_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Frontend:layout.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_e9b47ebbe36137c93e1ff5c3e9c2c316cdca7a01730f1b748431e8e32e32c1c5->leave($__internal_e9b47ebbe36137c93e1ff5c3e9c2c316cdca7a01730f1b748431e8e32e32c1c5_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_b02def95a5fef971c3afce08816b8e7c0cf979632ebfab63f0d9cb7d36f68f18 = $this->env->getExtension("native_profiler");
        $__internal_b02def95a5fef971c3afce08816b8e7c0cf979632ebfab63f0d9cb7d36f68f18->enter($__internal_b02def95a5fef971c3afce08816b8e7c0cf979632ebfab63f0d9cb7d36f68f18_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <div class=\"container\">
        ";
        // line 5
        $this->displayBlock('content', $context, $blocks);
        // line 6
        echo "    </div>

    ";
        // line 8
        $this->loadTemplate("Frontend/include/footer.html.twig", ":Frontend:layout.html.twig", 8)->display($context);
        
        $__internal_b02def95a5fef971c3afce08816b8e7c0cf979632ebfab63f0d9cb7d36f68f18->leave($__internal_b02def95a5fef971c3afce08816b8e7c0cf979632ebfab63f0d9cb7d36f68f18_prof);

    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        $__internal_6de9ebe2fae1e5b50509a8c87574762d848caa7a582a8fe1f9ac811f8a5ea1c9 = $this->env->getExtension("native_profiler");
        $__internal_6de9ebe2fae1e5b50509a8c87574762d848caa7a582a8fe1f9ac811f8a5ea1c9->enter($__internal_6de9ebe2fae1e5b50509a8c87574762d848caa7a582a8fe1f9ac811f8a5ea1c9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_6de9ebe2fae1e5b50509a8c87574762d848caa7a582a8fe1f9ac811f8a5ea1c9->leave($__internal_6de9ebe2fae1e5b50509a8c87574762d848caa7a582a8fe1f9ac811f8a5ea1c9_prof);

    }

    public function getTemplateName()
    {
        return ":Frontend:layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  57 => 5,  50 => 8,  46 => 6,  44 => 5,  41 => 4,  35 => 3,  11 => 1,);
    }
}
/* {% extends 'base.html.twig' %}*/
/* */
/* {% block body %}*/
/*     <div class="container">*/
/*         {% block content %}{% endblock %}*/
/*     </div>*/
/* */
/*     {% include('Frontend/include/footer.html.twig') %}*/
/* {% endblock %}*/
