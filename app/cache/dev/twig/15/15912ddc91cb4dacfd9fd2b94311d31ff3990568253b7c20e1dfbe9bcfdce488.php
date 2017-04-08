<?php

/* :Admin:layout.html.twig */
class __TwigTemplate_5ec98f9b9d7e4d69465055673cc40033af91c8286263ccaa2c21fba645dc74d3 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", ":Admin:layout.html.twig", 1);
        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
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
        $__internal_a1f16f6a7c3136a5d01b3fcd26518f3723cb3ecd7229d352546b8db88076066f = $this->env->getExtension("native_profiler");
        $__internal_a1f16f6a7c3136a5d01b3fcd26518f3723cb3ecd7229d352546b8db88076066f->enter($__internal_a1f16f6a7c3136a5d01b3fcd26518f3723cb3ecd7229d352546b8db88076066f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":Admin:layout.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_a1f16f6a7c3136a5d01b3fcd26518f3723cb3ecd7229d352546b8db88076066f->leave($__internal_a1f16f6a7c3136a5d01b3fcd26518f3723cb3ecd7229d352546b8db88076066f_prof);

    }

    // line 3
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_445065198566641beb5155ce6324df5430c28639ccb0f79a407a3b1ad227ce37 = $this->env->getExtension("native_profiler");
        $__internal_445065198566641beb5155ce6324df5430c28639ccb0f79a407a3b1ad227ce37->enter($__internal_445065198566641beb5155ce6324df5430c28639ccb0f79a407a3b1ad227ce37_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 4
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/admin.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/timeline.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 6
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/sb-admin-2.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/morris.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/font-awesome.min.css"), "html", null, true);
        echo "\">
";
        
        $__internal_445065198566641beb5155ce6324df5430c28639ccb0f79a407a3b1ad227ce37->leave($__internal_445065198566641beb5155ce6324df5430c28639ccb0f79a407a3b1ad227ce37_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_0ab0ad4cbd428f904200c484de5f605bdaaffe000b94a2c1d5eaae1b071fdbba = $this->env->getExtension("native_profiler");
        $__internal_0ab0ad4cbd428f904200c484de5f605bdaaffe000b94a2c1d5eaae1b071fdbba->enter($__internal_0ab0ad4cbd428f904200c484de5f605bdaaffe000b94a2c1d5eaae1b071fdbba_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 12
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/metisMenu.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/raphael-min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/morris.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/sb-admin-2.js"), "html", null, true);
        echo "\"></script>
    <script>
        window.prossimo = {
            api_base_path: '";
        // line 18
        echo twig_escape_filter($this->env, (isset($context["api_base_path"]) ? $context["api_base_path"] : $this->getContext($context, "api_base_path")), "html", null, true);
        echo "'
        };
    </script>
";
        
        $__internal_0ab0ad4cbd428f904200c484de5f605bdaaffe000b94a2c1d5eaae1b071fdbba->leave($__internal_0ab0ad4cbd428f904200c484de5f605bdaaffe000b94a2c1d5eaae1b071fdbba_prof);

    }

    // line 23
    public function block_body($context, array $blocks = array())
    {
        $__internal_738b3de71c046fe0b0cba9d1383938b3bc5f0d869fba9b3175684b05205586d0 = $this->env->getExtension("native_profiler");
        $__internal_738b3de71c046fe0b0cba9d1383938b3bc5f0d869fba9b3175684b05205586d0->enter($__internal_738b3de71c046fe0b0cba9d1383938b3bc5f0d869fba9b3175684b05205586d0_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 24
        echo "    <div id=\"wrapper\">
        ";
        // line 25
        $this->loadTemplate(":Admin/include:nav.html.twig", ":Admin:layout.html.twig", 25)->display($context);
        // line 26
        echo "
        <div id=\"page-wrapper\" style=\"min-height: 875px;\">
        ";
        // line 28
        $this->displayBlock('content', $context, $blocks);
        // line 29
        echo "        </div>
    </div>

    ";
        // line 32
        $this->loadTemplate(":Admin/include:footer.html.twig", ":Admin:layout.html.twig", 32)->display($context);
        
        $__internal_738b3de71c046fe0b0cba9d1383938b3bc5f0d869fba9b3175684b05205586d0->leave($__internal_738b3de71c046fe0b0cba9d1383938b3bc5f0d869fba9b3175684b05205586d0_prof);

    }

    // line 28
    public function block_content($context, array $blocks = array())
    {
        $__internal_b46331e0ac30ec03408014d5e36ed5a03d0dfb8954f037ab0e91089818715f2e = $this->env->getExtension("native_profiler");
        $__internal_b46331e0ac30ec03408014d5e36ed5a03d0dfb8954f037ab0e91089818715f2e->enter($__internal_b46331e0ac30ec03408014d5e36ed5a03d0dfb8954f037ab0e91089818715f2e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        
        $__internal_b46331e0ac30ec03408014d5e36ed5a03d0dfb8954f037ab0e91089818715f2e->leave($__internal_b46331e0ac30ec03408014d5e36ed5a03d0dfb8954f037ab0e91089818715f2e_prof);

    }

    public function getTemplateName()
    {
        return ":Admin:layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  134 => 28,  127 => 32,  122 => 29,  120 => 28,  116 => 26,  114 => 25,  111 => 24,  105 => 23,  94 => 18,  88 => 15,  84 => 14,  80 => 13,  75 => 12,  69 => 11,  60 => 8,  56 => 7,  52 => 6,  48 => 5,  43 => 4,  37 => 3,  11 => 1,);
    }
}
/* {% extends 'base.html.twig' %}*/
/* */
/* {% block stylesheets %}*/
/*     <link rel="stylesheet" href="{{ asset('css/admin.css') }}">*/
/*     <link rel="stylesheet" href="{{ asset('css/timeline.css') }}">*/
/*     <link rel="stylesheet" href="{{ asset('css/sb-admin-2.css') }}">*/
/*     <link rel="stylesheet" href="{{ asset('css/morris.css') }}">*/
/*     <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">*/
/* {% endblock %}*/
/* */
/* {% block javascripts %}*/
/*     <script src="{{ asset('js/metisMenu.min.js') }}"></script>*/
/*     <script src="{{ asset('js/raphael-min.js') }}"></script>*/
/*     <script src="{{ asset('js/morris.min.js') }}"></script>*/
/*     <script src="{{ asset('js/sb-admin-2.js') }}"></script>*/
/*     <script>*/
/*         window.prossimo = {*/
/*             api_base_path: '{{ api_base_path }}'*/
/*         };*/
/*     </script>*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     <div id="wrapper">*/
/*         {% include(":Admin/include:nav.html.twig") %}*/
/* */
/*         <div id="page-wrapper" style="min-height: 875px;">*/
/*         {% block content %}{% endblock %}*/
/*         </div>*/
/*     </div>*/
/* */
/*     {% include(':Admin/include:footer.html.twig') %}*/
/* {% endblock %}*/
