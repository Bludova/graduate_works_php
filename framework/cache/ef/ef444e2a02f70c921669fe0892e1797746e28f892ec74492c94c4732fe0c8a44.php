<?php

/* index.html */
class __TwigTemplate_116134a97b166041bccfaed915682a31a060c9fec8f4079c51a45c64933ebbec extends Twig_Template
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
        // line 1
        echo "﻿<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
  <!--  <title> ";
        // line 5
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</title> -->
     <!--   <title>Страница шаблонизатора</title> -->
</head>
<body>
<h1>Привет из файло шаблонизатора!</h1>
<p>";
        // line 10
        echo twig_escape_filter($this->env, ($context["title"] ?? null), "html", null, true);
        echo "</p>

  ";
        // line 12
        $this->loadTemplate("new.html", "index.html", 12)->display($context);
        // line 13
        echo "</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 13,  38 => 12,  33 => 10,  25 => 5,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "index.html", "C:\\OpenServer\\domains\\test\\graduate_work_php\\templates\\index.html");
    }
}
