<?php

/* FOSUserBundle::layout.html.twig */
class __TwigTemplate_711022fb7a64a1f47837fe6ffb5faf681651444c882f5635fbee937fed10b0c5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::base.html.twig", "FOSUserBundle::layout.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'content' => array($this, 'block_content'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_86e0255603c2e8efea1b37fe7b794ef89a3d0f834ea79b1c05b653a0ae26569e = $this->env->getExtension("native_profiler");
        $__internal_86e0255603c2e8efea1b37fe7b794ef89a3d0f834ea79b1c05b653a0ae26569e->enter($__internal_86e0255603c2e8efea1b37fe7b794ef89a3d0f834ea79b1c05b653a0ae26569e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle::layout.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_86e0255603c2e8efea1b37fe7b794ef89a3d0f834ea79b1c05b653a0ae26569e->leave($__internal_86e0255603c2e8efea1b37fe7b794ef89a3d0f834ea79b1c05b653a0ae26569e_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_9920f252986d1650a236a579ae0e19e02cc654955e2a7b855c1c36bb35a75603 = $this->env->getExtension("native_profiler");
        $__internal_9920f252986d1650a236a579ae0e19e02cc654955e2a7b855c1c36bb35a75603->enter($__internal_9920f252986d1650a236a579ae0e19e02cc654955e2a7b855c1c36bb35a75603_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <div class=\"container\">
        ";
        // line 5
        $this->displayBlock('content', $context, $blocks);
        // line 8
        echo "    </div>
";
        
        $__internal_9920f252986d1650a236a579ae0e19e02cc654955e2a7b855c1c36bb35a75603->leave($__internal_9920f252986d1650a236a579ae0e19e02cc654955e2a7b855c1c36bb35a75603_prof);

    }

    // line 5
    public function block_content($context, array $blocks = array())
    {
        $__internal_278b927c5ffb3a6333680da30a9a0d27792cf782bb181c434dfb14a794371c11 = $this->env->getExtension("native_profiler");
        $__internal_278b927c5ffb3a6333680da30a9a0d27792cf782bb181c434dfb14a794371c11->enter($__internal_278b927c5ffb3a6333680da30a9a0d27792cf782bb181c434dfb14a794371c11_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 6
        echo "            ";
        $this->displayBlock('fos_user_content', $context, $blocks);
        // line 7
        echo "        ";
        
        $__internal_278b927c5ffb3a6333680da30a9a0d27792cf782bb181c434dfb14a794371c11->leave($__internal_278b927c5ffb3a6333680da30a9a0d27792cf782bb181c434dfb14a794371c11_prof);

    }

    // line 6
    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_eaa9aee80b549241cace5b5e1005d59c814e80f723f07e1cb48ef63b0e57b395 = $this->env->getExtension("native_profiler");
        $__internal_eaa9aee80b549241cace5b5e1005d59c814e80f723f07e1cb48ef63b0e57b395->enter($__internal_eaa9aee80b549241cace5b5e1005d59c814e80f723f07e1cb48ef63b0e57b395_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        
        $__internal_eaa9aee80b549241cace5b5e1005d59c814e80f723f07e1cb48ef63b0e57b395->leave($__internal_eaa9aee80b549241cace5b5e1005d59c814e80f723f07e1cb48ef63b0e57b395_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  71 => 6,  64 => 7,  61 => 6,  55 => 5,  47 => 8,  45 => 5,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '::base.html.twig' %}*/
/* */
/* {% block body %}*/
/*     <div class="container">*/
/*         {% block content %}*/
/*             {% block fos_user_content %}{% endblock %}*/
/*         {% endblock %}*/
/*     </div>*/
/* {% endblock %}*/
