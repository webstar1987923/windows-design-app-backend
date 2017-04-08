<?php

/* ::_flash.html.twig */
class __TwigTemplate_6831d04c7f7a7cce400cb212b0988694b59a318d463eba3bfeb300e115280490 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_a44aabb1f54b4ac658bc04d652f8349ad66031da5054c4f3483ee3d3c46f0c71 = $this->env->getExtension("native_profiler");
        $__internal_a44aabb1f54b4ac658bc04d652f8349ad66031da5054c4f3483ee3d3c46f0c71->enter($__internal_a44aabb1f54b4ac658bc04d652f8349ad66031da5054c4f3483ee3d3c46f0c71_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::_flash.html.twig"));

        // line 1
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "session", array()), "flashBag", array()), "all", array()));
        foreach ($context['_seq'] as $context["type"] => $context["messages"]) {
            // line 2
            echo "    ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($context["messages"]);
            foreach ($context['_seq'] as $context["_key"] => $context["message"]) {
                // line 3
                echo "        <div class=\"";
                echo twig_escape_filter($this->env, $context["type"], "html", null, true);
                echo "\">
            ";
                // line 4
                echo twig_escape_filter($this->env, $context["message"], "html", null, true);
                echo "
        </div>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['message'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['type'], $context['messages'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        
        $__internal_a44aabb1f54b4ac658bc04d652f8349ad66031da5054c4f3483ee3d3c46f0c71->leave($__internal_a44aabb1f54b4ac658bc04d652f8349ad66031da5054c4f3483ee3d3c46f0c71_prof);

    }

    public function getTemplateName()
    {
        return "::_flash.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  36 => 4,  31 => 3,  26 => 2,  22 => 1,);
    }
}
/* {% for type, messages in app.session.flashBag.all %}*/
/*     {% for message in messages %}*/
/*         <div class="{{ type }}">*/
/*             {{ message }}*/
/*         </div>*/
/*     {% endfor %}*/
/* {% endfor %}*/
