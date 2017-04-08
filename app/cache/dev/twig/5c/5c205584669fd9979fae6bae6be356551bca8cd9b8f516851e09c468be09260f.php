<?php

/* FOSUserBundle:Security:login.html.twig */
class __TwigTemplate_7b90455b58fa0d4dba7ee28c72e03ee0c1e92ec51c1b6c053baa1013145be450 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 12
        $this->parent = $this->loadTemplate("FOSUserBundle::layout.html.twig", "FOSUserBundle:Security:login.html.twig", 12);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'content' => array($this, 'block_content'),
            'fos_user_content' => array($this, 'block_fos_user_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSUserBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_e58741a8111403b69eab793735799a5230ee35f05770c03415bd20f5fca787d3 = $this->env->getExtension("native_profiler");
        $__internal_e58741a8111403b69eab793735799a5230ee35f05770c03415bd20f5fca787d3->enter($__internal_e58741a8111403b69eab793735799a5230ee35f05770c03415bd20f5fca787d3_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "FOSUserBundle:Security:login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_e58741a8111403b69eab793735799a5230ee35f05770c03415bd20f5fca787d3->leave($__internal_e58741a8111403b69eab793735799a5230ee35f05770c03415bd20f5fca787d3_prof);

    }

    // line 14
    public function block_title($context, array $blocks = array())
    {
        $__internal_f778480428d36fd0dca9f4d48273bd459d4d80321acc49b737f2da262b693375 = $this->env->getExtension("native_profiler");
        $__internal_f778480428d36fd0dca9f4d48273bd459d4d80321acc49b737f2da262b693375->enter($__internal_f778480428d36fd0dca9f4d48273bd459d4d80321acc49b737f2da262b693375_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Prossimo login";
        
        $__internal_f778480428d36fd0dca9f4d48273bd459d4d80321acc49b737f2da262b693375->leave($__internal_f778480428d36fd0dca9f4d48273bd459d4d80321acc49b737f2da262b693375_prof);

    }

    // line 16
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_0c4859bf0b26c0fb16229b9b1a23e921483509cc8ba54fc0350b21c9facceaac = $this->env->getExtension("native_profiler");
        $__internal_0c4859bf0b26c0fb16229b9b1a23e921483509cc8ba54fc0350b21c9facceaac->enter($__internal_0c4859bf0b26c0fb16229b9b1a23e921483509cc8ba54fc0350b21c9facceaac_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 17
        echo "    <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/signin.css"), "html", null, true);
        echo "\">
";
        
        $__internal_0c4859bf0b26c0fb16229b9b1a23e921483509cc8ba54fc0350b21c9facceaac->leave($__internal_0c4859bf0b26c0fb16229b9b1a23e921483509cc8ba54fc0350b21c9facceaac_prof);

    }

    // line 20
    public function block_content($context, array $blocks = array())
    {
        $__internal_efb20f2b5656ee91724a079229aede6a23c06ef083d1ad39054213eae93ee772 = $this->env->getExtension("native_profiler");
        $__internal_efb20f2b5656ee91724a079229aede6a23c06ef083d1ad39054213eae93ee772->enter($__internal_efb20f2b5656ee91724a079229aede6a23c06ef083d1ad39054213eae93ee772_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "content"));

        // line 21
        echo "    <h1 class=\"text-center\"><span>Welcome to</span> Prossimo<br /><small>Please define your credentials</small></h1>

    ";
        // line 23
        $this->displayBlock('fos_user_content', $context, $blocks);
        
        $__internal_efb20f2b5656ee91724a079229aede6a23c06ef083d1ad39054213eae93ee772->leave($__internal_efb20f2b5656ee91724a079229aede6a23c06ef083d1ad39054213eae93ee772_prof);

    }

    public function block_fos_user_content($context, array $blocks = array())
    {
        $__internal_1d10e6e0c58a52f3a3f19815825fabcec7ab3874811753bf2957bd68f7e20c67 = $this->env->getExtension("native_profiler");
        $__internal_1d10e6e0c58a52f3a3f19815825fabcec7ab3874811753bf2957bd68f7e20c67->enter($__internal_1d10e6e0c58a52f3a3f19815825fabcec7ab3874811753bf2957bd68f7e20c67_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "fos_user_content"));

        // line 24
        echo "        ";
        if ((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error"))) {
            // line 25
            echo "            <div>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["error"]) ? $context["error"] : $this->getContext($context, "error")), array(), "FOSUserBundle"), "html", null, true);
            echo "</div>
        ";
        }
        // line 27
        echo "
        <form action=\"";
        // line 28
        echo $this->env->getExtension('routing')->getPath("fos_user_security_check");
        echo "\" method=\"post\" class=\"form-signin\">
            <h2 class=\"form-signin-heading\">Please sign in</h2>

            <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 31
        echo twig_escape_filter($this->env, (isset($context["csrf_token"]) ? $context["csrf_token"] : $this->getContext($context, "csrf_token")), "html", null, true);
        echo "\" />

            <label for=\"username\" class=\"sr-only\">";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.username", array(), "FOSUserBundle"), "html", null, true);
        echo "</label>
            <input type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["last_username"]) ? $context["last_username"] : $this->getContext($context, "last_username")), "html", null, true);
        echo "\" required=\"required\" class=\"form-control\" />

            <label for=\"password\" class=\"sr-only\">";
        // line 36
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.password", array(), "FOSUserBundle"), "html", null, true);
        echo "</label>
            <input type=\"password\" id=\"password\" name=\"_password\" required=\"required\" class=\"form-control\"  />

            <div class=\"checkbox\">
                <label>
                    <input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" value=\"on\" />
                    ";
        // line 42
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.remember_me", array(), "FOSUserBundle"), "html", null, true);
        echo "
                </label>
            </div>

            <button type=\"submit\" id=\"_submit\" name=\"_submit\" class=\"btn btn-lg btn-primary btn-block\" >";
        // line 46
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("security.login.submit", array(), "FOSUserBundle"), "html", null, true);
        echo "</button>
        </form>
    ";
        
        $__internal_1d10e6e0c58a52f3a3f19815825fabcec7ab3874811753bf2957bd68f7e20c67->leave($__internal_1d10e6e0c58a52f3a3f19815825fabcec7ab3874811753bf2957bd68f7e20c67_prof);

    }

    public function getTemplateName()
    {
        return "FOSUserBundle:Security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 46,  128 => 42,  119 => 36,  114 => 34,  110 => 33,  105 => 31,  99 => 28,  96 => 27,  90 => 25,  87 => 24,  75 => 23,  71 => 21,  65 => 20,  55 => 17,  49 => 16,  37 => 14,  11 => 12,);
    }
}
/* {#*/
/* */
/* This file is part of the Sonata package.*/
/* */
/* (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>*/
/* */
/* For the full copyright and license information, please view the LICENSE*/
/* file that was distributed with this source code.*/
/* */
/* #}*/
/* */
/* {% extends "FOSUserBundle::layout.html.twig" %}*/
/* */
/* {% block title %}Prossimo login{% endblock %}*/
/* */
/* {% block stylesheets %}*/
/*     <link rel="stylesheet" href="{{ asset('css/signin.css') }}">*/
/* {% endblock %}*/
/* */
/* {% block content %}*/
/*     <h1 class="text-center"><span>Welcome to</span> Prossimo<br /><small>Please define your credentials</small></h1>*/
/* */
/*     {% block fos_user_content %}*/
/*         {% if error %}*/
/*             <div>{{ error|trans({}, 'FOSUserBundle') }}</div>*/
/*         {% endif %}*/
/* */
/*         <form action="{{ path("fos_user_security_check") }}" method="post" class="form-signin">*/
/*             <h2 class="form-signin-heading">Please sign in</h2>*/
/* */
/*             <input type="hidden" name="_csrf_token" value="{{ csrf_token }}" />*/
/* */
/*             <label for="username" class="sr-only">{{ 'security.login.username'|trans({}, 'FOSUserBundle') }}</label>*/
/*             <input type="text" id="username" name="_username" value="{{ last_username }}" required="required" class="form-control" />*/
/* */
/*             <label for="password" class="sr-only">{{ 'security.login.password'|trans({}, 'FOSUserBundle') }}</label>*/
/*             <input type="password" id="password" name="_password" required="required" class="form-control"  />*/
/* */
/*             <div class="checkbox">*/
/*                 <label>*/
/*                     <input type="checkbox" id="remember_me" name="_remember_me" value="on" />*/
/*                     {{ 'security.login.remember_me'|trans({}, 'FOSUserBundle') }}*/
/*                 </label>*/
/*             </div>*/
/* */
/*             <button type="submit" id="_submit" name="_submit" class="btn btn-lg btn-primary btn-block" >{{ 'security.login.submit'|trans({}, 'FOSUserBundle') }}</button>*/
/*         </form>*/
/*     {% endblock fos_user_content %}*/
/* {% endblock %}*/
/* */
