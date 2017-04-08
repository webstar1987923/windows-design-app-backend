<?php

/* base.html.twig */
class __TwigTemplate_2ec54f80ce9af056deebea3149c0e63e1068fa26659f44ff523853be0520791e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_904cf5d8eb68f943d7fd212935f968ebb83e288b92867537edb0553e33911bd9 = $this->env->getExtension("native_profiler");
        $__internal_904cf5d8eb68f943d7fd212935f968ebb83e288b92867537edb0553e33911bd9->enter($__internal_904cf5d8eb68f943d7fd212935f968ebb83e288b92867537edb0553e33911bd9_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "</title>

        <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/bootstrap.min.css"), "html", null, true);
        echo "\">
        <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/bootstrap-theme.min.css"), "html", null, true);
        echo "\">
        <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/bootstrap-select.min.css"), "html", null, true);
        echo "\">
        ";
        // line 15
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 16
        echo "
        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
        <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
    </head>
    <body>
        ";
        // line 27
        $this->displayBlock('body', $context, $blocks);
        // line 28
        echo "
        <script src=\"";
        // line 29
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/jquery.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
        <script src=\"";
        // line 31
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/bootstrap-select.min.js"), "html", null, true);
        echo "\"></script>
        ";
        // line 32
        $this->displayBlock('javascripts', $context, $blocks);
        // line 33
        echo "    </body>
</html>
";
        
        $__internal_904cf5d8eb68f943d7fd212935f968ebb83e288b92867537edb0553e33911bd9->leave($__internal_904cf5d8eb68f943d7fd212935f968ebb83e288b92867537edb0553e33911bd9_prof);

    }

    // line 10
    public function block_title($context, array $blocks = array())
    {
        $__internal_c903805ff859e028904f0ba163170ec8baf03f6a17739a838865e001593ef737 = $this->env->getExtension("native_profiler");
        $__internal_c903805ff859e028904f0ba163170ec8baf03f6a17739a838865e001593ef737->enter($__internal_c903805ff859e028904f0ba163170ec8baf03f6a17739a838865e001593ef737_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Prossimo!";
        
        $__internal_c903805ff859e028904f0ba163170ec8baf03f6a17739a838865e001593ef737->leave($__internal_c903805ff859e028904f0ba163170ec8baf03f6a17739a838865e001593ef737_prof);

    }

    // line 15
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_915340950a17f87b88e6ca9e889e155019163fe2282fb0be41226dae0c8cadde = $this->env->getExtension("native_profiler");
        $__internal_915340950a17f87b88e6ca9e889e155019163fe2282fb0be41226dae0c8cadde->enter($__internal_915340950a17f87b88e6ca9e889e155019163fe2282fb0be41226dae0c8cadde_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_915340950a17f87b88e6ca9e889e155019163fe2282fb0be41226dae0c8cadde->leave($__internal_915340950a17f87b88e6ca9e889e155019163fe2282fb0be41226dae0c8cadde_prof);

    }

    // line 27
    public function block_body($context, array $blocks = array())
    {
        $__internal_8995358550ff6f58749c6d9dd0cd4a07762169f779d83bbda212760367818d8a = $this->env->getExtension("native_profiler");
        $__internal_8995358550ff6f58749c6d9dd0cd4a07762169f779d83bbda212760367818d8a->enter($__internal_8995358550ff6f58749c6d9dd0cd4a07762169f779d83bbda212760367818d8a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_8995358550ff6f58749c6d9dd0cd4a07762169f779d83bbda212760367818d8a->leave($__internal_8995358550ff6f58749c6d9dd0cd4a07762169f779d83bbda212760367818d8a_prof);

    }

    // line 32
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_e1677ba5664d3003dc9191088b3a5708ddf5904a751f343862fc8b4c17919b0c = $this->env->getExtension("native_profiler");
        $__internal_e1677ba5664d3003dc9191088b3a5708ddf5904a751f343862fc8b4c17919b0c->enter($__internal_e1677ba5664d3003dc9191088b3a5708ddf5904a751f343862fc8b4c17919b0c_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_e1677ba5664d3003dc9191088b3a5708ddf5904a751f343862fc8b4c17919b0c->leave($__internal_e1677ba5664d3003dc9191088b3a5708ddf5904a751f343862fc8b4c17919b0c_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 32,  123 => 27,  112 => 15,  100 => 10,  91 => 33,  89 => 32,  85 => 31,  81 => 30,  77 => 29,  74 => 28,  72 => 27,  59 => 17,  56 => 16,  54 => 15,  50 => 14,  46 => 13,  42 => 12,  37 => 10,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <meta http-equiv="X-UA-Compatible" content="IE=edge">*/
/*         <meta name="viewport" content="width=device-width, initial-scale=1">*/
/*         <meta name="description" content="">*/
/*         <meta name="author" content="">*/
/* */
/*         <title>{% block title %}Prossimo!{% endblock %}</title>*/
/* */
/*         <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">*/
/*         <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">*/
/*         <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">*/
/*         {% block stylesheets %}{% endblock %}*/
/* */
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/* */
/*         <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->*/
/*         <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->*/
/*         <!--[if lt IE 9]>*/
/*         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>*/
/*         <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>*/
/*         <![endif]-->*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/* */
/*         <script src="{{ asset('js/jquery.min.js') }}"></script>*/
/*         <script src="{{ asset('js/bootstrap.min.js') }}"></script>*/
/*         <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
/* */
